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
            'ticker' => 'VALE3',
            'dpa' => '6.82',
            'dividend_yield' => '8',
        ]);

        FormulaBazin::create([
            'user_id' => '1',
            'ticker' => 'RANI3',
            'dpa' => '5',
            'dividend_yield' => '6',
        ]);

        FormulaBazin::create([
            'user_id' => '2',
            'ticker' => 'VALE3',
            'dpa' => '6',
            'dividend_yield' => '9',
        ]);

        FormulaBazin::create([
            'user_id' => '1',
            'ticker' => 'ABCB4',
            'dpa' => '5',
            'dividend_yield' => '10',
        ]);

        FormulaBazin::create([
            'user_id' => '1',
            'ticker' => 'PETR4',
            'dpa' => '6.5',
            'dividend_yield' => '9',
        ]);
        FormulaBazin::factory()->count(5)->create(['user_id' => 1]);
    }
}
