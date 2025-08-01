<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\SupportRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AssetsExport;
use App\Exports\SupportRequestsExport;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportExportController extends Controller
{
    // Export Assets as CSV
    public function exportAssetsCsv(Request $request)
    {
        $assets = $this->filterAssets($request)->get();
        return Excel::download(new AssetsExport($assets), 'assets_report.csv');
    }

    // Export Assets as PDF
    public function exportAssetsPdf(Request $request)
    {
        $assets = $this->filterAssets($request)->get();
        $pdf = Pdf::loadView('exports.assets', compact('assets'));
        return $pdf->download('assets_report.pdf');
    }

    // Export Support Requests as CSV
    public function exportSupportCsv(Request $request)
    {
        $supportRequests = $this->filterSupportRequests($request)->get();
        return Excel::download(new SupportRequestsExport($supportRequests), 'support_requests_report.csv');
    }

    // Export Support Requests as PDF
    public function exportSupportPdf(Request $request)
    {
        $requests = $this->filterSupportRequests($request)->get();
        $pdf = Pdf::loadView('exports.support_requests', compact('requests'));
        return $pdf->download('support_requests_report.pdf');
    }

    // Shared filtering logic for Assets
    private function filterAssets(Request $request)
    {
        return Asset::with('department', 'user')
            ->when($request->department_id, fn($q) => $q->where('department_id', $request->department_id))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->asset_type, fn($q) => $q->where('asset_type', $request->asset_type))
            ->when($request->location, fn($q) => $q->where('location', 'like', '%' . $request->location . '%'))
            ->when($request->start_date && $request->end_date, function ($q) use ($request) {
                $q->whereBetween('created_at', [$request->start_date, $request->end_date]);
            });
    }

    // Shared filtering logic for Support Requests
    private function filterSupportRequests(Request $request)
    {
        return SupportRequest::with(['user', 'asset.department'])
            ->when($request->priority, fn($q) => $q->where('priority', $request->priority))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->user_id, fn($q) => $q->where('user_id', $request->user_id))
            ->when($request->department_id, function ($q) use ($request) {
                $q->whereHas('asset', fn($sub) => $sub->where('department_id', $request->department_id));
            })
            ->when($request->start_date && $request->end_date, function ($q) use ($request) {
                $q->whereBetween('created_at', [$request->start_date, $request->end_date]);
            });



            
    }

    public function reportAssets(Request $request)
{
    $query = Asset::with('department')
        ->when($request->department, fn($q) => $q->where('department_id', $request->department))
        ->when($request->asset_type, fn($q) => $q->where('asset_type', $request->asset_type))
        ->when($request->status, fn($q) => $q->where('status', $request->status))
        ->when($request->from_date, fn($q) => $q->whereDate('created_at', '>=', $request->from_date))
        ->when($request->to_date, fn($q) => $q->whereDate('created_at', '<=', $request->to_date))
        ->get();

    return response()->json($query); // <-- Add this
}

}
