<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * PIVOT TABLE for Many-to-Many relationship
     * A user can have multiple properties (history of rentals)
     * A property can have multiple users (history of tenants)
     */
    public function up(): void
    {
        Schema::create('tenant_property', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->decimal('monthly_rate', 10, 2);
            $table->decimal('security_deposit', 10, 2)->default(0);
            $table->enum('status', ['active', 'ended', 'terminated'])->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();

            // Composite unique key to prevent duplicate active rentals
            $table->unique(['user_id', 'property_id', 'start_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenant_property');
    }
};