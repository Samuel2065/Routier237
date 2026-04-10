<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('reservations')) {
            return;
        }

        // Normalize legacy values before changing enum
        if (Schema::hasColumn('reservations', 'payment_method')) {
            DB::table('reservations')
                ->where('payment_method', 'mobile_money')
                ->update(['payment_method' => 'momo']);

            DB::statement("ALTER TABLE `reservations` MODIFY `payment_method` ENUM('om','momo','card','cash') NOT NULL DEFAULT 'cash'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('reservations')) {
            return;
        }

        if (Schema::hasColumn('reservations', 'payment_method')) {
            // Map back to a generic mobile_money value if needed
            DB::table('reservations')
                ->whereIn('payment_method', ['om', 'momo'])
                ->update(['payment_method' => 'mobile_money']);

            DB::statement("ALTER TABLE `reservations` MODIFY `payment_method` ENUM('cash','mobile_money','card') NOT NULL DEFAULT 'cash'");
        }
    }
};
