<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/profile', function (Request $request) {
        return response()->json([
            'message' => 'This is a protected route.',
            'user' => $request->user(),
        ]);
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});

// GET /api/students uses auth:sanctum and role:admin,student (using array style)[cite: 14, 17]
Route::middleware(['auth:sanctum', 'role:admin,student'])->get('/students', function () {
    return response()->json(['message' => 'Access granted to students list']);
});

// GET /api/admin/dashboard uses auth:sanctum and admin (using array style)[cite: 14, 17]
Route::middleware(['auth:sanctum', 'admin'])->get('/admin/dashboard', function () {
    return response()->json(['message' => 'Welcome Admin!']);
});

// GET /api/student/dashboard uses auth:sanctum and role:student (using array style)[cite: 14, 17]
Route::middleware(['auth:sanctum', 'role:student'])->get('/student/dashboard', function () {
    return response()->json(['message' => 'Welcome Student!']);
});

Route::get('/sample', function () {
    return response()->json([
        'message' => 'This is a sample route.',
    ]);
});

// Test 1: Public endpoint
Route::get('/hello', function () {
    return response()->json([
        'message' => 'Welcome to the Laravel 13 API',
    ]);
});