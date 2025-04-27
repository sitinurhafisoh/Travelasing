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
            $table->id('id_reserv');
            $table->decimal('reserv_code', 10, 0);
            $table->string('reserv_at')->nullable();
            $table->date('reserv_date');
            $table->decimal('seat', 10, 0);
            $table->date('depart');
            $table->decimal('price', 10, 0);
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_route');
            $table->string('status', 100);
            $table->string('description', 10)->nullable();
            $table->timestamps();

            // Definir las relaciones después de crear todas las columnas
            $table->foreign('id_user')->references('id_user')->on('users');
            $table->foreign('id_route')->references('id_route')->on('routes');
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
