<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormulaGraham extends Model
{
    use HasFactory;

    protected $table = 'formula_graham';
    protected $fillable = [
        'user_id',
        'ticker',
        'lpa',
        'vpa',
    ];

    public function formulaGraham()
    {
        return $this->hasMany(FormulaGraham::class);
    }
}
