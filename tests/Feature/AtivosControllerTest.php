<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\MovimentoAtivos;

class AtivosControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function itStoresNewMovimentoAtivos()
    {
        // Criar um usuário para autenticação
        $user = User::factory()->create();

        // Simular uma requisição com os dados necessários
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

        // Verificar se o movimento foi armazenado corretamente no banco de dados
        $this->assertDatabaseHas('movimento_ativos', [
            'user_id' => $user->id,
            'tipo' => 'fundo imobiliario',
            'movimento' => 'compra',
            'nome' => 'ABCB4',
            'quantidade' => 10,
            'corretagem' => 5.5,
            'valor' => 100,
            'valor_total' => 5.5 + (100 * 10),
            'data' => '2024-04-30',
        ]);
    }

    public function testItRendersEditViewWithAtivoData()
    {
        $user = User::factory()->create();

        // Cria um ativo para o usuário
        $ativo = MovimentoAtivos::factory()->create(['user_id' => $user->id]);

        // Simula uma requisição para o método edit
        $response = $this->actingAs($user)
                         ->get(route('ativos.edit', ['id' => $ativo->id]));

        // Verificar se o status da resposta é 200 (sucesso)
        $response->assertStatus(200);

        // Verificar se a view editarAtivo está sendo renderizada
        $response->assertViewIs('crud.editarAtivo');

        // Verificar se os dados do ativo estão sendo passados para a view
        $response->assertViewHas('ativos', $ativo);
    }

    public function testUpdateMovimentoAtivos()
    {
        $user = User::factory()->create();

        // Autenticando o usuário
        $this->actingAs($user);

        $movimento = MovimentoAtivos::factory()->create(['user_id' => $user->id]);

        // Definindo os dados para atualização
        $data = [
            'tipo' => 'fundo imobiliario',
            'movimento' => 'compra',
            'nome' => 'XYZT11',
            'data' => now()->subDay(),
            'corretagem' => 10.0,
            'quantidade' => 30,
            'valor' => 50.0,
        ];

        // Fazendo uma requisição de atualização
        $response = $this->put(route('ativos.update', ['ativo' => $movimento->id]), $data);

        // Verificando se a atualização foi bem-sucedida e redirecionou corretamente
        $response->assertRedirect(route('movimento.index'));

        // Verificando se a mensagem de sucesso está presente na sessão
        $this->assertEquals('Movimento atualizado com sucesso.', session('msg'));

        // Recarregando o movimento atualizado do banco de dados
        $movimentoAtualizado = $movimento->fresh();

        // Verificando se os dados foram atualizados corretamente
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

        // Criando um movimento de ativos de exemplo para o usuário
        $ativo = MovimentoAtivos::factory()->create(['user_id' => $user->id]);

        // Fazendo uma solicitação de exclusão do ativo
        $response = $this->delete(route('ativos.destroy', ['id' => $ativo->id]));

        // Verificando se a exclusão foi bem-sucedida e redirecionou corretamente
        $response->assertRedirect(route('movimento.index'));

        // Verificando se a mensagem de sucesso está presente na sessão
        $this->assertEquals('Ativo na lista excluído com sucesso.', session('msg'));

        // Verificando se o ativo foi removido do banco de dados
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

            // Verificar se o status da resposta é 200 (OK) para cada ativo
            $response->assertStatus(200);

            // Verificar se a view correta foi retornada para cada ativo
            $response->assertViewIs('crud.mostrarAtivo');

            // Converter o array $dadosAtivos em uma coleção usando collect()
            $dadosAtivos = collect($response->original->getData()['dadosAtivos']);

            // Verificar se os dados do ativo foram passados para a view corretamente para cada ativo
            $this->assertTrue($dadosAtivos->contains('nome', $nomeAtivo));
        }
    }
}
