<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            if (! Schema::hasColumn('pedidos', 'confirmacao_recebimento')) {
                $table->boolean('confirmacao_recebimento')->default(false)->after('estado');
            }

            if (! Schema::hasColumn('pedidos', 'confirmado_recebimento_at')) {
                $table->timestamp('confirmado_recebimento_at')->nullable()->after('confirmacao_recebimento');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            if (Schema::hasColumn('pedidos', 'confirmado_recebimento_at')) {
                $table->dropColumn('confirmado_recebimento_at');
            }

            if (Schema::hasColumn('pedidos', 'confirmacao_recebimento')) {
                $table->dropColumn('confirmacao_recebimento');
            }
        });
    }
};
