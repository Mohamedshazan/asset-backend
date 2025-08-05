<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\SupportRequestController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportExportController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeDashboardController;





/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Register - Only for Admins
Route::middleware('auth:sanctum')->post('/register', function (Request $request) {
    if ($request->user()->role !== 'Admin') {
        return response()->json(['message' => 'Unauthorized. Only Admins can register users.'], 403);
    }

    $request->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|min:6',
        'role' => 'required|in:Admin,IT,Head,Employee',
        'department_name' => 'nullable|exists:departments,name',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
        'department_name' => $request->department_name,
    ]);

    return response()->json([
        'message' => 'User registered successfully',
        'user' => $user,
    ]);
});

// Login - Public
Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json([
        'token' => $token,
        'name' => $user->name,
        'role' => $user->role,
        // ✅ Add cache-busting timestamp
        'avatarUrl' => $user->avatar 
            ? asset('storage/' . $user->avatar) . '?v=' . time() 
            : null,
    ]);
});

/*
|--------------------------------------------------------------------------
| Protected Routes (auth:sanctum)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    // Profile Update
// Accept both PUT and POST (with _method override)
Route::middleware('auth:sanctum')->match(['put', 'post'], '/profile', [UserController::class, 'updateProfile']);

    // Users & Departments
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/departments', [DepartmentController::class, 'index']);
    Route::delete('/users/{id}', function ($id) {
    $user = User::findOrFail($id);
    $user->delete();
    return response()->json(['message' => 'User deleted successfully']);
})->middleware('auth:sanctum');


    // Authenticated User Info
    Route::get('/user', fn (Request $request) => $request->user());

    /*
    |--------------------------------------------------------------------------
    | Dashboard Routes
    |--------------------------------------------------------------------------
    */
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard/admin', 'adminSummary')->middleware('role:Admin');
        Route::get('/dashboard/it', 'itSupportDashboard')->middleware('role:IT');
        Route::get('/dashboard/employee', 'employeeDashboard')->middleware('role:Employee');
        Route::get('/dashboard/asset-count', 'totalAssets')->middleware('role:Admin,IT');
        Route::get('/dashboard/assigned', 'assignedAssets')->middleware('role:Admin,IT');
        Route::get('/dashboard/available', 'availableAssets')->middleware('role:Admin,IT');
        Route::get('/dashboard/support-requests', 'supportRequestStats')->middleware('role:Admin,IT');
    });

    /*
    |--------------------------------------------------------------------------
    | Asset Management
    |--------------------------------------------------------------------------
    */
    Route::controller(AssetController::class)->group(function () {
        Route::get('/my-assets', 'myAssets')->middleware('role:Employee');
        Route::post('/assets', 'store')->middleware('role:Admin');
        Route::get('/assets', 'index')->middleware('role:Admin');
        Route::get('/assets/{id}', 'show')->middleware('role:Admin');
        Route::put('/assets/{id}', 'update')->middleware('role:Admin');
        Route::delete('/assets/{id}', 'destroy')->middleware('role:Admin');
        Route::post('/assets/{id}/assign', 'assign')->middleware('role:Admin');
        Route::post('/assets/{id}/unassign', 'unassign')->middleware('role:Admin');
    });

    /*
    |--------------------------------------------------------------------------
    | Support Requests
    |--------------------------------------------------------------------------
    */
    Route::controller(SupportRequestController::class)->group(function () {
        Route::get('/support-requests', 'index');
        Route::post('/support-requests', 'store');
        Route::post('/support-requests/asset', 'storeForAsset');
        Route::put('/support-requests/{id}/status', 'updateStatus');
        Route::get('/my-support-requests', 'mySupportRequests')->middleware('role:Employee');
    });

    /*
    |--------------------------------------------------------------------------
    | Report Exports
    |--------------------------------------------------------------------------
    */
    Route::controller(ReportExportController::class)->middleware('role:Admin,IT')->group(function () {
        Route::get('/export/assets/csv', 'exportAssetsCsv');
        Route::get('/export/assets/pdf', 'exportAssetsPdf');
        Route::get('/export/support/csv', 'exportSupportCsv');
        Route::get('/export/support/pdf', 'exportSupportPdf');
        Route::get('/export/assets', 'exportAssets');
        Route::get('/export/support-requests', 'exportSupportRequests');
    });
});
