<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        Log::info('✅ UserController@index triggered');
        return response()->json(User::all());
    }

    public function createRole(Request $request)
    {
        return response()->json([
            'message' => 'Role creation not implemented. Use a migration or seeder to manage roles.'
        ], 501);
    }

    /**
     * ✅ Admin-only: Register a new user
     */
    public function register(Request $request)
    {
        // Ensure only Admin can create users
        $currentUser = Auth::user();
        if (!$currentUser || $currentUser->role !== 'Admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:Admin,IT,Head,Employee',
            'department_id' => 'nullable|exists:departments,id',
        ]);

        // Create new user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'department_id' => $validated['department_id'],
        ]);

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user
        ], 201);
    }

    /**
     * Update the authenticated user's profile (name + optional avatar)
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

        $saved = $user->save();

        if ($saved) {
            Log::info("✅ User profile updated in DB: {$user->name}");
        } else {
            Log::error("❌ Failed to update user.");
        }

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
}
