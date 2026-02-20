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
        Schema::create('employee_addresses', function (Blueprint $table) {
            $table->id(); // Primary Key

            $table->foreignId('employee_id')
                  ->constrained('employees')
                  ->onDelete('cascade'); // If employee deleted, address deleted

            $table->string('address_line1');
            $table->string('address_line2')->nullable();

            $table->string('city');
            $table->string('state');
            $table->string('pincode', 10);
            $table->string('country');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_addresses');
    }
};
