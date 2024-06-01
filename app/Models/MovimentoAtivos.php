<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimentoAtivos extends Model
{
    use HasFactory;

    protected $table = 'movimento_ativos';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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
     /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'data' => 'date',
        'corretagem' => 'float',
        'quantidade' => 'integer',
        'valor' => 'float',
        'valor_total' => 'float',
    ];

    /**
     * Get the user that owns the movimento ativo.
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
