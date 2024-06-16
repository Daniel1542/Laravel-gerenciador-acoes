<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\FormulaBazin;
use App\Models\FormulaGraham;
use Tests\TestCase;


class FormulaControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function testIndex()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        FormulaBazin::factory()->count(2)->create(['user_id' => $user->id]);
        FormulaGraham::factory()->count(2)->create(['user_id' => $user->id]);

        $response = $this->get('/formula');

        $response->assertStatus(200);
        $response->assertViewIs('formula.formulas');
        $response->assertViewHas('dadosBazin');
        $response->assertViewHas('dadosGraham');
       
    }

     public function testItDownloadsGrahamExcel()
     {
        $user = User::factory()->create();
        $this->actingAs($user);
        // Faz uma requisição GET para a rota do método opcoesFormula com 'graham'
        $response = $this->get(route('formula.opcoesFormula', ['planilha' => 'graham']));

        // Verifica se a resposta é um download do arquivo correto
        $response->assertStatus(200);
        $response->assertHeader('Content-Disposition', 'attachment; filename=bejamim_graham.xlsx');
     }
}
