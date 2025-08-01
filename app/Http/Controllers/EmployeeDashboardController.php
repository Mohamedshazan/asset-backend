<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\SupportRequest;

class EmployeeDashboardController extends Controller
{
    /**
     * Handle the employee dashboard data fetch.
     */
    public function index(Request $request)
    {
        // Use Request's user() method — IDE-friendly
        $user = $request->user();

        // Fetch the first assigned asset
        $assignedAsset = Asset::where('assigned_to', $user->id)->first();

        $formattedAsset = null;
        if ($assignedAsset) {
            $formattedAsset = [
                'device_name' => $assignedAsset->asset_type ?? 'Unknown Device',
                'model' => $assignedAsset->model ?? 'N/A',
            ];
        }

        // Count support requests created by this employee
        $supportRequestCount = SupportRequest::where('user_id', $user->id)->count();

        return response()->json([
            'assignedAsset' => $formattedAsset,
            'supportRequestCount' => $supportRequestCount,
        ]);
    }
}
