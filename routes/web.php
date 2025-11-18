<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TamuController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LogAktivitasController;
use Illuminate\Support\Facades\Route;

// Public Routes (Tidak perlu login)
Route::get("/", [PublicController::class, "index"])->name("home");
Route::get("/pengajuan-kunjungan", [
    PublicController::class,
    "formKunjungan",
])->name("public.form");
Route::post("/pengajuan-kunjungan", [
    PublicController::class,
    "storeKunjungan",
])->name("public.store");
Route::get("/pengajuan-berhasil", [PublicController::class, "success"])->name(
    "public.success",
);

// Di routes/web.php (hanya untuk development)
Route::get("/test-500", function () {
    abort(500, "Test server error");
});

// Authentication Routes
Route::get("/login", [AuthController::class, "showLogin"])->name("login");
Route::post("/login", [AuthController::class, "login"]);
Route::post("/logout", [AuthController::class, "logout"])->name("logout");

// Protected Routes (Perlu login)
Route::middleware(["auth.custom"])->group(function () {
    Route::get("/dashboard", [DashboardController::class, "index"])->name(
        "dashboard",
    );
    // Tamu Routes
    Route::resource("tamu", TamuController::class);
    Route::post("/tamu/{id}/update-status", [
        TamuController::class,
        "updateStatus",
    ])->name("tamu.updateStatus");
    Route::post("/tamu/bulk-delete", [
        TamuController::class,
        "bulkDelete",
    ])->name("tamu.bulkDelete");

    // Guru Routes
    Route::resource("guru", GuruController::class);
    Route::get("/guru/{id}/check-delete", [
        GuruController::class,
        "checkDelete",
    ])->name("guru.checkDelete");
    Route::post("/guru/{id}/reassign-delete", [
        GuruController::class,
        "reassignAndDelete",
    ])->name("guru.reassignDelete");

    // Notification API Routes
    Route::get("/api/notifications", [
        NotificationController::class,
        "getNotifications",
    ]);
    Route::get("/api/notifications/count", [
        NotificationController::class,
        "getNotificationCount",
    ]);
    Route::post("/api/notifications/{id}/read", [
        NotificationController::class,
        "markAsRead",
    ]);
    Route::post("/api/notifications/read-all", [
        NotificationController::class,
        "markAllAsRead",
    ]);

    // Profile API Routes
    Route::get("/api/profile", [ProfileController::class, "show"]);
    Route::post("/api/profile/update", [ProfileController::class, "update"]);
    Route::post("/api/profile/change-password", [
        ProfileController::class,
        "changePassword",
    ]);

    // Log Aktivitas Routes
    Route::get("/log-aktivitas", [
        LogAktivitasController::class,
        "index",
    ])->name("log-aktivitas.index");
    Route::get("/log-aktivitas/recent", [
        LogAktivitasController::class,
        "recent",
    ])->name("log-aktivitas.recent");
    Route::post("/log-aktivitas/cleanup", [
        LogAktivitasController::class,
        "cleanup",
    ])->name("log-aktivitas.cleanup");
    Route::get("/log-aktivitas/export", [
        LogAktivitasController::class,
        "export",
    ])->name("log-aktivitas.export");
});

// Custom Middleware untuk session auth

Route::fallback(function () {
    return response()->view("errors.404", [], 404);
});
