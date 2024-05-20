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
            'lpa' => '6.82',
            'payout' => '80',
            'yield_projetado' => '8',
        ]);

        FormulaBazin::create([
            'user_id' => '1',
            'ticker' => 'RANI3',
            'lpa' => '5',
            'payout' => '70',
            'yield_projetado' => '6',
        ]);

        FormulaBazin::create([
            'user_id' => '2',
            'ticker' => 'VALE3',
            'lpa' => '6',
            'payout' => '60',
            'yield_projetado' => '9',
        ]);

        FormulaBazin::create([
            'user_id' => '1',
            'ticker' => 'ABCB4',
            'lpa' => '5',
            'payout' => '90',
            'yield_projetado' => '10',
        ]);

        FormulaBazin::create([
            'user_id' => '1',
            'ticker' => 'PETR4',
            'lpa' => '6.5',
            'payout' => '50',
            'yield_projetado' => '9',
        ]);
        FormulaBazin::factory()->count(5)->create(['user_id' => 1]);
    }
}
