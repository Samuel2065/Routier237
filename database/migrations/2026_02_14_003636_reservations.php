<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('reservations')) {
            return;
        }

        Schema::create('reservations', function(Blueprint $table){
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('restrict');
            $table->foreignId('trip_id')->constrained()->onDelete('restrict');
            $table->string('departure_date');
            $table->enum('status', ['valid', 'used', 'cancelled'])->default('valid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
