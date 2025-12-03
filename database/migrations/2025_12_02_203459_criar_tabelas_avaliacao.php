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
        Schema::create('avaliacoes', function (Blueprint $table) {
            $table->id();
            // referência ao pedido -- um pedido só pode gerar uma avaliação (do comprador)
            $table->foreignId('pedido_id')->constrained('pedidos')->onDelete('cascade');

            // vendedor e comprador (referenciam tabela `usuarios` usada nas migrations)
            $table->foreignId('vendedor_id')->constrained('usuarios')->onDelete('cascade');
            $table->foreignId('comprador_id')->constrained('usuarios')->onDelete('cascade');

            // nota de 0 a 5
            $table->tinyInteger('nota')->unsigned();
            $table->text('comentario')->nullable();

            $table->timestamps();

            // garante apenas uma avaliação por pedido
            $table->unique('pedido_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avaliacoes');
    }
};
