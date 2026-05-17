<?php

namespace App\Http\Controllers\Admin;
use App\Models\NomineeApplication;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Inertia\Inertia;

class NomineeApplicationController extends Controller
{
    /**
     * Onyesha orodha ya maombi yote.
     */
    public function index(Request $request)
    {
        $applications = NomineeApplication::query()
            ->select(['id', 'applicant_name', 'business_name', 'status', 'photo_path', 'created_at', 'user_id', 'category_id', 'reviewed_by'])
            ->selectRaw("
                CASE WHEN LENGTH(applicant_name) > 20 THEN CONCAT(SUBSTRING(applicant_name, 1, 20), '...') ELSE applicant_name END as applicant_name_display,
                CASE WHEN LENGTH(business_name) > 20 THEN CONCAT(SUBSTRING(business_name, 1, 20), '...') ELSE business_name END as business_name_display
            ")
            ->with(['user:id,name', 'category:id,name', 'transaction:id,status', 'reviewer:id,name']) // BORESHO: Ongeza reviewer
            ->when($request->input('search'), function ($query, $search) {
                $query->where('applicant_name', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($q) => $q->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('category', fn($q) => $q->where('name', 'like', "%{$search}%"));
            })
            ->when($request->input('status'), function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return Inertia::render('Admin/Applications/Index', [
            'applications' => $applications,
            'filters' => $request->only(['search', 'status']),
        ]);
    }

    /**
     * Onyesha taarifa za ombi moja.
     */
    public function show(NomineeApplication $application)
    {
        $application->load(['user', 'category', 'transaction']);
        return Inertia::render('Admin/Applications/Show', [
            'application' => $application,
        ]);
    }

    /**
     * Sasisha status ya ombi (Kubali/Kataa).
     */
    public function update(Request $request, NomineeApplication $application)
    {
        $validated = $request->validate([
            'action' => 'required|in:approve,reject',
            'rejection_reason' => 'nullable|string|required_if:action,reject',
        ]);

        try {
            if ($validated['action'] === 'approve') {
                // BORESHO: Tumia DB Transaction kuhakikisha hatua zote zinafanikiwa pamoja.
                // Hii inazuia application kuwa 'approved' kama Nominee hajaundwa.
                DB::transaction(function () use ($application) {
                    // 1. Badilisha status ya ombi
                    $application->update([
                        'status' => 'approved',
                        'reviewed_by' => auth()->id(), // Rekodi ID ya admin
                        'reviewed_at' => now(),
                    ]);

                    // 2. Andaa data za pre-fill kwa ajili ya fomu ya kuunda Nominee
                    $prefillData = [
                        'name' => $application->applicant_name,
                        'bio' => $application->bio,
                        'category_id' => $application->category_id,
                        'image_path' => $application->photo_path, // Tumia photo_path
                        'source_application_id' => $application->id, // Tuma ID ya ombi kwa ajili ya reference
                        'facebook_url' => $application->facebook_url,
                        'instagram_url' => $application->instagram_url,
                        'tiktok_url' => $application->tiktok_url,
                    ];

                    // Weka data ya prefill kwenye session ili itumike kwenye ukurasa wa 'nominees.create'
                    session()->flash('prefill', $prefillData);
                });

                return redirect()->route('admin.nominees.create');
            }

            if ($validated['action'] === 'reject') {
                $application->update([
                    'status' => 'rejected',
                    'rejection_reason' => $validated['rejection_reason'],
                    'reviewed_by' => auth()->id(), // Rekodi ID ya admin
                    'reviewed_at' => now(),
                ]);
                return redirect()->route('admin.applications.index')->with('success', 'Ombi limekataliwa kikamilifu.');
            }
        } catch (\Exception $e) {
            \Log::error('Failed to update application status: ' . $e->getMessage());
            return back()->with('error', 'Kuna kosa la kiufundi limetokea. Tafadhali jaribu tena.');
        }
        return redirect()->route('admin.applications.index')->with('error', 'Kitendo hakijulikani.');
    }

    /**
     * Export applications data to a PDF file with landscape orientation.
     */
    public function exportPdf(Request $request)
    {
        // Increase memory limit for PDF generation (reasonable amount)
        ini_set('memory_limit', '256M');

        $titleParts = ['Ripoti ya Maombi ya Ushiriki'];

        $applications = NomineeApplication::query()
            ->with(['user:id,name', 'category:id,name', 'transaction:status'])
            ->when($request->input('search'), function ($query, $search) use (&$titleParts) {
                $query->where('applicant_name', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($q) => $q->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('category', fn($q) => $q->where('name', 'like', "%{$search}%"));
                $titleParts[] = 'kwa "' . $search . '"';
            })
            ->when($request->input('status'), function ($query, $status) use (&$titleParts) {
                $query->where('status', $status);
                $titleParts[] = 'yenye status "' . str_replace('_', ' ', $status) . '"';
            })
            ->latest()
            ->get();

        $title = count($titleParts) > 1 ? implode(' ', $titleParts) : 'Ripoti ya Maombi Yote';

        $data = [
            'title' => $title,
            'date' => now()->setTimezone('Africa/Nairobi')->format('d M, Y H:i'),
            'applications' => $applications,
            'filters' => $request->only(['search', 'status']),
        ];

        $pdf = PDF::loadView('reports.applications_pdf', $data);
        $pdf->setPaper('A4', 'landscape');
        $slug = 'applications-report-' . now()->format('Y-m-d');

        return $pdf->download($slug . '.pdf');
    }

    /**
     * Export applicant photos as ZIP with original quality, renamed by applicant name + category name.
     * If no photo, generates a default image with the applicant's name.
     * Supports filters from table.
     */
    public function exportPhotos(Request $request)
    {
        $applications = NomineeApplication::query()
            ->with(['category:id,name'])
            ->when($request->input('search'), function ($query, $search) {
                $query->where('applicant_name', 'like', "%{$search}%");
            })
            ->when($request->input('status'), function ($query, $status) {
                $query->where('status', $status);
            })
            ->get();

        if ($applications->isEmpty()) {
            return back()->with('error', 'No applications found matching the filters.');
        }

        $zipDirectory = storage_path('app/temp');
        if (!is_dir($zipDirectory)) {
            mkdir($zipDirectory, 0755, true);
        }

        $zipFilename = 'applicant-photos-' . now()->format('Y-m-d-His') . '.zip';
        $zipPath = $zipDirectory . DIRECTORY_SEPARATOR . $zipFilename;

        if (file_exists($zipPath)) {
            unlink($zipPath);
        }

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            return back()->with('error', 'Failed to create ZIP file.');
        }

        $tempFiles = [];
        $fileCount = 0;

        foreach ($applications as $application) {
            $categoryName = $application->category ? $application->category->name : 'Unknown';
            $safeCategoryName = $this->sanitizeFilename($categoryName ?: 'Unknown');
            $safeApplicantName = $this->sanitizeFilename($application->applicant_name ?: 'unknown_applicant');
            $fileName = $safeApplicantName . '_' . $safeCategoryName;

            $photoPath = $this->resolvePhotoPath($application->photo_path);
            if ($photoPath && file_exists($photoPath)) {
                $extension = pathinfo($photoPath, PATHINFO_EXTENSION) ?: 'jpg';
                if ($zip->addFile($photoPath, $fileName . '.' . $extension)) {
                    $fileCount++;
                    continue;
                }
            }

            $tempImagePath = $this->generateDefaultImage($application->applicant_name, $categoryName);
            if ($tempImagePath && file_exists($tempImagePath)) {
                if ($zip->addFile($tempImagePath, $fileName . '.png')) {
                    $tempFiles[] = $tempImagePath;
                    $fileCount++;
                }
            }
        }

        if ($fileCount === 0) {
            $zip->close();
            return back()->with('error', 'No valid photos were available to export.');
        }

        $closed = $zip->close();
        foreach ($tempFiles as $tempFile) {
            if (file_exists($tempFile)) {
                unlink($tempFile);
            }
        }

        if (! $closed || ! file_exists($zipPath)) {
            return back()->with('error', 'Failed to finalize the ZIP archive.');
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    private function resolvePhotoPath(?string $photoPath): ?string
    {
        if (empty($photoPath)) {
            return null;
        }

        $path = ltrim($photoPath, '/\\');
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->path($path);
        }

        return null;
    }

    private function sanitizeFilename(string $value): string
    {
        $value = preg_replace('/[^A-Za-z0-9 _\-.]/', '_', $value);
        $value = preg_replace('/[\s]+/', '_', trim($value));
        return substr($value, 0, 120) ?: 'unknown';
    }

    /**
     * Generate a default image with the applicant's name and category.
     */
    private function generateDefaultImage($applicantName, $categoryName)
    {
        $width = 400;
        $height = 400;

        // Create image
        $image = imagecreatetruecolor($width, $height);

        // Colors
        $bgColor = imagecolorallocate($image, 240, 240, 240); // Light gray
        $textColor = imagecolorallocate($image, 0, 0, 0); // Black

        // Fill background
        imagefill($image, 0, 0, $bgColor);

        // Add text
        $fontSize = 5; // Built-in font size (1-5)
        $text = $applicantName;
        $categoryText = '(' . $categoryName . ')';

        // Center applicant name
        $textWidth = imagefontwidth($fontSize) * strlen($text);
        $x = ($width - $textWidth) / 2;
        $y = $height / 2 - 20;
        imagestring($image, $fontSize, $x, $y, $text, $textColor);

        // Center category
        $categoryWidth = imagefontwidth($fontSize) * strlen($categoryText);
        $x2 = ($width - $categoryWidth) / 2;
        $y2 = $height / 2 + 10;
        imagestring($image, $fontSize, $x2, $y2, $categoryText, $textColor);

        // Save to temp file
        $tempDir = storage_path('app/temp/');
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0755, true);
        }
        $tempPath = $tempDir . uniqid() . '.png';
        imagepng($image, $tempPath);
        imagedestroy($image);

        return $tempPath;
    }
}

