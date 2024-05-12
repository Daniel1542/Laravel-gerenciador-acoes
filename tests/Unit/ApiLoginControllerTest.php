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
            'password' => bcrypt('StrongPassword23'),
        ]);

        // Dados de credenciais válidas
        $validCredentials = [
            'email' => 'test@example.com',
            'password' => 'StrongPassword23',
        ];

        // Envia uma solicitação HTTP POST para o método login() com credenciais válidas
        $response = $this->post('/api/login', $validCredentials);

        // Verifica se a resposta foi bem-sucedida (código 200)
        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);

        // Verifica se a resposta contém os dados esperados (por exemplo, token de autenticação)

        // Dados de credenciais inválidas
        $invalidCredentials = [
            'email' => 'test@example.com',
            'password' => 'wrongPasswd1',
        ];

        // Envia uma solicitação HTTP POST para o método login() com credenciais inválidas
        $response = $this->post('/api/login', $invalidCredentials);

        // Verifica se a resposta indica erro de autenticação (código 401)
        $response->assertStatus(401);

        // Verifica se a resposta contém a mensagem de erro esperada
    }
}
