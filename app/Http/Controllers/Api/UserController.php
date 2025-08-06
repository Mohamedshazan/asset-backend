<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use App\Mail\AssetAgreementMail;
use Illuminate\Support\Facades\Mail;

use App\Models\Asset;

class UserController extends Controller
{
    /**
     * List all users with department info (Admin only)
     */
    public function index()
    {
        return response()->json(User::with('department','assignedAssets')->get());
    }

    /**
     * Show a single user
     */
    public function show($id)
    {
        $user = User::with('department')->find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json($user);
    }

    /**
     * Admin-only: Register a new user
     */
    public function register(Request $request)
    {
        $currentUser = Auth::user();
        if (!$currentUser || $currentUser->role !== 'Admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:Admin,IT,Head,Employee',
            'department_id' => 'nullable|exists:departments,id',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'department_id' => $validated['department_id'] ?? null,
        ]);

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user
        ], 201);
    }

    /**
     * Admin-only: Update an existing user
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$id}",
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:Admin,IT,Head,Employee',
            'department_id' => 'nullable|exists:departments,id',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        $user->department_id = $validated['department_id'] ?? null;

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user
        ]);
    }

    /**
     * Admin-only: Delete a user
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }

    /**
     * Update the authenticated user's own profile (name + optional avatar)
     */
    public function updateProfile(Request $request)
    {
        Log::info('🌟 RAW INPUT:', $request->all());

        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        Log::info('AUTH USER:', ['user' => $user]);

        if (!$user) {
            Log::error('❌ No authenticated user.');
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user->name = $validated['name'];

        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save();

        // Auto-run storage:link if missing
        $publicStoragePath = public_path('storage');
        if (!File::exists($publicStoragePath)) {
            try {
                Artisan::call('storage:link');
                Log::info('✅ storage:link command executed automatically.');
            } catch (\Exception $e) {
                Log::error('❌ Failed to run storage:link: ' . $e->getMessage());
            }
        }

        return response()->json([
            'name' => $user->name,
            'avatarUrl' => $user->avatar ? asset('storage/' . $user->avatar) : null,
            'role' => $user->role ?? 'Employee',
        ]);
    }




 public function assetsAgreement($id)
{
    \Log::info("assetsAgreement called for user id: $id");

    /** @var \App\Models\User $authUser */
    $authUser = Auth::user();

    // Role check: Admin & IT can see any user, Employee can only see own data
    if (!in_array($authUser->role, ['Admin', 'IT']) && $authUser->id != $id) {
        \Log::warning("User {$authUser->id} tried to access assetsAgreement for $id without permission");
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    $user = User::with([
        'department',
        'assignedAssets' => function ($query) {
            $query->select('id', 'user_id', 'asset_type', 'brand', 'model', 'device_name', 'os', 'serial_number', 'status', 'location', 'created_at as assigned_at');
        },
        'oldAssets' => function ($query) {
            $query->select('id', 'user_id', 'asset_type', 'brand', 'model', 'device_name', 'os', 'serial_number', 'status', 'location', 'updated_at as returned_at');
        }
    ])->find($id);

    if (!$user) {
        \Log::warning("User $id not found");
        return response()->json(['message' => 'User not found'], 404);
    }

    \Log::info("User found: " . $user->name);

    return response()->json([
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'department' => $user->department ? $user->department->name : null,
            'avatarUrl' => $user->avatar ? asset('storage/' . $user->avatar) : null,
        ],
        'assignedAssets' => $user->assignedAssets,
        'oldAssets' => $user->oldAssets ?? [],
    ]);
}





public function assetAgreementPdf($userId, $assetId)
{
    $user = User::findOrFail($userId);
    $asset = Asset::findOrFail($assetId);

    $pdf = Pdf::loadView('pdf.asset_agreement', [
        'user' => $user,
        'asset' => $asset,
        'date' => now()->format('Y/m/d')
    ]);

    return $pdf->download("Asset_Agreement_{$asset->id}.pdf");
}



public function sendAssetAgreementEmail($userId, $assetId)
{
    $user = User::findOrFail($userId);
    $asset = Asset::findOrFail($assetId);

    // Generate PDF content as string
    $pdf = Pdf::loadView('pdf.asset_agreement', [
        'user' => $user,
        'asset' => $asset,
        'date' => now()->format('Y/m/d')
    ]);

    $pdfContent = $pdf->output();

    // Send email with PDF attachment
    Mail::to($user->email)->send(new AssetAgreementMail($user, $asset, $pdfContent));

    return response()->json(['message' => 'Asset agreement email sent successfully.']);
}




}
