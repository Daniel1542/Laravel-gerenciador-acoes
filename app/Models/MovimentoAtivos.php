<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimentoAtivos extends Model
{
    use HasFactory;

    protected $table = 'movimento_ativos';
    protected $fillable = [
        'user_id',
        'tipo',
        'movimento',
        'nome',
        'data',
        'corretagem',
        'quantidade',
        'valor',
        'valor_total',
    ];
    protected $dates = ['data'];

    public function movimentoAtivos()
    {
        return $this->hasMany(MovimentoAtivos::class);
    }
}
