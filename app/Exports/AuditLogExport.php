<?php


namespace App\Exports;

use App\Models\AuditLog;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AuditLogExport implements FromView
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $query = AuditLog::with('user')->latest();

        // Apply same filters as controller
        if ($this->request->filled('user_id')) {
            $query->where('user_id', $this->request->user_id);
        }

        if ($this->request->filled('action')) {
            $query->where('action', $this->request->action);
        }

        if ($this->request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $this->request->from_date);
        }

        if ($this->request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $this->request->to_date);
        }

        if ($this->request->filled('search')) {
            $search = $this->request->search;
            $query->where(function ($q) use ($search) {
                $q->where('table_name', 'like', "%{$search}%")
                    ->orWhere('action', 'like', "%{$search}%")
                    ->orWhere('record_id', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        return view('admin.audit-logs.export', [
            'logs' => $query->get()
        ]);
    }
}
