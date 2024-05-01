<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FormulaBazin;


class FormulaBazinSeeder extends Seeder
{
    public function run(): void
    {
        FormulaBazin::create([
            'user_id' => '1',
            'nome' => 'VALE3',
            'dpa' => '6.82',
            'dividend_yield' => '8',
        ]);

        FormulaBazin::create([
            'user_id' => '1',
            'nome' => 'RANI3',
            'dpa' => '5',
            'dividend_yield' => '6',
        ]);

        FormulaBazin::create([
            'user_id' => '2',
            'nome' => 'VALE3',
            'dpa' => '6',
            'dividend_yield' => '9',
        ]);
    }
}
