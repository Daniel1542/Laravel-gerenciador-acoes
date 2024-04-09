<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MovimentoAtivos;

class MovimentoAtivosSeeder extends Seeder
{
    public function run()
    {
        MovimentoAtivos::create([
            'tipo' => 'acao',
            'movimento' => 'compra',
            'nome' => 'VALE3',
            'data' => '2023-01-10',
            'corretagem' => '3',
            'quantidade' => '3',
            'valor' => '10',
            'valor_total' => '33',
        ]);

        MovimentoAtivos::create([
            'tipo' => 'acao',
            'movimento' => 'venda',
            'nome' => 'VALE3',
            'data' => '2023-01-11',
            'corretagem' => '4',
            'quantidade' => '1',
            'valor' => '15',
            'valor_total' => '19',
        ]);

        MovimentoAtivos::create([
            'tipo' => 'acao',
            'movimento' => 'compra',
            'nome' => 'PETR4',
            'data' => '2020-05-01',
            'corretagem' => '3',
            'quantidade' => '5',
            'valor' => '20',
            'valor_total' => '103',
        ]);

        MovimentoAtivos::create([
            'tipo' => 'acao',
            'movimento' => 'venda',
            'nome' => 'PETR4',
            'data' => '2022-03-01',
            'corretagem' => '2',
            'quantidade' => '5',
            'valor' => '10',
            'valor_total' => '52',
        ]);

        MovimentoAtivos::create([
            'tipo' => 'fundo imobiliario',
            'movimento' => 'compra',
            'nome' => 'MXRF11',
            'data' => '2023-01-02',
            'corretagem' => '3',
            'quantidade' => '2',
            'valor' => '50',
            'valor_total' => '103',
        ]);

        MovimentoAtivos::create([
            'tipo' => 'fundo imobiliario',
            'movimento' => 'compra',
            'nome' => 'VISC11',
            'data' => '2023-05-01',
            'corretagem' => '5',
            'quantidade' => '2',
            'valor' => '20',
            'valor_total' => '45',
        ]);

        MovimentoAtivos::create([
            'tipo' => 'fundo imobiliario',
            'movimento' => 'compra',
            'nome' => 'VINO11',
            'data' => '2021-01-02',
            'corretagem' => '0',
            'quantidade' => '10',
            'valor' => '50',
            'valor_total' => '500',
        ]);

        MovimentoAtivos::create([
            'tipo' => 'acao',
            'movimento' => 'compra',
            'nome' => 'WEGE3',
            'data' => '2018-08-10',
            'corretagem' => '1',
            'quantidade' => '3',
            'valor' => '10',
            'valor_total' => '31',
        ]);

        MovimentoAtivos::create([
            'tipo' => 'acao',
            'movimento' => 'compra',
            'nome' => 'RANI3',
            'data' => '2019-03-15',
            'corretagem' => '2',
            'quantidade' => '2',
            'valor' => '12',
            'valor_total' => '26',
        ]);

        MovimentoAtivos::create([
            'tipo' => 'acao',
            'movimento' => 'compra',
            'nome' => 'PRIO3',
            'data' => '2018-07-20',
            'corretagem' => '0',
            'quantidade' => '12',
            'valor' => '18',
            'valor_total' => '216',
        ]);

        MovimentoAtivos::create([
            'tipo' => 'acao',
            'movimento' => 'venda',
            'nome' => 'PRIO3',
            'data' => '2018-07-25',
            'corretagem' => '5',
            'quantidade' => '1',
            'valor' => '20',
            'valor_total' => '25',
        ]);

        MovimentoAtivos::create([
            'tipo' => 'fundo imobiliario',
            'movimento' => 'compra',
            'nome' => 'HGLG11',
            'data' => '2017-12-05',
            'corretagem' => '1',
            'quantidade' => '5',
            'valor' => '30',
            'valor_total' => '151',
        ]);

        MovimentoAtivos::create([
            'tipo' => 'fundo imobiliario',
            'movimento' => 'venda',
            'nome' => 'MXRF11',
            'data' => '2023-01-02',
            'corretagem' => '2',
            'quantidade' => '1',
            'valor' => '15',
            'valor_total' => '17',
        ]);

        MovimentoAtivos::create([
            'tipo' => 'fundo imobiliario',
            'movimento' => 'compra',
            'nome' => 'MXRF11',
            'data' => '2024-01-02',
            'corretagem' => '2',
            'quantidade' => '10',
            'valor' => '50',
            'valor_total' => '502',
        ]);

        MovimentoAtivos::create([
            'tipo' => 'acao',
            'movimento' => 'compra',
            'nome' => 'BBSE3',
            'data' => '2024-02-05',
            'corretagem' => '1',
            'quantidade' => '100',
            'valor' => '10',
            'valor_total' => '1001',
        ]);

        MovimentoAtivos::create([
            'tipo' => 'acao',
            'movimento' => 'compra',
            'nome' => 'ABCB4',
            'data' => '2024-02-15',
            'corretagem' => '1',
            'quantidade' => '20',
            'valor' => '10.23',
            'valor_total' => '204.6',
        ]);

        MovimentoAtivos::create([
            'tipo' => 'fundo imobiliario',
            'movimento' => 'venda',
            'nome' => 'VINO11',
            'data' => '2021-05-12',
            'corretagem' => '0',
            'quantidade' => '7',
            'valor' => '40',
            'valor_total' => '280',
        ]);

        MovimentoAtivos::create([
            'tipo' => 'acao',
            'movimento' => 'compra',
            'nome' => 'RANI3',
            'data' => '2012-02-15',
            'corretagem' => '12',
            'quantidade' => '20',
            'valor' => '5',
            'valor_total' => '112',
        ]);

        MovimentoAtivos::create([
            'tipo' => 'fundo imobiliario',
            'movimento' => 'compra',
            'nome' => 'GGRC11',
            'data' => '2013-05-10',
            'corretagem' => '1.50',
            'quantidade' => '50',
            'valor' => '10',
            'valor_total' => '501.50',
        ]);

        MovimentoAtivos::create([
            'tipo' => 'fundo imobiliario',
            'movimento' => 'compra',
            'nome' => 'VGHF11',
            'data' => '2020-09-15',
            'corretagem' => '1.70',
            'quantidade' => '20',
            'valor' => '12',
            'valor_total' => '241.70',
        ]);

        MovimentoAtivos::create([
            'tipo' => 'acao',
            'movimento' => 'compra',
            'nome' => 'ABCB4',
            'data' => '2023-01-16',
            'corretagem' => '0',
            'quantidade' => '20',
            'valor' => '12',
            'valor_total' => '240',
        ]);

        MovimentoAtivos::create([
            'tipo' => 'acao',
            'movimento' => 'compra',
            'nome' => 'TAEE11',
            'data' => '2022-01-16',
            'corretagem' => '1.5',
            'quantidade' => '18',
            'valor' => '13',
            'valor_total' => '235.5',
        ]);
    }
}
