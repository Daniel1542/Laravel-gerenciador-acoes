<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\MovimentoAtivos;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class ApiAtivoControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa o método index para um usuário autenticado.
     */
    public function testIndexReturnsUserMovimentos()
    {
        $user = User::factory()->create(['password' => bcrypt('password123')]);

        // Faz a requisição de login para obter o token
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertStatus(200);
        $token = $response->json('token');


        MovimentoAtivos::factory()->count(3)->create(['user_id' => $user->id]);

        // Faz a requisição para o endpoint index com o token de autenticação
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
                         ->getJson('/api/ativos');

        // Verifica se a resposta está correta
        $response->assertStatus(200);
        $response->assertJsonCount(3);

        // Verifica se os dados retornados são os esperados
        $response->assertJsonStructure([
            '*' => [
                'id', 'user_id', 'tipo', 'movimento', 'nome', 'data', 'corretagem', 'quantidade', 'valor', 'valor_total', 'created_at', 'updated_at'
            ]
        ]);
    }

    /**
     * Testa o método index para um usuário não autenticado.
     */
    public function testIndexReturnsUnauthenticated()
    {
        // Faz a requisição para o endpoint index sem autenticação
        $response = $this->getJson('/api/ativos');

        // Verifica se a resposta está correta
        $response->assertStatus(401);
    }

    public function testStoreAtivos()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Dados de movimento de ativo válidos
        $dados = [
            'tipo' => 'fundo imobiliario',
            'movimento' => 'compra',
            'nome' => 'abc123',
            'data' => now()->toDateString(),
            'corretagem' => 10.50,
            'quantidade' => 100,
            'valor' => 50.75,
        ];

        // Envia uma solicitação HTTP POST para o método store()
        $response = $this->post('/api/api-ativo', $dados);

        // Verifica se o movimento foi cadastrado com sucesso
        $response->assertStatus(200)->assertSee('Cadastrado com sucesso.');

        // Verifica se o movimento foi realmente salvo no banco de dados
        $this->assertDatabaseHas('movimento_ativos', [
            'tipo' => $dados['tipo'],
            'movimento' => $dados['movimento'],
            'nome' => $dados['nome'],
            'corretagem' => $dados['corretagem'],
            'quantidade' => $dados['quantidade'],
            'valor' => $dados['valor'],
            'data' => $dados['data'],
            'valor_total' => round($dados['corretagem'] + ($dados['valor'] * $dados['quantidade']), 2),
        ]);
    }
    public function testShowAtivos()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Cria um registro de movimento de ativo
        $movimentoAtivo = MovimentoAtivos::factory()->create(['user_id' => $user->id]);

        // Chama o método show() com o ID do movimento ativo criado
        $response = $this->get('/api/api-ativo/' . $movimentoAtivo->id);

        // Verifica se a resposta foi bem-sucedida
        $response->assertStatus(200);

        // Verifica se os dados retornados correspondem aos dados do movimento ativo criado
        $response->assertJson([
            'id' => $movimentoAtivo->id,
            // Adicione outras asserções para os outros campos se necessário
        ]);
    }
    public function testUpdateAtivos()
    {

        $user = User::factory()->create();
        $this->actingAs($user);

        // Cria um registro de movimento de ativo
        $movimentoAtivo = MovimentoAtivos::factory()->create();

        // Dados para atualização
        $dadosAtualizados = [
            'tipo' => 'acao',
            'movimento' => 'compra',
            'nome' => 'abc123',
            'data' => now()->toDateString(),
            'corretagem' => 20.00,
            'quantidade' => 200,
            'valor' => 30.50,
        ];

        // Envia uma solicitação HTTP PUT para o método update()
        $response = $this->put('/api/api-ativo/' . $movimentoAtivo->id, $dadosAtualizados);

        // Verifica se a resposta foi bem-sucedida
        $response->assertStatus(200);

        // Verifica se a mensagem de sucesso é retornada
        $response->assertSee('Movimento atualizado com sucesso.');

        // Atualiza os dados do movimento ativo com os dados atualizados
        $movimentoAtivo->refresh();

        // Verifica se os dados do movimento ativo foram atualizados corretamente
        $this->assertEquals($dadosAtualizados['tipo'], $movimentoAtivo->tipo);
        $this->assertEquals($dadosAtualizados['movimento'], $movimentoAtivo->movimento);
        $this->assertEquals($dadosAtualizados['nome'], $movimentoAtivo->nome);
        $this->assertEquals($dadosAtualizados['data'], $movimentoAtivo->data);
        $this->assertEquals($dadosAtualizados['corretagem'], $movimentoAtivo->corretagem);
        $this->assertEquals($dadosAtualizados['quantidade'], $movimentoAtivo->quantidade);
        $this->assertEquals($dadosAtualizados['valor'], $movimentoAtivo->valor);
        $this->assertEquals(
            $dadosAtualizados['corretagem'] + ($dadosAtualizados['valor'] * $dadosAtualizados['quantidade']),
            $movimentoAtivo->valor_total
        );
    }

    public function testDestroy()
    {
        // Cria um usuário autenticado
        $user = User::factory()->create();
        $this->actingAs($user);

        // Cria um registro de movimento de ativo
        $movimentoAtivo = MovimentoAtivos::factory()->create();

        // Envia uma solicitação HTTP DELETE para o método destroy()
        $response = $this->delete('/api/api-ativo/' . $movimentoAtivo->id);

        // Verifica se a resposta foi bem-sucedida
        $response->assertStatus(200);

        // Verifica se o movimento ativo foi deletado do banco de dados
        $this->assertDatabaseMissing('movimento_ativos', [
            'id' => $movimentoAtivo->id
        ]);
    }
}
