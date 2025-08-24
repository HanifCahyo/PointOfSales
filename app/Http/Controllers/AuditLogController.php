<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AuditLog;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;


class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditLog::with('user')->latest();

        // Apply filters
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
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

        $logs = $query->paginate(20)->withQueryString();
        $users = User::orderBy('name')->get();

        return view('admin.audit-logs.index', compact('logs', 'users'));
    }

    public function exportExcel(Request $request)
    {
        try {
            $filename = 'audit-logs-' . now()->format('Y-m-d-H-i-s') . '.xlsx';
            return Excel::download(new \App\Exports\AuditLogExport($request), $filename);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to export Excel file: ' . $e->getMessage());
        }
    }

    public function exportPdf(Request $request)
    {
        try {
            $query = AuditLog::with('user')->latest();

            // Apply same filters as index
            if ($request->filled('user_id')) {
                $query->where('user_id', $request->user_id);
            }

            if ($request->filled('action')) {
                $query->where('action', $request->action);
            }

            if ($request->filled('from_date')) {
                $query->whereDate('created_at', '>=', $request->from_date);
            }

            if ($request->filled('to_date')) {
                $query->whereDate('created_at', '<=', $request->to_date);
            }

            if ($request->filled('search')) {
                $search = $request->search;
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

            $logs = $query->get();

            $pdf = Pdf::loadView('admin.audit-logs.pdf', compact('logs'))
                ->setPaper('a4', 'landscape')
                ->setOptions(['defaultFont' => 'sans-serif']);

            $filename = 'audit-logs-' . now()->format('Y-m-d-H-i-s') . '.pdf';

            return $pdf->download($filename);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to export PDF file: ' . $e->getMessage());
        }
    }
}
