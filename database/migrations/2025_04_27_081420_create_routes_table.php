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
            $table->id('id_route');
            $table->date('depart');
            $table->text('route_from');
            $table->text('route_to');
            $table->decimal('price', 10, 0);
            $table->unsignedBigInteger('id_transport');
            $table->timestamps();
            
            // Definir la relación después de crear todas las columnas
            $table->foreign('id_transport')->references('id_transport')->on('transports');
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
