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
        Schema::create('transports', function (Blueprint $table) {
            $table->id('id_transport');
            $table->string('code', 50);
            $table->text('description');
            $table->integer('seat');
            $table->unsignedBigInteger('id_transport_type');
            $table->timestamps();
            
            // Definir la relación después de crear todas las columnas
            $table->foreign('id_transport_type')->references('id_transport_type')->on('transport_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transports');
    }
};
