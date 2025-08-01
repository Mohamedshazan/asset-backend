<?php



namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth; // ✅ Add this line

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
     * Update the authenticated user's profile (name + optional avatar)
     */
   public function updateProfile(Request $request)
{
    Log::info('🌟 RAW INPUT:', $request->all());

    // ✅ Get authenticated user
    /** @var \App\Models\User|null $user */
    $user = Auth::user();
    Log::info('AUTH USER:', ['user' => $user]);

    if (!$user) {
        Log::error('❌ No authenticated user.');
        return response()->json(['message' => 'User not authenticated'], 401);
    }

    // ✅ Validate request
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // ✅ Update name
    $user->name = $validated['name'];

    // ✅ Handle avatar upload
    if ($request->hasFile('avatar')) {
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $path = $request->file('avatar')->store('avatars', 'public');
        $user->avatar = $path;
    }

    // ✅ Save user
    $saved = $user->save();

    if ($saved) {
        Log::info("✅ User profile updated in DB: {$user->name}");
    } else {
        Log::error("❌ Failed to update user.");
    }

    // ✅ Return response
    return response()->json([
        'message' => $saved ? 'Profile updated' : 'Profile NOT saved',
        'name' => $user->name,
        'avatarUrl' => $user->avatar ? asset('storage/' . $user->avatar) : null,
    ]);
}

}
