<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nota extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Campos que podem ser atribuídos em massa.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'user_id',
        'titulo',
        'conteudo',
    ];

    /**
     * Relação com o usuário dono da nota.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
