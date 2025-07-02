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
        Schema::create('ofertas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuarios_id')->constrained('usuarios')->onDelete('cascade');
            $table->foreignId('idiomas_id')->constrained('idiomas')->onDelete('set null');
            $table->text('titulo');
            $table->text('descricao');
            $table->decimal('preco', 10, 2);
            $table->boolean('ativo')->default(true);
            $table->text('titulo_livro');
            $table->text('autor_livro');
            $table->enum('estado_livro', ['novo', 'usado', 'desgastado']);
            $table->string('isbn', 13);
            $table->timestamp('data_publicacao_livro');
            $table->timestamps();
        });

        Schema::create('ofertas_generos', function (Blueprint $table) {
            $table->primary(['ofertas_id', 'generos_id']);
            $table->foreignId('ofertas_id')->constrained('ofertas')->onDelete('cascade');
            $table->foreignId('generos_id')->constrained('generos')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ofertas');
        Schema::dropIfExists('ofertas_generos');
    }
};
