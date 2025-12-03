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
        Schema::table('ofertas', function (Blueprint $table) {
            if (!Schema::hasColumn('ofertas', 'editora')) {
                $table->string('editora')->nullable()->after('autor_livro');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ofertas', function (Blueprint $table) {
            if (Schema::hasColumn('ofertas', 'editora')) {
                $table->dropColumn('editora');
            }
        });
    }
};
