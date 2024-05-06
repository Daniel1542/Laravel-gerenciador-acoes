<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\MovimentoAtivos;

class AtivosControllerTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function it_stores_a_new_movimento_ativo()
    {
        // Criar um usuário para autenticação
        $user = User::factory()->create();

        // Simular uma requisição com os dados necessários
        $response = $this->actingAs($user)
                         ->postJson(route('ativos.store'), [
                             'tipo' => 'fundo imobiliario',
                             'movimento' => 'compra',
                             'nome' => 'ABC123',
                             'quantidade' => 10,
                             'corretagem' => 5.0,
                             'valor' => 100.0,
                             'data' => '2024-04-30',
                         ]);

        // Verificar se o status da resposta é 302 (redirecionamento)
        $response->assertStatus(302);

        // Verificar se o movimento foi armazenado corretamente no banco de dados
        $this->assertDatabaseHas('movimento_ativos', [
            'user_id' => $user->id,
            'tipo' => 'fundo imobiliario',
            'movimento' => 'compra',
            'nome' => 'ABC123',
            'quantidade' => 10,
            'corretagem' => 5.0,
            'valor' => 100.0,
            'valor_total' => 5.0 + (100.0 * 10),
            'data' => '2024-04-30',
        ]);
    }
    public function test_it_renders_edit_view_with_ativo_data()
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
}
