<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\FormulaGraham;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FormulaGraham>
 */
class FormulaGrahamFactory extends Factory
{
     /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FormulaGraham::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $tickers = [
            'PETR4',
            'VALE3',
            'ITUB4',
            'BBDC4',
            'BBAS3',
            'ABEV3',
            'WEGE3',
            'JBSS3',
            'RENT3',
            'CSAN3'
        ];

        return [
            'user_id' => User::factory(), // Cria um usuário automaticamente associado ao ativo
            'ticker' => $this->faker->randomElement($tickers),
            'lpa' => $this->faker->randomFloat(2, 0, 10),
            'vpa' => $this->faker->randomFloat(2, 0, 10),
        ];
    }
}
