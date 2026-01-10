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
        // ============================================
        // 1. AUTHENTICATION & ROLES
        // ============================================
        
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('module')->nullable();
            $table->string('action')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('role_permission', function (Blueprint $table) {
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->foreignId('permission_id')->constrained()->onDelete('cascade');
            $table->primary(['role_id', 'permission_id']);
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('password');
            $table->foreignId('role_id')->constrained()->onDelete('restrict');
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->string('photo')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique();
            $table->string('password')->nullable();
            $table->enum('id_type', ['ID Card', 'Passport']);
            $table->string('id_number');
            $table->date('date_of_birth');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('city')->nullable();
            $table->string('address', 500)->nullable();
            $table->enum('status', ['active', 'blocked'])->default('active');
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['phone', 'email']);
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // ============================================
        // 2. ORGANIZATIONAL STRUCTURE
        // ============================================

        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('acronym')->nullable();
            $table->string('logo')->nullable();
            $table->string('headquarters_address');
            $table->string('phone');
            $table->string('email')->unique();
            $table->string('taxpayer_number')->unique();
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('region');
            $table->string('postal_code')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->index(['name', 'region']);
        });

        Schema::create('agencies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('restrict');
            $table->string('name');
            $table->string('city');
            $table->string('district')->nullable();
            $table->text('full_address');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('agency_code')->unique();
            $table->enum('type', ['main', 'secondary'])->default('secondary');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['company_id', 'city']);
        });

        // ============================================
        // 3. TRANSPORT & ROUTES
        // ============================================

        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('departure_city_id')->constrained('cities')->onDelete('restrict');
            $table->foreignId('arrival_city_id')->constrained('cities')->onDelete('restrict');
            $table->decimal('distance_km', 8, 2);
            $table->integer('estimated_duration'); // in minutes
            $table->text('route_description')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->index(['departure_city_id', 'arrival_city_id']);
        });

        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('route_id')->constrained()->onDelete('cascade');
            $table->time('departure_time');
            $table->json('operating_days'); // ["Monday", "Tuesday", ...]
            $table->enum('service_type', ['VIP', 'Express', 'Normal'])->default('Normal');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->index(['route_id', 'departure_time']);
        });

        Schema::create('vehicle_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "70-seat Bus"
            $table->integer('passenger_capacity');
            $table->integer('luggage_capacity')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('fares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('route_id')->constrained()->onDelete('cascade');
            $table->foreignId('vehicle_type_id')->constrained()->onDelete('cascade');
            $table->decimal('adult_price', 10, 2);
            $table->decimal('child_price', 10, 2)->nullable();
            $table->decimal('extra_baggage_price', 10, 2)->default(0);
            $table->string('currency', 3)->default('XAF');
            $table->date('validity_start_date');
            $table->date('validity_end_date')->nullable();
            $table->timestamps();
            $table->index(['route_id', 'vehicle_type_id', 'validity_start_date']);
        });

        // ============================================
        // 4. FLEET
        // ============================================

        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_type_id')->constrained()->onDelete('restrict');
            $table->string('registration')->unique();
            $table->string('brand');
            $table->string('model');
            $table->year('year_manufacture');
            $table->string('chassis_number')->unique();
            $table->string('color')->nullable();
            $table->integer('actual_capacity');
            $table->enum('condition', ['excellent', 'good', 'average', 'poor'])->default('good');
            $table->enum('status', ['active', 'maintenance', 'out_of_service'])->default('active');
            $table->integer('mileage')->default(0);
            $table->date('acquisition_date');
            $table->string('photo')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['vehicle_type_id', 'status']);
        });

        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
            $table->enum('maintenance_type', ['service', 'repair', 'inspection']);
            $table->date('maintenance_date');
            $table->integer('mileage');
            $table->text('description');
            $table->decimal('cost', 10, 2);
            $table->string('garage')->nullable();
            $table->integer('next_service_km')->nullable();
            $table->date('next_service_date')->nullable();
            $table->enum('status', ['scheduled', 'in_progress', 'completed'])->default('scheduled');
            $table->timestamps();
            $table->index(['vehicle_id', 'maintenance_date']);
        });

        // ============================================
        // 5. PERSONNEL
        // ============================================

        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('agency_id')->constrained()->onDelete('restrict');
            $table->string('position');
            $table->string('employee_number')->unique();
            $table->date('hire_date');
            $table->decimal('base_salary', 10, 2);
            $table->string('id_card_number')->unique();
            $table->string('marital_status')->nullable();
            $table->integer('number_of_children')->default(0);
            $table->string('emergency_contact')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['agency_id', 'position']);
        });

        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('license_number')->unique();
            $table->string('license_category');
            $table->date('license_issue_date');
            $table->date('license_expiry_date');
            $table->string('insurance_number')->nullable();
            $table->integer('years_experience')->default(0);
            $table->enum('status', ['available', 'on_trip', 'on_rest'])->default('available');
            $table->timestamps();
            $table->index(['status', 'license_expiry_date']);
        });

        // ============================================
        // 6. TRIPS
        // ============================================

        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('route_id')->constrained()->onDelete('restrict');
            $table->foreignId('vehicle_id')->constrained()->onDelete('restrict');
            $table->foreignId('driver_id')->constrained()->onDelete('restrict');
            $table->foreignId('departure_agency_id')->constrained('agencies')->onDelete('restrict');
            $table->date('departure_date');
            $table->time('departure_time');
            $table->date('expected_arrival_date');
            $table->time('expected_arrival_time');
            $table->integer('available_seats');
            $table->decimal('unit_price', 10, 2);
            $table->enum('status', ['scheduled', 'in_progress', 'arrived', 'cancelled'])->default('scheduled');
            $table->timestamps();
            $table->index(['departure_date', 'route_id', 'status']);
        });

        // ============================================
        // 7. RESERVATIONS
        // ============================================

        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')->constrained()->onDelete('restrict');
            $table->foreignId('client_id')->constrained()->onDelete('restrict');
            $table->string('ticket_number')->unique();
            $table->string('seat_number');
            $table->enum('passenger_type', ['adult', 'child'])->default('adult');
            $table->decimal('price', 10, 2);
            $table->decimal('baggage_fees', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->enum('payment_method', ['cash', 'mobile_money', 'card'])->default('cash');
            $table->enum('payment_status', ['pending', 'paid', 'refunded'])->default('pending');
            $table->timestamp('reservation_date');
            $table->foreignId('reserved_by')->constrained('users')->onDelete('restrict');
            $table->foreignId('sales_agency_id')->constrained('agencies')->onDelete('restrict');
            $table->string('confirmation_code')->unique();
            $table->enum('status', ['confirmed', 'cancelled', 'used'])->default('confirmed');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['trip_id', 'client_id', 'status']);
            $table->index(['ticket_number', 'confirmation_code']);
        });

        // ============================================
        // 8. FINANCIAL
        // ============================================

        Schema::create('cash_registers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agency_id')->constrained()->onDelete('restrict');
            $table->foreignId('user_id')->constrained()->onDelete('restrict');
            $table->timestamp('opening_date');
            $table->decimal('initial_amount', 10, 2);
            $table->decimal('current_amount', 10, 2);
            $table->timestamp('closing_date')->nullable();
            $table->decimal('final_amount', 10, 2)->nullable();
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->timestamps();
            $table->index(['agency_id', 'opening_date', 'status']);
        });

        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cash_register_id')->constrained()->onDelete('restrict');
            $table->enum('type', ['sale', 'refund', 'expense']);
            $table->decimal('amount', 10, 2);
            $table->enum('payment_method', ['cash', 'mobile_money', 'card'])->default('cash');
            $table->string('reference')->unique();
            $table->text('description')->nullable();
            $table->timestamp('transaction_date');
            $table->foreignId('performed_by')->constrained('users')->onDelete('restrict');
            $table->timestamps();
            $table->index(['cash_register_id', 'transaction_date', 'type']);
        });

        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agency_id')->constrained()->onDelete('restrict');
            $table->enum('category', ['fuel', 'maintenance', 'salary', 'utilities', 'other']);
            $table->decimal('amount', 10, 2);
            $table->text('description');
            $table->date('expense_date');
            $table->foreignId('validated_by')->nullable()->constrained('users')->onDelete('restrict');
            $table->string('receipt')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
            $table->index(['agency_id', 'expense_date', 'category']);
        });

        // ============================================
        // 9. NOTIFICATIONS
        // ============================================

        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['sms', 'email', 'push']);
            $table->string('recipient');
            $table->text('content');
            $table->enum('status', ['pending', 'sent', 'failed'])->default('pending');
            $table->timestamp('send_date')->nullable();
            $table->string('context')->nullable();
            $table->foreignId('reservation_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
            $table->index(['recipient', 'status', 'send_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('cash_registers');
        Schema::dropIfExists('reservations');
        Schema::dropIfExists('trips');
        Schema::dropIfExists('drivers');
        Schema::dropIfExists('employees');
        Schema::dropIfExists('maintenances');
        Schema::dropIfExists('vehicles');
        Schema::dropIfExists('fares');
        Schema::dropIfExists('vehicle_types');
        Schema::dropIfExists('schedules');
        Schema::dropIfExists('routes');
        Schema::dropIfExists('agencies');
        Schema::dropIfExists('cities');
        Schema::dropIfExists('companies');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('clients');
        Schema::dropIfExists('users');
        Schema::dropIfExists('role_permission');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
    }
};