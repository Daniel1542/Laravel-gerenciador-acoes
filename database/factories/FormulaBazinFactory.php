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
            'lpa' => $this->faker->randomFloat(2, 0, 12),
            'payout' => $this->faker->randomFloat(2, 0, 100),
            'yield_projetado' => $this->faker->numberBetween(1, 15),              
        ];
    }
}