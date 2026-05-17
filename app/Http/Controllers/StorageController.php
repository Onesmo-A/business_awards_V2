<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StorageController extends Controller
{
    /**
     * Serve files from storage/app/public directory
     * Works on all servers (localhost, shared, dedicated, cloud)
     * 
     * Example routes:
     * /file/storage/nominee_photos/abc123.jpg
     * /file/storage/nominees/def456.jpg
     * /file/storage/post_images/ghi789.jpg
     * 
     * @param string $path The file path relative to storage/app/public
     * @return BinaryFileResponse|StreamedResponse|\Illuminate\Http\Response
     */
    public function serve($path)
    {
        // Security: Prevent directory traversal attacks (../../etc/passwd)
        $path = str_replace('..', '', $path);

        // REKEBISHO: Ondoa 'storage/' mwanzoni mwa path kama ipo.
        // Hii inahakikisha path inasomeka 'categories/image.png' badala ya 'storage/categories/image.png'
        if (strpos($path, 'storage/') === 0) {
            $path = substr($path, 8);
        }
        
        // Get the full file path from the configured public disk.
        // On shared hosting this can point directly to public_html/file/storage.
        $fullPath = Storage::disk('public')->path($path);
        
        // Verify the file exists and is readable
        if (!file_exists($fullPath) || !is_file($fullPath)) {
            abort(404, 'File not found');
        }
        
        // Verify the file is within the storage/app/public directory (security)
        $storagePath = Storage::disk('public')->path('');
        if (strpos(realpath($fullPath), realpath($storagePath)) !== 0) {
            abort(403, 'Access denied');
        }
        
        // Serve the file with proper headers
        return response()->file($fullPath, [
            'Cache-Control' => 'public, max-age=31536000', // Cache for 1 year
        ]);
    }

    /**
     * Stream a file (for large files or video streaming)
     * 
     * @param string $path The file path relative to storage/app/public
     * @return StreamedResponse|\Illuminate\Http\Response
     */
    public function stream($path)
    {
        // Security: Prevent directory traversal
        $path = str_replace('..', '', $path);
        
        if (strpos($path, 'storage/') === 0) {
            $path = substr($path, 8);
        }
        
        $fullPath = Storage::disk('public')->path($path);
        
        if (!file_exists($fullPath) || !is_file($fullPath)) {
            abort(404, 'File not found');
        }
        
        $storagePath = Storage::disk('public')->path('');
        if (strpos(realpath($fullPath), realpath($storagePath)) !== 0) {
            abort(403, 'Access denied');
        }
        
        // Get file info for headers
        $filename = basename($fullPath);
        $mimeType = mime_content_type($fullPath) ?: 'application/octet-stream';
        
        return response()->stream(
            function () use ($fullPath) {
                readfile($fullPath);
            },
            200,
            [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . basename($fullPath) . '"',
            ]
        );
    }

    /**
     * Download a file
     * 
     * @param string $path The file path relative to storage/app/public
     * @return BinaryFileResponse|\Illuminate\Http\Response
     */
    public function download($path)
    {
        // Security: Prevent directory traversal
        $path = str_replace('..', '', $path);
        
        if (strpos($path, 'storage/') === 0) {
            $path = substr($path, 8);
        }
        
        $fullPath = Storage::disk('public')->path($path);
        
        if (!file_exists($fullPath) || !is_file($fullPath)) {
            abort(404, 'File not found');
        }
        
        $storagePath = Storage::disk('public')->path('');
        if (strpos(realpath($fullPath), realpath($storagePath)) !== 0) {
            abort(403, 'Access denied');
        }
        
        return response()->download($fullPath);
    }
}
