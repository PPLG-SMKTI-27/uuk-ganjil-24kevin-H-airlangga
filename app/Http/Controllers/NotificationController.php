<?php

namespace App\Http\Controllers;

use App\Models\Tamu;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function getNotifications()
    {
        try {
            // Set timezone ke Asia/Makassar
            Carbon::setLocale("id"); // Bahasa Indonesia

            // Get recent tamu (last 20) as notifications
            $recentTamu = Tamu::with(["guru", "jenisKunjungan", "createdBy"])
                ->orderBy("created_at", "desc")
                ->limit(20)
                ->get();

            $notifications = [];

            foreach ($recentTamu as $tamu) {
                // Check if notification is new (less than 24 hours)
                // Gunakan created_at untuk waktu notifikasi yang akurat
                // Parse dari database (UTC) kemudian konversi ke Asia/Makassar
                $createdAt = Carbon::createFromFormat(
                    "Y-m-d H:i:s",
                    $tamu->created_at,
                    "UTC",
                )->setTimezone("Asia/Makassar");
                $now = Carbon::now("Asia/Makassar");
                $isNew = $createdAt->diffInHours($now) < 24;

                // Determine icon based on status
                $icon = "user-plus";
                if ($tamu->status_kunjungan === "selesai") {
                    $icon = "check-circle";
                } elseif ($tamu->status_kunjungan === "dibatalkan") {
                    $icon = "times-circle";
                } elseif ($tamu->status_kunjungan === "diproses") {
                    $icon = "clock";
                }

                // Format message
                $message = "{$tamu->nama} mengajukan kunjungan";
                if ($tamu->guru) {
                    $message .= " ke {$tamu->guru->nama_guru}";
                }

                $notifications[] = [
                    "id" => $tamu->id_tamu,
                    "icon" => $icon,
                    "title" => "Pengunjung Baru",
                    "message" => $message,
                    "time" => $createdAt->diffForHumans($now),
                    "read" => !$isNew,
                    "status" => $tamu->status_kunjungan,
                    "data" => [
                        "tamu_id" => $tamu->id_tamu,
                        "nama" => $tamu->nama,
                        "tanggal" => Carbon::createFromFormat(
                            "Y-m-d",
                            date("Y-m-d", strtotime($tamu->tanggal_kunjungan)),
                            "UTC",
                        )
                            ->setTimezone("Asia/Makassar")
                            ->translatedFormat("d F Y"),
                        "waktu" => $tamu->waktu_masuk
                            ? Carbon::createFromFormat(
                                    "Y-m-d H:i:s",
                                    $tamu->waktu_masuk,
                                    "UTC",
                                )
                                    ->setTimezone("Asia/Makassar")
                                    ->format("H:i") . " WITA"
                            : "-",
                        "guru" => $tamu->guru
                            ? $tamu->guru->nama_guru
                            : "Tidak ada",
                        "status" => $tamu->status_kunjungan,
                        "jenis" => $tamu->jenisKunjungan
                            ? $tamu->jenisKunjungan->nama_jenis
                            : "-",
                    ],
                ];
            }

            return response()->json($notifications);
        } catch (\Exception $e) {
            return response()->json(
                [
                    "error" => "Gagal memuat notifikasi",
                    "message" => $e->getMessage(),
                ],
                500,
            );
        }
    }

    public function getNotificationCount()
    {
        try {
            // Count notifications from last 24 hours (Asia/Makassar timezone)
            $now = Carbon::now("Asia/Makassar");
            $yesterday = $now->copy()->subDay()->setTimezone("UTC");
            $count = Tamu::where("created_at", ">=", $yesterday)->count();

            return response()->json(["count" => $count]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    "error" => "Gagal menghitung notifikasi",
                    "count" => 0,
                ],
                500,
            );
        }
    }

    public function markAsRead($id)
    {
        // This is a placeholder for future implementation
        // You can add a notifications table later
        return response()->json(["success" => true]);
    }

    public function markAllAsRead()
    {
        // This is a placeholder for future implementation
        return response()->json(["success" => true]);
    }
}
