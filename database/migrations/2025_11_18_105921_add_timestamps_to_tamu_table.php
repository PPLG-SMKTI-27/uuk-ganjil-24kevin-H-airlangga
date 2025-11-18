<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table("tamu", function (Blueprint $table) {
            // Check if columns don't exist before adding
            if (!Schema::hasColumn("tamu", "created_at")) {
                $table
                    ->timestamp("created_at")
                    ->nullable()
                    ->after("created_by");
            }
            if (!Schema::hasColumn("tamu", "updated_at")) {
                $table
                    ->timestamp("updated_at")
                    ->nullable()
                    ->after("created_at");
            }
        });

        // Update existing records yang belum punya created_at
        // Gunakan tanggal_kunjungan sebagai fallback untuk created_at
        DB::statement('
            UPDATE tamu
            SET created_at = COALESCE(created_at, tanggal_kunjungan),
                updated_at = COALESCE(updated_at, NOW())
            WHERE created_at IS NULL
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("tamu", function (Blueprint $table) {
            if (Schema::hasColumn("tamu", "created_at")) {
                $table->dropColumn("created_at");
            }
            if (Schema::hasColumn("tamu", "updated_at")) {
                $table->dropColumn("updated_at");
            }
        });
    }
};
