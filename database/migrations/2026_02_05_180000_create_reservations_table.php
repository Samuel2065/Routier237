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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')->constrained()->onDelete('cascade');
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->string('ticket_number')->unique();
            $table->string('confirmation_code')->unique();
            $table->string('seat_number');
            $table->enum('passenger_type', ['adult', 'child'])->default('adult');
            $table->decimal('price', 10, 2);
            $table->decimal('baggage_fees', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->enum('payment_method', ['cash', 'mobile_money', 'card'])->default('cash');
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
            $table->timestamp('reservation_date');
            $table->foreignId('reserved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('sales_agency_id')->nullable()->constrained('agencies')->nullOnDelete();
            $table->enum('status', ['pending', 'confirmed', 'used', 'cancelled'])->default('confirmed');
            $table->timestamps();

            $table->index(['client_id', 'status']);
            $table->index(['sales_agency_id', 'reservation_date']);
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
