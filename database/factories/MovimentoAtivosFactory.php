<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\MovimentoAtivos;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MovimentoAtivos>
 */
class MovimentoAtivosFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MovimentoAtivos::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(), // Cria um usuário automaticamente associado ao ativo
            'tipo' => $this->faker->randomElement(['fundo imobiliario', 'acao']),
            'movimento' => $this->faker->randomElement(['compra', 'venda']),
            'nome' => $this->faker->boolean ? strtoupper($this->faker->bothify('????##')) : strtoupper($this->faker->bothify('????#')),
            'quantidade' => $this->faker->numberBetween(1, 1000),
            'corretagem' => $this->faker->randomFloat(2, 0, 10),
            'valor' => $this->faker->randomFloat(2, 1, 1000),
            'data' => $this->faker->dateTimeBetween('-20 year', 'now')->format('Y-m-d'),
            'valor_total' => function (array $attributes) {
                return $attributes['corretagem'] + ($attributes['valor'] * $attributes['quantidade']);
            },
        ];
    }
}
