<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nota extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'titulo',
        'conteudo',
    ];

    // MÁGICA DA CRIPTOGRAFIA (adicione este bloco)
    protected function casts(): array
    {
        return [
            'conteudo' => 'encrypted',
        ];
    }

    // Diz que esta nota pertence a um Usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
