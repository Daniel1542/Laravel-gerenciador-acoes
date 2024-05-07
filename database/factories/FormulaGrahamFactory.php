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
        return [
            'user_id' => User::factory(), // Cria um usuário automaticamente associado ao ativo
            'ticker' => $this->faker->boolean ? strtoupper($this->faker->bothify('????##')) : strtoupper($this->faker->bothify('????#')),
            'lpa' => $this->faker->numberFloat(2, 0, 50),
            'vpa' => $this->faker->randomFloat(2, 0, 50),
        ];
    }
}
