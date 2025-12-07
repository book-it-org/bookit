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
        // Add a nullable generos_id to ofertas, migrate the first linked genero from the pivot,
        // then drop the pivot table.
        Schema::table('ofertas', function (Blueprint $table) {
            $table->unsignedBigInteger('generos_id')->nullable()->after('idiomas_id');
            $table->foreign('generos_id')->references('id')->on('generos')->onDelete('set null');
        });

        // Migrate data from pivot table (if exists)
        if (Schema::hasTable('ofertas_generos')) {
            // For each oferta, pick the first genero (if any) and write to ofertas.generos_id
            $rows = \Illuminate\Support\Facades\DB::table('ofertas_generos')->orderBy('ofertas_id')->get();
            $mapped = [];
            foreach ($rows as $r) {
                if (!isset($mapped[$r->ofertas_id])) {
                    $mapped[$r->ofertas_id] = $r->generos_id;
                }
            }

            foreach ($mapped as $ofertaId => $generoId) {
                \Illuminate\Support\Facades\DB::table('ofertas')->where('id', $ofertaId)->update(['generos_id' => $generoId]);
            }

            Schema::dropIfExists('ofertas_generos');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate pivot table and move generos_id back into the pivot, then drop the column.
        Schema::create('ofertas_generos', function (Blueprint $table) {
            $table->unsignedBigInteger('ofertas_id');
            $table->unsignedBigInteger('generos_id');
            $table->primary(['ofertas_id', 'generos_id']);
            $table->foreign('ofertas_id')->references('id')->on('ofertas')->onDelete('cascade');
            $table->foreign('generos_id')->references('id')->on('generos')->onDelete('cascade');
        });

        // Move data back from ofertas.generos_id into pivot (if column exists)
        if (Schema::hasColumn('ofertas', 'generos_id')) {
            $ofertas = \Illuminate\Support\Facades\DB::table('ofertas')->whereNotNull('generos_id')->get();
            foreach ($ofertas as $o) {
                \Illuminate\Support\Facades\DB::table('ofertas_generos')->insertOrIgnore([
                    'ofertas_id' => $o->id,
                    'generos_id' => $o->generos_id,
                ]);
            }

            Schema::table('ofertas', function (Blueprint $table) {
                $table->dropForeign(["generos_id"]);
                $table->dropColumn('generos_id');
            });
        }
    }
};
