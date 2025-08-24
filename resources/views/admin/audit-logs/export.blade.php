<table>
    <thead>
        <tr>
            <th style="background-color: #f3f4f6; font-weight: bold; border: 1px solid #d1d5db; padding: 8px;">User Name
            </th>
            <th style="background-color: #f3f4f6; font-weight: bold; border: 1px solid #d1d5db; padding: 8px;">User Email
            </th>
            <th style="background-color: #f3f4f6; font-weight: bold; border: 1px solid #d1d5db; padding: 8px;">Action
            </th>
            <th style="background-color: #f3f4f6; font-weight: bold; border: 1px solid #d1d5db; padding: 8px;">Table Name
            </th>
            <th style="background-color: #f3f4f6; font-weight: bold; border: 1px solid #d1d5db; padding: 8px;">Record ID
            </th>
            <th style="background-color: #f3f4f6; font-weight: bold; border: 1px solid #d1d5db; padding: 8px;">Old Values
            </th>
            <th style="background-color: #f3f4f6; font-weight: bold; border: 1px solid #d1d5db; padding: 8px;">New Values
            </th>
            <th style="background-color: #f3f4f6; font-weight: bold; border: 1px solid #d1d5db; padding: 8px;">Date</th>
            <th style="background-color: #f3f4f6; font-weight: bold; border: 1px solid #d1d5db; padding: 8px;">Time</th>
            <th style="background-color: #f3f4f6; font-weight: bold; border: 1px solid #d1d5db; padding: 8px;">IP Address
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($logs as $log)
            <tr>
                <td style="border: 1px solid #e5e7eb; padding: 6px;">{{ $log->user?->name ?? 'System' }}</td>
                <td style="border: 1px solid #e5e7eb; padding: 6px;">{{ $log->user?->email ?? 'N/A' }}</td>
                <td style="border: 1px solid #e5e7eb; padding: 6px;">{{ ucfirst($log->action) }}</td>
                <td style="border: 1px solid #e5e7eb; padding: 6px;">{{ $log->table_name }}</td>
                <td style="border: 1px solid #e5e7eb; padding: 6px;">{{ $log->record_id }}</td>
                <td style="border: 1px solid #e5e7eb; padding: 6px;">
                    {{ $log->old_values ? json_encode($log->old_values, JSON_PRETTY_PRINT) : 'N/A' }}</td>
                <td style="border: 1px solid #e5e7eb; padding: 6px;">
                    {{ $log->new_values ? json_encode($log->new_values, JSON_PRETTY_PRINT) : 'N/A' }}</td>
                <td style="border: 1px solid #e5e7eb; padding: 6px;">{{ $log->created_at->format('Y-m-d') }}</td>
                <td style="border: 1px solid #e5e7eb; padding: 6px;">{{ $log->created_at->format('H:i:s') }}</td>
                <td style="border: 1px solid #e5e7eb; padding: 6px;">{{ $log->ip_address ?? request()->ip() }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
