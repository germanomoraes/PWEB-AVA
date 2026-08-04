<?php

namespace App\Models;

// ... (vários "use" aqui em cima) ...

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
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
            'password' => 'hashed',
        ];
    }

    // ==========================================
    // ADICIONE ESTE BLOCO AQUI NO FINAL!
    // ==========================================
    
    /**
     * Diz que um Usuário tem muitas Notas
     */
    public function notas()
    {
        return $this->hasMany(Nota::class);
    }
}