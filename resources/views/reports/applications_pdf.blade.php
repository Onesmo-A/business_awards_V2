<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $title }}</title>
    <style>
        * { margin: 0; padding: 0; }
        body { 
            font-family: 'DejaVu Sans', sans-serif; 
            font-size: 9px; 
            color: #333;
            line-height: 1.4;
        }
        
        .header {
            margin-bottom: 15px;
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 10px;
        }
        
        h1 { 
            font-size: 16px;
            text-align: center; 
            margin-bottom: 5px;
            color: #2c3e50;
        }
        
        .report-meta {
            display: flex;
            justify-content: space-between;
            font-size: 8px;
            margin-top: 8px;
            color: #666;
        }
        
        .filters {
            margin: 8px 0;
            padding: 6px;
            background-color: #ecf0f1;
            border-radius: 3px;
            font-size: 8px;
        }
        
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px;
        }
        
        th { 
            background-color: #2c3e50; 
            color: white;
            padding: 6px 4px; 
            text-align: left; 
            font-size: 8px;
            font-weight: bold;
            border: 1px solid #2c3e50;
        }
        
        td { 
            padding: 5px 4px; 
            border-bottom: 1px solid #ddd;
            font-size: 8px;
        }

        .bio-column {
            max-width: 200px;
            white-space: normal;
            word-wrap: break-word;
            line-height: 1.2;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        tr:hover {
            background-color: #f0f0f0;
        }
        
        .photo-cell {
            text-align: center;
        }
        
        .photo {
            width: 45px;
            height: 45px;
            border-radius: 3px;
            border: 1px solid #bbb;
            display: inline-block;
            object-fit: cover;
            background-color: #f0f0f0;
        }
        
        .status {
            text-transform: capitalize;
            padding: 2px 4px;
            border-radius: 2px;
            font-weight: bold;
            font-size: 7px;
        }
        
        .status-pending_payment {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status-pending_review {
            background-color: #cfe2ff;
            color: #084298;
        }
        
        .status-approved {
            background-color: #d1e7dd;
            color: #0f5132;
        }
        
        .status-rejected {
            background-color: #f8d7da;
            color: #842029;
        }
        
        .status-payment_failed {
            background-color: #f8d7da;
            color: #842029;
        }
        
        .payment-free {
            background-color: #d1e7dd;
            color: #0f5132;
        }
        
        .payment-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .text-muted {
            color: #999;
        }
        
        .no-data {
            text-align: center;
            padding: 20px;
            color: #999;
        }

        @page {
            margin: 8mm;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📋 {{ $title }}</h1>
        <div class="report-meta">
            <span><strong>Tarehe:</strong> {{ $date }}</span>
            <span><strong>Jumla ya Maombi:</strong> {{ count($applications) }}</span>
        </div>
    </div>

    @if($filters['search'] ?? false)
        <div class="filters">
            <strong>🔍 Kichujio:</strong> "{{ $filters['search'] }}"
            @if($filters['status'] ?? false)
                | <strong>Status:</strong> {{ str_replace('_', ' ', $filters['status']) }}
            @endif
        </div>
    @elseif($filters['status'] ?? false)
        <div class="filters">
            <strong>📊 Status:</strong> {{ str_replace('_', ' ', $filters['status']) }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th style="width: 3%">#</th>
                <th style="width: 14%">Jina la Mtumiaji</th>
                <th style="width: 20%">Bio/Maelezo</th>
                <th style="width: 12%">Jina la Biashara</th>
                <th style="width: 10%">Kategoria</th>
                <th style="width: 9%">S/N</th>
                <th style="width: 9%">Mahali</th>
                <th style="width: 11%">Hali</th>
                <th style="width: 8%">Malipo</th>
                <th style="width: 12%">Tarehe</th>
            </tr>
        </thead>
        <tbody>
            @forelse($applications as $application)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td><strong>{{ $application->applicant_name }}{{ $application->age ? ' (' . $application->age . ')' : '' }}</strong></td>
                <td class="bio-column">{{ $application->bio ?? '-' }}</td>
                <td>{{ $application->business_name ?? '-' }}</td>
                <td>{{ $application->category->name ?? 'N/A' }}</td>
                <td class="text-muted">{{ $application->applicant_phone }}</td>
                <td class="text-muted">{{ $application->city }}</td>
                <td>
                    <span class="status status-{{ str_replace(' ', '_', $application->status) }}">
                        {{ str_replace('_', ' ', $application->status) }}
                    </span>
                </td>
                <td>
                    <span class="status payment-{{ strtolower($application->transaction->status ?? 'Free') }}">
                        {{ $application->transaction->status ?? 'Free' }}
                    </span>
                </td>
                <td class="text-muted">{{ $application->created_at->format('d M, Y H:i') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="10" class="no-data">No applications found matching criteria.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
