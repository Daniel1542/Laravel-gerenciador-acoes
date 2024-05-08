<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\MovimentoAtivos;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function ReturnsCorrectValuesForDashboard()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        // Criar alguns movimentos de ativos para o usuário
        MovimentoAtivos::factory()->create([
            'user_id' => $user->id,
            'tipo' => 'acao',
            'nome' => 'A1',
        ]);
        MovimentoAtivos::factory()->create([
            'user_id' => $user->id,
            'tipo' => 'acao',
            'nome' => 'A2',
        ]);
        MovimentoAtivos::factory()->create([
            'user_id' => $user->id,
            'tipo' => 'fundo imobiliario',
            'nome' => 'F1',
        ]);
        MovimentoAtivos::factory()->create([
            'user_id' => $user->id,
            'tipo' => 'fundo imobiliario',
            'nome' => 'F2',
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
}
