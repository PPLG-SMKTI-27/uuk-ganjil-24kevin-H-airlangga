<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table("log_aktivitas", function (Blueprint $table) {
            // Add ip_address and user_agent for security tracking
            if (!Schema::hasColumn("log_aktivitas", "ip_address")) {
                $table
                    ->string("ip_address", 45)
                    ->nullable()
                    ->after("id_record");
            }
            if (!Schema::hasColumn("log_aktivitas", "user_agent")) {
                $table->text("user_agent")->nullable()->after("ip_address");
            }

            // Add timestamps
            if (!Schema::hasColumn("log_aktivitas", "created_at")) {
                $table
                    ->timestamp("created_at")
                    ->nullable()
                    ->after("user_agent");
            }
            if (!Schema::hasColumn("log_aktivitas", "updated_at")) {
                $table
                    ->timestamp("updated_at")
                    ->nullable()
                    ->after("created_at");
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("log_aktivitas", function (Blueprint $table) {
            if (Schema::hasColumn("log_aktivitas", "ip_address")) {
                $table->dropColumn("ip_address");
            }
            if (Schema::hasColumn("log_aktivitas", "user_agent")) {
                $table->dropColumn("user_agent");
            }
            if (Schema::hasColumn("log_aktivitas", "created_at")) {
                $table->dropColumn("created_at");
            }
            if (Schema::hasColumn("log_aktivitas", "updated_at")) {
                $table->dropColumn("updated_at");
            }
        });
    }
};
