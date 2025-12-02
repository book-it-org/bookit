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
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');
            $table->decimal('preco_total', 10, 2);
            $table->timestamp('data_compra');
            $table->enum('estado', ['pendente', 'pago', 'cancelado'])->default('pendente');
            $table->timestamps();
        });

        Schema::create('compras_pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('compra_id')->constrained('compras')->onDelete('cascade');
            $table->foreignId('pedido_id')->constrained('pedidos')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::dropIfExists('comprovantes');
        Schema::dropIfExists('transacoes');
        Schema::create('transacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('compra_id')->constrained('compras')->unique()->onDelete('cascade');
            $table->boolean('pago')->default(false);
            $table->decimal('valor', 10, 2);
            $table->enum('tipo', ['pix', 'debito', 'credito', 'boleto']);
            $table->timestamp('pago_em')->nullable();
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
        Schema::dropIfExists('compras');
        Schema::dropIfExists('compras_pedidos');
        Schema::dropIfExists('transacoes');
        Schema::dropIfExists('comprovantes');
    }
};
