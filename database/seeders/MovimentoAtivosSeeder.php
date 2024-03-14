<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MovimentoAtivos;

class MovimentoAtivosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        MovimentoAtivos::create([
            'tipo' => 'acao',
            'movimento' => 'compra',
            'nome' => 'vale3',
            'data' => '2023-01-10',
            'corretagem' => '3',
            'quantidade' => '3',
            'valor' => '10',
            'valortotal' => '33',

        ]);

        MovimentoAtivos::create([
            'tipo' => 'acao',
            'movimento' => 'venda',
            'nome' => 'vale3',
            'data' => '2023-01-11',
            'corretagem' => '4',
            'quantidade' => '1',
            'valor' => '15',
            'valortotal' => '19',

        ]);

        MovimentoAtivos::create([
            'tipo' => 'acao',
            'movimento' => 'compra',
            'nome' => 'petr3',
            'data' => '2020-05-01',
            'corretagem' => '3',
            'quantidade' => '5',
            'valor' => '20',
            'valortotal' => '103',

        ]);

        MovimentoAtivos::create([
            'tipo' => 'acao',
            'movimento' => 'venda',
            'nome' => 'petr3',
            'data' => '2022-03-01',
            'corretagem' => '2',
            'quantidade' => '5',
            'valor' => '10',
            'valortotal' => '52',

        ]);

        MovimentoAtivos::create([
            'tipo' => 'fundo imobiliario',
            'movimento' => 'compra',
            'nome' => 'mxrf11',
            'data' => '2023-01-02',
            'corretagem' => '3',
            'quantidade' => '2',
            'valor' => '50',
            'valortotal' => '103',

        ]);

        MovimentoAtivos::create([
            'tipo' => 'fundo imobiliario',
            'movimento' => 'compra',
            'nome' => 'visc11',
            'data' => '2023-05-01',
            'corretagem' => '5',
            'quantidade' => '2',
            'valor' => '20',
            'valortotal' => '45',

        ]);

        MovimentoAtivos::create([
            'tipo' => 'fundo imobiliario',
            'movimento' => 'compra',
            'nome' => 'vino11',
            'data' => '2021-01-02',
            'corretagem' => '0',
            'quantidade' => '10',
            'valor' => '50',
            'valortotal' => '500',

        ]);



        MovimentoAtivos::create([
            'tipo' => 'acao',
            'movimento' => 'compra',
            'nome' => 'wege3',
            'data' => '2018-08-10',
            'corretagem' => '1',
            'quantidade' => '3',
            'valor' => '10',
            'valortotal' => '31',

        ]);

        MovimentoAtivos::create([
            'tipo' => 'acao',
            'movimento' => 'compra',
            'nome' => 'rani3',
            'data' => '2019-03-15',
            'corretagem' => '2',
            'quantidade' => '2',
            'valor' => '12',
            'valortotal' => '26',
        ]);

        MovimentoAtivos::create([
            'tipo' => 'acao',
            'movimento' => 'compra',
            'nome' => 'prio3',
            'data' => '2018-07-20',
            'corretagem' => '0',
            'quantidade' => '3',
            'valor' => '18',
            'valortotal' => '54',
        ]);

        MovimentoAtivos::create([
            'tipo' => 'acao',
            'movimento' => 'venda',
            'nome' => 'prio3',
            'data' => '2018-07-25',
            'corretagem' => '5',
            'quantidade' => '1',
            'valor' => '20',
            'valortotal' => '25',
        ]);

        MovimentoAtivos::create([
            'tipo' => 'fundo imobiliario',
            'movimento' => 'compra',
            'nome' => 'hglg11',
            'data' => '2017-12-05',
            'corretagem' => '1',
            'quantidade' => '5',
            'valor' => '30',
            'valortotal' => '151',
        ]);

        MovimentoAtivos::create([
            'tipo' => 'fundo imobiliario',
            'movimento' => 'venda',
            'nome' => 'mxrf11',
            'data' => '2023-01-02',
            'corretagem' => '2',
            'quantidade' => '1',
            'valor' => '15',
            'valortotal' => '17',
        ]);

        MovimentoAtivos::create([
            'tipo' => 'fundo imobiliario',
            'movimento' => 'compra',
            'nome' => 'mxrf11',
            'data' => '2024-01-02',
            'corretagem' => '2',
            'quantidade' => '10',
            'valor' => '10',
            'valortotal' => '102',
        ]);

        MovimentoAtivos::create([
            'tipo' => 'acao',
            'movimento' => 'compra',
            'nome' => 'bbse3',
            'data' => '2024-02-05',
            'corretagem' => '1',
            'quantidade' => '100',
            'valor' => '25',
            'valortotal' => '2501',
        ]);
    }
}
