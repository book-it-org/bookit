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
        Schema::create("estados", function (Blueprint $table) {
            $table->id();
            $table->string("nome", 100);
            $table->string("sigla", 2);

        });

        Schema::create("paises", function (Blueprint $table) {
            $table->id();
            $table->string("nome", 100);
            $table->string("sigla", 2);
        });

        Schema::create("enderecos", function (Blueprint $table) {
            $table->id();
            $table->foreignId("usuarios_id")->constrained("usuarios")->onDelete("cascade");
            $table->foreignId("estados_id")->constrained("estados")->onDelete("restrict");
            $table->foreignId("paises_id")->constrained("paises")->onDelete("restrict");
            $table->string("logradouro", 255);
            $table->string("numero", 10);
            $table->string("complemento", 255)->nullable();
            $table->string("bairro", 255);
            $table->string("cep", 9);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("estados");
        Schema::dropIfExists("paises");
        Schema::dropIfExists("enderecos");
    }
};
