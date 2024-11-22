<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
        $table->id();
        $table->string('cliente');
        $table->string('telefono');
        $table->string('direccion');
        $table->string('pizza');
        $table->integer('cantidad');
        $table->decimal('precio', 8, 2);
        $table->enum('estado', ['pendiente', 'preparando', 'entregado'])->default('pendiente');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
};
