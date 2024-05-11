<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class ApiLoginControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testLogin()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // Dados de credenciais válidas
        $validCredentials = [
            'email' => 'test@example.com',
            'password' => 'password',
        ];

        // Envia uma solicitação HTTP POST para o método login() com credenciais válidas
        $response = $this->post('/login', $validCredentials);

        // Verifica se a resposta foi bem-sucedida (código 200)
        $response->assertStatus(200);

        // Verifica se a resposta contém os dados esperados (por exemplo, token de autenticação)

        // Dados de credenciais inválidas
        $invalidCredentials = [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ];

        // Envia uma solicitação HTTP POST para o método login() com credenciais inválidas
        $response = $this->post('/login', $invalidCredentials);

        // Verifica se a resposta indica erro de autenticação (código 401)
        $response->assertStatus(401);

        // Verifica se a resposta contém a mensagem de erro esperada
    }

}
