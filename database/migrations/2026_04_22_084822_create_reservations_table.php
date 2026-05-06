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
            $table->foreignId('created_by_user_id')->constrained('users');
            $table->foreignId('restaurant_id')->constrained()->cascadeOnDelete();

            $table->string('name');
            $table->string('phone_number');
            $table->unsignedInteger('number_of_people');
            $table->dateTime('start_datetime');
            $table->dateTime('end_datetime');

            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed', 'no_show']);
            $table->enum('reservation_type', ['user_created', 'staff_created']);
            $table->text('reservation_note')->nullable();

            $table->timestamps();
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
