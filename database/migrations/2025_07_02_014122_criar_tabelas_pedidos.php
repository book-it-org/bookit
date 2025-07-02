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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendedor_id')->constrained('usuarios')->onDelete('cascade');
            $table->foreignId('comprador_id')->constrained('usuarios')->onDelete('cascade');
            $table->foreignId('oferta_id')->constrained('ofertas')->onDelete('cascade');
            $table->enum('estado', ['pendente', 'andamento', 'concluido', 'cancelado']);
            $table->timestamps();
        });

        Schema::create('transacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained('pedidos')->unique()->onDelete('cascade');
            $table->boolean('pago')->default(false);
            $table->decimal('valor', 10, 2);
            $table->enum('tipo', ['pix', 'debito', 'credito', 'boleto']);
            $table->timestamp('pago_em');
            $table->timestamps();
        });

        Schema::create('comprovantes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transacao_id')->constrained('transacoes')->onDelete('cascade');
            $table->text('caminho');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
        Schema::dropIfExists('transacoes');
        Schema::dropIfExists('comprovantes');
    }
};
