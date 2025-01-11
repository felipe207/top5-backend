<?php

namespace Tests\Feature;

use Tests\TestCase;

class GetMusicaTest extends TestCase {
    // public function testBuscarMusicaPorId() {
    //     // Cria uma música fictícia para testar
    //     $musica = Musica::factory()->create();

    //     // Faz uma requisição GET para a API com o ID da música criada
    //     $response = $this->json( 'GET', "/musicas/{$musica->id}" );

    //     // Verifica se a resposta tem status 200 ( OK )
    //     $response->assertStatus( 200 );

    //     // Verifica se a resposta contém os dados da música
    //     $response->assertJson( [
    //         'success' => false,
    //         'message' => 'Música encontrada!',
    //         'data' => [
    //             'id' => $musica->id,
    //             // Inclua outros campos relevantes aqui
    //         ],
    //     ] );
    // }

    // public function testMusicaNaoEncontrada() {
    //     // Faz uma requisição GET para a API com um ID que não existe
    //     $response = $this->json( 'GET', '/musicas/999999' );

    //     // Verifica se a resposta tem status 200 ( OK )
    //     $response->assertStatus( 200 );

    //     // Verifica se a resposta indica que a música não foi encontrada
    //     $response->assertJson( [
    //         'success' => true,
    //         'message' => 'Música não encontrada!',
    //         'data' => null,
    //     ] );
    // }

    // public function testListarMusicasComPaginacao() {
    //     // Cria algumas músicas fictícias para testar
    //     Musica::factory()->count( 10 )->create();

    //     // Faz uma requisição GET para a API sem fornecer um ID
    //     $response = $this->json( 'GET', '/musicas' );

    //     // Verifica se a resposta tem status 200 ( OK )
    //     $response->assertStatus( 200 );

    //     // Verifica se a resposta contém os dados paginados das músicas
    //     $response->assertJsonStructure( [
    //         'success',
    //         'message',
    //         'data' => [
    //             'data' => [
    //                 '*' => [
    //                     'id',
    //                     // Inclua outros campos relevantes aqui
    //                 ],
    //             ],
    //             'pagination' => [
    //                 'current_page',
    //                 'last_page',
    //                 'per_page',
    //                 'total',
    //             ],
    //         ],
    //     ] );
    // }

    // public function testNenhumaMusicaEncontrada() {
    //     // Assegura que não há músicas no banco de dados
    //     Musica::truncate();

    //     // Faz uma requisição GET para a API sem fornecer um ID
    //     $response = $this->json( 'GET', '/musicas' );

    //     // Verifica se a resposta tem status 200 ( OK )
    //     $response->assertStatus( 200 );

    //     // Verifica se a resposta indica que nenhuma música foi encontrada
    //     $response->assertJson( [
    //         'success' => true,
    //         'message' => 'Nenhuma música encontrada!',
    //         'data' => null,
    //     ] );
    // }

//     public function testErroAoBuscarMusicas()
// {
//     // Usando a funcionalidade built-in do Laravel para mockar o método find
//     $mock = \Mockery::mock('overload:' . \App\Models\Musica::class);
//     $mock->shouldReceive('find')->andThrow(new \Exception('Erro simulado'));

//     // Faz uma requisição GET para a API com um ID para gerar erro
//     $response = $this->json('GET', '/musicas/1');

//     // Verifica se a resposta tem status 200 (OK)
//     $response->assertStatus(200);

//     // Verifica se a resposta indica um erro
//     $response->assertJson([
//         'success' => true,
//         'message' => 'Erro ao buscar músicas!',
//     ]);

//     // Fechar o mock
//     \Mockery::close();
// }



}
