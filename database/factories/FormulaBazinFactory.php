<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\FormulaBazin;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FormulaBazin>
 */
class FormulaBazinFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FormulaBazin::class;

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
            'dividend_yield' => $this->faker->numberBetween(1, 12),
            'dpa' => $this->faker->randomFloat(2, 0, 12),
        ];
    }
}
