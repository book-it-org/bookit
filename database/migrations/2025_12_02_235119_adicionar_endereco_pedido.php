<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Adds an `endereco_id` FK to `pedidos` so each pedido has an address.
     */
    public function up(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            if (! Schema::hasColumn('pedidos', 'endereco_id')) {
                // make nullable to avoid migration failures on existing data
                $table->foreignId('endereco_id')->nullable()->constrained('enderecos')->onDelete('restrict');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            if (Schema::hasColumn('pedidos', 'endereco_id')) {
                $table->dropForeign(['endereco_id']);
                $table->dropColumn('endereco_id');
            }
        });
    }
};

