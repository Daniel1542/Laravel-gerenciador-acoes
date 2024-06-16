<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\MovimentoAtivos;
use Carbon\Carbon;

class AtivosControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testItStoresNewMovimentoAtivos()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
                         ->postJson(route('ativos.store'), [
                            'tipo' => 'fundo imobiliario',
                            'movimento' => 'compra',
                            'nome' => 'ABCB4',
                            'quantidade' => 10,
                            'corretagem' => 5.5,
                            'valor' => 100,
                            'data' => '2024-04-30',
                         ]);

        // Verificar se o status da resposta é 302 (redirecionamento)
        $response->assertStatus(302);
        $this->assertDatabaseHas('movimento_ativos', [
            'user_id' => $user->id,
            'tipo' => 'fundo imobiliario',
            'movimento' => 'compra',
            'nome' => 'ABCB4',
            'quantidade' => 10,
            'corretagem' => 5.5,
            'valor' => 100,
            'valor_total' => 5.5 + (100 * 10),
            'data' => '2024-04-30 00:00:00',
        ]);
    }

    public function testItRendersEditViewWithAtivoData()
    {
        $user = User::factory()->create();
        $ativo = MovimentoAtivos::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
                         ->get(route('ativos.edit', ['id' => $ativo->id]));

        $response->assertStatus(200);
        $response->assertViewIs('crud.editarAtivo');

        $response->assertViewHas('ativos', $ativo);
    }

    public function testUpdateMovimentoAtivos()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $movimento = MovimentoAtivos::factory()->create(['user_id' => $user->id]);

        // Definindo os dados para atualização
        $data = [
            'tipo' => 'fundo imobiliario',
            'movimento' => 'compra',
            'nome' => 'XYZT11',
            'data' => Carbon::create(2024, 6, 10),
            'corretagem' => 10.0,
            'quantidade' => 30,
            'valor' => 50.0,
        ];

        $response = $this->put(route('ativos.update', ['ativo' => $movimento->id]), $data);
        $response->assertRedirect(route('movimento.index'));
        $this->assertEquals('Movimento atualizado com sucesso.', session('msg'));

        $movimentoAtualizado = $movimento->fresh();

        $this->assertEquals($data['tipo'], $movimentoAtualizado->tipo);
        $this->assertEquals($data['movimento'], $movimentoAtualizado->movimento);
        $this->assertEquals($data['nome'], $movimentoAtualizado->nome);
        $this->assertEquals($data['data'], $movimentoAtualizado->data);
        $this->assertEquals($data['corretagem'], $movimentoAtualizado->corretagem);
        $this->assertEquals(
            $data['corretagem'] + ($data['valor'] * $data['quantidade']),
            $movimentoAtualizado->valor_total
        );
        $this->assertEquals($data['quantidade'], $movimentoAtualizado->quantidade);
        $this->assertEquals($data['valor'], $movimentoAtualizado->valor);
    }

    public function testDestroyMovimentoAtivos()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $ativo = MovimentoAtivos::factory()->create(['user_id' => $user->id]);

        $response = $this->delete(route('ativos.destroy', ['id' => $ativo->id]));
        $response->assertRedirect(route('movimento.index'));
        $this->assertEquals('Ativo na lista excluído com sucesso.', session('msg'));

        $this->assertDatabaseMissing('movimento_ativos', ['id' => $ativo->id]);
    }

    public function testShowMovimentoAtivos()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $ativos = MovimentoAtivos::factory()->count(3)->create(['user_id' => $user->id]);

        // Simular uma requisição com o nome de cada ativo existente
        foreach ($ativos as $ativo) {
            $nomeAtivo = $ativo->nome;
            $response = $this->get(route('ativos.show', ['Nome' => $nomeAtivo]));

            $response->assertStatus(200);
            $response->assertViewIs('crud.mostrarAtivo');

            // Converter o array $dadosAtivos em uma coleção usando collect()
            $dadosAtivos = collect($response->original->getData()['dadosAtivos']);

            // Verificar se os dados do ativo foram passados para a view corretamente para cada ativo
            $this->assertTrue($dadosAtivos->contains('nome', $nomeAtivo));
        }
    }
}