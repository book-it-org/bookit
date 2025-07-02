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
        Schema::create("papeis", function (Blueprint $table) {
            $table->id();
            $table->string("nome", 255)->unique();
            $table->string("descricao", 255);
        }); 

        Schema::create("usuarios_papeis", function (Blueprint $table) {
            $table->primary(["usuarios_id", "papeis_id"]);
            $table->foreignId("usuarios_id")->constrained("usuarios")->onDelete("cascade");
            $table->foreignId("papeis_id")->constrained("papeis")->onDelete("restrict");
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("usuarios_papeis");
        Schema::dropIfExists("papeis");
    }
};
