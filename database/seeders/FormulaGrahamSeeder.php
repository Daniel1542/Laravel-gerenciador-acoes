<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FormulaGraham;


class FormulaGrahamSeeder extends Seeder
{
    public function run(): void
    {
        FormulaGraham::create([
            'user_id' => '1',
            'nome' => 'VALE3',
            'lpa' => '8.53',
            'vpa' => '41.24',
        ]);

        FormulaGraham::create([
            'user_id' => '1',
            'nome' => 'RANI3',
            'lpa' => '7',
            'vpa' => '35',
        ]);

        FormulaGraham::create([
            'user_id' => '2',
            'nome' => 'VALE3',
            'lpa' => '8',
            'vpa' => '40',
        ]);
    }
}
