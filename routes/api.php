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

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Authentication
Route::post('/register', function (Request $request) {
    $request->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|min:6',
        'role' => 'required|in:Admin,IT,Head,Employee',
        'department_id' => 'nullable|exists:departments,id',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
        'department_id' => $request->department_id,
    ]);

    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json([
        'user' => $user,
        'token' => $token
    ]);
});

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
    'name' => $user->name,
    'role' => $user->role,
    'avatarUrl' => $user->avatar ? asset('storage/' . $user->avatar) : null,
    'token' => $token
]);

});

/*
|--------------------------------------------------------------------------
| Protected Routes (auth:sanctum)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // Profile Update
    Route::match(['put', 'post'], '/profile', [UserController::class, 'updateProfile']);

    // Authenticated User Info
    Route::get('/user', function (Request $request) {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        return [
            'name' => $user->name,
            'avatarUrl' => $user->avatar ? asset('storage/' . $user->avatar) : null,
            'role' => $user->role ?? 'Employee',
        ];
    });

    // Users & Departments
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/departments', [DepartmentController::class, 'index']);

    /*
    |--------------------------------------------------------------------------
    | Dashboard Routes
    |--------------------------------------------------------------------------
    */
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard/admin', 'adminSummary')->middleware('role:Admin');
        Route::get('/dashboard/it', 'itSupportDashboard')->middleware('role:IT');
        Route::get('/dashboard/employee', 'employeeDashboard')->middleware('role:Employee');

        Route::middleware('role:Admin,IT')->group(function () {
            Route::get('/dashboard/asset-count', 'totalAssets');
            Route::get('/dashboard/assigned', 'assignedAssets');
            Route::get('/dashboard/available', 'availableAssets');
            Route::get('/dashboard/support-requests', 'supportRequestStats');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Asset Management
    |--------------------------------------------------------------------------
    */
    Route::controller(AssetController::class)->group(function () {
        Route::get('/my-assets', 'myAssets')->middleware('role:Employee');

        Route::middleware('role:Admin')->group(function () {
            Route::post('/assets', 'store');
            Route::get('/assets', 'index');
            Route::get('/assets/{id}', 'show');
            Route::put('/assets/{id}', 'update');
            Route::delete('/assets/{id}', 'destroy');
            Route::post('/assets/{id}/assign', 'assign');
            Route::post('/assets/{id}/unassign', 'unassign');
        });
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
    Route::controller(ReportExportController::class)
        ->middleware('role:Admin,IT')
        ->group(function () {
            Route::get('/export/assets/csv', 'exportAssetsCsv');
            Route::get('/export/assets/pdf', 'exportAssetsPdf');
            Route::get('/export/support/csv', 'exportSupportCsv');
            Route::get('/export/support/pdf', 'exportSupportPdf');
            Route::get('/export/assets', 'exportAssets');
            Route::get('/export/support-requests', 'exportSupportRequests');
        });
});
