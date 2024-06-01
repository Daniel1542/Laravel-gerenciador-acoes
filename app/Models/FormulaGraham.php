<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormulaGraham extends Model
{
    use HasFactory;

    protected $table = 'formula_graham';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'ticker',
        'lpa',
        'vpa',
    ];

    /**
     *
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'lpa' => 'float',
        'vpa' => 'float',
    ];

    /**
     * Get the user that owns the Formula Graham.
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
