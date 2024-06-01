<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormulaBazin extends Model
{
    use HasFactory;

    protected $table = 'formula_bazin';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'ticker',
        'lpa',
        'payout',
        'yield_projetado',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'lpa' => 'float',
        'payout' => 'float',
        'yield_projetado' => 'float',
    ];

    /**
     * Get the user that owns the Formula Bazin.
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
