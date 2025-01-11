<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AuthTest extends TestCase {
    public function testLoginComSucesso()
    {
        // Cria um usuário fictício para testar
        $user = User::factory()->create([
            'password' => bcrypt($password = 'password'),
        ]);

        // Faz uma requisição POST para a API de login
        $response = $this->json('POST', '/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        // Verifica se a resposta tem status 200 (OK)
        $response->assertStatus(200);

        // Verifica se a resposta contém o token e os dados do usuário
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'token',
                'user' => [
                    'id',
                    'name',
                    'email',
                    // Inclua outros campos relevantes aqui
                ],
            ],
        ]);
    }

    public function testCredenciaisInvalidas()
    {
        // Faz uma requisição POST para a API de login com credenciais inválidas
        $response = $this->json('POST', '/login', [
            'email' => 'invalid@example.com',
            'password' => 'invalid-password',
        ]);

        // Verifica se a resposta tem status 200 (OK)
        $response->assertStatus(200);

        // Verifica se a resposta indica que as credenciais não coincidem
        $response->assertJson([
            'success' => true,
            'message' => 'As credenciais não coincidem com nossos registros!',
        ]);
    }

    public function testLoginErro()
    {
        // Mocking do método attempt para lançar uma exceção
        Auth::shouldReceive('attempt')->andThrow(new \Exception('Erro simulado'));

        // Faz uma requisição POST para a API de login
        $response = $this->json('POST', '/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        // Verifica se a resposta tem status 500 (Internal Server Error)
        $response->assertStatus(500);

        // Verifica se a resposta indica um erro
        $response->assertJson([
            'success' => true,
            'message' => 'Erro ao salvar música!',
        ]);
    }

    public function testLogout()
{
    // Simula a autenticação de um usuário
    $user = User::factory()->create();
    $this->actingAs($user);

    // Faz uma requisição POST para a API de logout
    $response = $this->json('POST', '/logout');

    // Verifica se a resposta tem status 200 (OK)
    $response->assertStatus(200);

    // Verifica se a resposta indica que o usuário foi deslogado com sucesso
    $response->assertJson([
        'message' => 'Deslogado com sucesso!',
    ]);

    // Verifica se o usuário não está mais autenticado
    $this->assertGuest();
}

public function testUser()
{
    // Simula a autenticação de um usuário
    $user = User::factory()->create();
    $this->actingAs($user);

    // Faz uma requisição GET para a API de user
    $response = $this->json('GET', '/user');

    // Verifica se a resposta tem status 200 (OK)
    $response->assertStatus(200);

    // Verifica se a resposta contém os dados do usuário
    $response->assertJson([
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        // Inclua outros campos relevantes aqui
    ]);
}


}
