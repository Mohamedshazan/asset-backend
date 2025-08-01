<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\SupportRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    /**
     * Admin dashboard summary: assets and support stats.
     */
    public function adminSummary(): JsonResponse
    {
        $totalAssets = Asset::count();
        $assignedAssets = Asset::whereNotNull('user_id')->count();
        $backupAssets = Asset::where('status', 'backup')->count();

        $supportPending = SupportRequest::where('status', 'pending')->count();
        $supportInProgress = SupportRequest::where('status', 'In Progress')->count();
        $supportResolved = SupportRequest::where('status', 'resolved')->count();

        $assetsByDepartment = Asset::with('department')
            ->get()
            ->groupBy(fn($asset) => optional($asset->department)->name ?? 'Unassigned')
            ->map(fn($group) => $group->count());

        $assetsByType = Asset::all()
            ->groupBy('asset_type')
            ->map(fn($group) => $group->count());

        return response()->json([
            'totalAssets' => $totalAssets,
            'assignedAssets' => $assignedAssets,
            'backupAssets' => $backupAssets,
            'supportPending' => $supportPending,
            'supportInProgress' => $supportInProgress,
            'supportResolved' => $supportResolved,
            'assetsByDepartment' => $assetsByDepartment,
            'assetsByType' => $assetsByType,
        ]);
    }

    /**
     * Employee dashboard: fetch assigned assets and support requests.
     */
    public function employeeDashboard(Request $request): JsonResponse
    {
        $user = $request->user();

        try {
            $assignedAssets = $user->assignedAssets()
                ->select('id', 'device_name', 'model', 'asset_type', 'serial_number')
                ->get();

            $supportRequests = $user->supportRequests()
                ->select('id', 'subject', 'priority', 'status', 'created_at')
                ->latest()
                ->get();

            return response()->json([
                'assignedAssets' => $assignedAssets,
                'supportRequests' => $supportRequests,
            ]);
        } catch (\Throwable $e) {
            Log::error('❌ Employee dashboard failed', [
                'user_id' => $user->id ?? null,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'message' => 'Something went wrong.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }
}
