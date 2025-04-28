<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the database migrations.
     */
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id('id_schedule');
            $table->unsignedBigInteger('id_route');
            $table->dateTime('depart_time');
            $table->dateTime('arrival_time');
            $table->integer('available_seats');
            $table->decimal('price', 10, 2);
            $table->enum('status', ['Scheduled', 'Delayed', 'Cancelled'])->default('Scheduled');
            $table->timestamps();

            $table->foreign('id_route')->references('id_route')->on('routes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
