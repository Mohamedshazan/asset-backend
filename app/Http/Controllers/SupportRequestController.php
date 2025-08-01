<?php

namespace App\Http\Controllers;

use App\Models\SupportRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportRequestController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!in_array($user->role, ['Admin', 'IT'])) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $requests = SupportRequest::with(['user', 'asset'])->latest()->get();

        return response()->json($requests);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'asset_id' => 'required|exists:assets,id',
                'issue' => 'required|string|max:1000',
                'priority' => 'nullable|in:Low,Medium,High',
            ]);

            $userId = auth()->id();

            $supportRequest = SupportRequest::create([
                'user_id' => $userId,
                'asset_id' => $validated['asset_id'],
                'issue' => $validated['issue'],
                'priority' => $validated['priority'] ?? 'Medium',
                'status' => 'pending',
            ]);

            return response()->json([
                'message' => 'Support request submitted successfully.',
                'data' => $supportRequest
            ], 201);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function storeForAsset(Request $request)
    {
        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'issue' => 'required|string|max:1000',
            'priority' => 'nullable|in:Low,Medium,High',
        ]);

        $userId = auth()->id();

        $supportRequest = SupportRequest::create([
            'user_id' => $userId,
            'asset_id' => $validated['asset_id'],
            'issue' => $validated['issue'],
            'priority' => $validated['priority'] ?? 'Medium',
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Asset-related support request submitted successfully.',
            'support_request' => $supportRequest
        ], 201);
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,In Progress,resolved'
        ]);

        $ticket = SupportRequest::findOrFail($id);
        $ticket->status = $validated['status'];
        $ticket->save();

        return response()->json(['message' => 'Status updated successfully']);
    }

    public function mySupportRequests(Request $request)
    {
        $userId = auth()->id();

        $requests = SupportRequest::where('user_id', $userId)
            ->with('asset')
            ->get();

        return response()->json($requests);
    }
}
