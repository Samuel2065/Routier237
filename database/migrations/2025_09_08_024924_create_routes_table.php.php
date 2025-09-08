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
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agency_id')->constrained()->onDelete('cascade');
            $table->foreignId('departure_destination_id')->constrained('destinations');
            $table->foreignId('arrival_destination_id')->constrained('destinations');
            $table->time('departure_time');
            $table->time('arrival_time');
            $table->decimal('price', 10, 2);
            $table->integer('available_seats');
            $table->integer('total_seats');
            $table->enum('bus_type', ['standard', 'vip', 'luxury']);
            $table->json('amenities')->nullable(); // climatisation, wifi, etc.
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
};
