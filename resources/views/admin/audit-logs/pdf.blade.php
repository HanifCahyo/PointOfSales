<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Audit Logs Report</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 20px;
        }

        .header h1 {
            font-size: 24px;
            font-weight: bold;
            color: #1f2937;
            margin: 0 0 10px 0;
        }

        .header p {
            font-size: 12px;
            color: #6b7280;
            margin: 0;
        }

        .report-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 10px;
            color: #6b7280;
        }

        .report-info div {
            flex: 1;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 8px;
        }

        th {
            background-color: #f9fafb;
            color: #374151;
            font-weight: bold;
            padding: 8px 6px;
            text-align: left;
            border: 1px solid #d1d5db;
            font-size: 8px;
        }

        td {
            padding: 6px;
            border: 1px solid #e5e7eb;
            vertical-align: top;
            word-wrap: break-word;
        }

        tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .action-badge {
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 7px;
            font-weight: bold;
            text-align: center;
            display: inline-block;
            min-width: 50px;
        }

        .action-created {
            background-color: #dcfce7;
            color: #166534;
        }

        .action-updated {
            background-color: #fef3c7;
            color: #92400e;
        }

        .action-deleted {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .table-name {
            font-family: 'Courier New', monospace;
            background-color: #f3f4f6;
            padding: 2px 4px;
            border-radius: 2px;
            font-size: 7px;
        }

        .record-id {
            font-family: 'Courier New', monospace;
            font-weight: bold;
        }

        .json-data {
            font-family: 'Courier New', monospace;
            font-size: 6px;
            max-width: 150px;
            word-break: break-all;
            background-color: #f8fafc;
            padding: 4px;
            border-radius: 2px;
        }

        .timestamp {
            font-size: 7px;
            color: #6b7280;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 8px;
            color: #9ca3af;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }

        .page-break {
            page-break-before: always;
        }

        .summary-stats {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f9fafb;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 18px;
            font-weight: bold;
            color: #1f2937;
        }

        .stat-label {
            font-size: 10px;
            color: #6b7280;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Audit Logs Report</h1>
        <p>System Activity and User Action Monitoring</p>
    </div>

    <div class="report-info">
        <div>
            <strong>Generated:</strong> {{ now()->format('F d, Y \a\t H:i:s') }}
        </div>
        <div>
            <strong>Total Records:</strong> {{ count($logs) }}
        </div>
        <div>
            <strong>Period:</strong>
            {{ request('from_date') ? \Carbon\Carbon::parse(request('from_date'))->format('M d, Y') : 'All time' }} -
            {{ request('to_date') ? \Carbon\Carbon::parse(request('to_date'))->format('M d, Y') : 'Present' }}
        </div>
    </div>

    @php
        $stats = [
            'total' => count($logs),
            'created' => $logs->where('action', 'created')->count(),
            'updated' => $logs->where('action', 'updated')->count(),
            'deleted' => $logs->where('action', 'deleted')->count(),
        ];
    @endphp

    <div class="summary-stats">
        <div class="stat-item">
            <div class="stat-number">{{ $stats['total'] }}</div>
            <div class="stat-label">Total Actions</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $stats['created'] }}</div>
            <div class="stat-label">Created</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $stats['updated'] }}</div>
            <div class="stat-label">Updated</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $stats['deleted'] }}</div>
            <div class="stat-label">Deleted</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 15%">User</th>
                <th style="width: 10%">Action</th>
                <th style="width: 12%">Table</th>
                <th style="width: 8%">Record ID</th>
                <th style="width: 25%">Old Values</th>
                <th style="width: 25%">New Values</th>
                <th style="width: 15%">Timestamp</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logs as $log)
                <tr>
                    <td>
                        <strong>{{ $log->user?->name ?? 'System' }}</strong>
                        @if ($log->user)
                            <br><small>{{ $log->user->email }}</small>
                        @endif
                    </td>
                    <td>
                        @php
                            $actionClass = 'action-' . $log->action;
                        @endphp
                        <span class="action-badge {{ $actionClass }}">
                            {{ ucfirst($log->action) }}
                        </span>
                    </td>
                    <td>
                        <span class="table-name">{{ $log->table_name }}</span>
                    </td>
                    <td class="record-id">#{{ $log->record_id }}</td>
                    <td class="json-data">
                        {{ $log->old_values ? json_encode($log->old_values, JSON_PRETTY_PRINT) : 'N/A' }}
                    </td>
                    <td class="json-data">
                        {{ $log->new_values ? json_encode($log->new_values, JSON_PRETTY_PRINT) : 'N/A' }}
                    </td>
                    <td class="timestamp">
                        {{ $log->created_at->format('M d, Y') }}<br>
                        {{ $log->created_at->format('H:i:s') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>This report was automatically generated by the Point of Sales System | Page <span class="pagenum"></span></p>
    </div>
</body>

</html>
