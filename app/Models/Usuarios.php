<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuarios extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nome',
        'sobrenome',
        'nome_usuario',
        'data_nascimento',
        'email',
        'telefone',
        'documento',
        'papeis_id',
        'senha_hash'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'senha_hash',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'senha_hash' => 'hashed',
        ];
    }

    public function getAuthPassword()
    {
        return $this->senha_hash;
    }

    /**
     * Relacionamento com o modelo Papeis
     */
    public function papel()
    {
        return $this->belongsTo(Papeis::class, 'papeis_id');
    }

    public function verificarAdmin()
    {
        return $this->papeis_id === 0;
    }

}
