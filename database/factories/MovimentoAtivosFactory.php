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

        $tickers2 = [
            'FIII10',
            'FIII20',
            'FIII30',
            'FIII40',
            'FIII50',
            'FIII60',
            'FIII70',
            'FIII80',
            'FIII90',
            'FIII91'
        ];

        $tipo = $this->faker->randomElement(['fundo imobiliario', 'acao']);
        $tickersList = ($tipo === 'acao') ? $tickers : $tickers2;
        $nome = $this->faker->randomElement($tickersList);

        return [
            'user_id' => User::factory(), // Cria um usuário automaticamente associado ao ativo
            'movimento' => $this->faker->randomElement(['compra', 'venda']),
            'tipo' => $tipo,
            'nome' => $nome,
            'quantidade' => $this->faker->numberBetween(1, 100),
            'corretagem' => $this->faker->randomFloat(2, 0, 5),
            'valor' => $this->faker->randomFloat(2, 1, 100),
            'data' => $this->faker->dateTimeBetween('-20 year', 'now')->format('Y-m-d'),
            'valor_total' => function (array $attributes) {
                $valorTotal = $attributes['corretagem'] + ($attributes['valor'] * $attributes['quantidade']);
                return number_format($valorTotal, 2, '.', '');
            },
        ];
    }
}
