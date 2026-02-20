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
        Schema::create('employee_contacts', function (Blueprint $table) {
            $table->id(); // Primary Key

            $table->foreignId('employee_id')
                  ->constrained('employees')
                  ->onDelete('cascade'); // If employee deleted, contacts deleted

            $table->string('contact_number', 20);

            $table->string('type', 12)->default('mobile');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_contacts');
    }
};
