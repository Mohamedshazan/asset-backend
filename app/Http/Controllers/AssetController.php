<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\User;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function index(Request $request)
{
    $query = Asset::with(['user', 'department']); // ✅ Eager load department

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('asset_type')) {
        $query->where('asset_type', $request->asset_type);
    }

    if ($request->filled('department_id')) {
        $query->where('department_id', $request->department_id);
    }

    if ($request->filled('user_id')) {
        $query->where('user_id', $request->user_id);
    }

    if ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
    }

    $assets = $query->orderBy('created_at', 'desc')->get();

    return response()->json(['data' => $assets]);
}


    public function store(Request $request)
    {
        $validated = $request->validate([
            'device_name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'os' => 'nullable|string|max:255',
            'serial_number' => 'required|string|max:255|unique:assets,serial_number',
            'status' => 'required|in:live,backup,to_be_disposal',
            'asset_type' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'department_id' => 'nullable|integer',
        ]);

        $asset = Asset::create($validated);

        return response()->json([
            'success' => true,
            'data' => $asset
        ]);
    }

  public function show(string $id)
{
    $asset = Asset::find($id);
    if (!$asset) {
        return response()->json(['message' => 'Asset not found'], 404);
    }

    return response()->json($asset);
}


    public function update(Request $request, $id)
    {
        $asset = Asset::findOrFail($id);

        $validated = $request->validate([
            'device_name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'os' => 'nullable|string|max:255',
            'serial_number' => 'required|string|max:255|unique:assets,serial_number,' . $id,
            'status' => 'required|in:live,backup,to_be_disposal',
            'asset_type' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'department_id' => 'nullable|integer',
        ]);

        $asset->update($validated);

        return response()->json([
            'success' => true,
            'data' => $asset
        ]);
    }

    public function destroy($id)
    {
        $asset = Asset::findOrFail($id);
        $asset->delete();

        return response()->json([
            'success' => true,
            'message' => 'Asset deleted successfully'
        ]);
    }

  public function assign(Request $request, $id)
{
    $asset = Asset::findOrFail($id);

    if ($asset->status === 'to_be_disposal') {
        return response()->json(['message' => 'Cannot assign asset marked for disposal'], 400);
    }

    $user_id = $request->input('user_id');
    $asset->user_id = $user_id;
    $asset->status = 'live';
    $asset->save();

    return response()->json(['message' => 'User assigned successfully']);
}


   public function unassign($id)
{
    $asset = Asset::findOrFail($id);
    $asset->user_id = null;
    $asset->status = 'backup';
    $asset->save();

    return response()->json(['message' => 'User unassigned successfully']);
}

}
