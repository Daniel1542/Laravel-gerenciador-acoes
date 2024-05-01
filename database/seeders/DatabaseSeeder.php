<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call(UsersSeeder::class);
        $this->call(MovimentoAtivosSeeder::class);
        $this->call(FormulaBazinSeeder::class);
        $this->call(FormulaGrahamSeeder::class);
    }
}
