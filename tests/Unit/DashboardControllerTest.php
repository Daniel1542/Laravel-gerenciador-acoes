<?php

namespace Tests\Unit;

use App\Http\Controllers\DashboardController;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\MovimentoAtivos;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function returnsCorrectValuesForDashboard()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        // Criar alguns movimentos de ativos para o usuário
        MovimentoAtivos::factory()->create([
            'user_id' => $user->id,
            'tipo' => 'acao',
            'nome' => 'ABCB4',
        ]);
        MovimentoAtivos::factory()->create([
            'user_id' => $user->id,
            'tipo' => 'acao',
            'nome' => 'APET3',
        ]);
        MovimentoAtivos::factory()->create([
            'user_id' => $user->id,
            'tipo' => 'fundo imobiliario',
            'nome' => 'GGRC11',
        ]);
        MovimentoAtivos::factory()->create([
            'user_id' => $user->id,
            'tipo' => 'fundo imobiliario',
            'nome' => 'GGRA11',
        ]);

        // Chamar o método dash
        $response = $this->get(route('principal.dashboard'));

        // Verificar se o status da resposta é 200 (OK)
        $response->assertStatus(200);

        // Verificar se a view correta é retornada
        $response->assertViewIs('principal.dashboard');

        // Verificar se os valores retornados na view estão corretos
        $response->assertViewHasAll([
            'acoesCount' => 2,
            'fiisCount' => 2,
            'acoesPercent' => 50,
            'fiisPercent' => 50,
        ]);
    }

    public function testReturnsJsonResponseWithAtivosGrafico()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Criar alguns movimentos de ações para o usuário autenticado
        MovimentoAtivos::factory()->create([
            'user_id' => $user->id,
            'tipo' => 'acao',
            'movimento' => 'compra',
            'nome' => 'XYZ',
        ]);
        MovimentoAtivos::factory()->create([
            'user_id' => $user->id,
            'tipo' => 'acao',
            'movimento' => 'venda',
            'nome' => 'XYZ',
        ]);
        MovimentoAtivos::factory()->create([
            'user_id' => $user->id,
            'tipo' => 'acao',
            'movimento' => 'compra',
            'nome' => 'ABC',
        ]);

        $response = $this->get(route('principal.graficoAcoes'));
        $response = $this->get(route('principal.graficoFiis'));
        $response = $this->get(route('principal.graficoTotal'));

        // Verificar a estrutura dos dados do JSON
        $response->assertJsonStructure([
            'labels',
            'datasets' => [
                [
                    'data',
                    'backgroundColor',
                ]
            ]
        ]);

        // Verificar se os dados JSON contêm os ativos esperados
        $response->assertJsonFragment([
            'labels' => ['XYZ', 'ABC'],
        ]);
    }
}
