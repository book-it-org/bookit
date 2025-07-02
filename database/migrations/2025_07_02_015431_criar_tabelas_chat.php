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
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('remetente_id')->constrained('usuarios');
            $table->foreignId('destinatario_id')->constrained('usuarios');
            $table->boolean('ativo')->default('true');
        });

        Schema::create('mensagens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_id')->constrained('chats')->onDelete('cascade');
            $table->foreignId('remetente_id')->constrained('usuarios');
            $table->text('conteudo');
            $table->timestamp('data_envio')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
        Schema::dropIfExists('mensagens');
    }
};
