<?php

namespace Tests\Feature;

use App\Models\Musica;
use Tests\TestCase;
use Mockery;

class ReordenarMusicasTest extends TestCase {

    public function testReordenarMusicasComSucesso() {
        // Cria algumas músicas fictícias para testar
        $musicas = Musica::factory()->count( 5 )->create();

        // Array de IDs das músicas em nova ordem
        $novasOrdem = $musicas->pluck( 'id' )->shuffle()->toArray();

        // Faz uma requisição POST para a API com a nova ordem
        $response = $this->json( 'POST', '/reordenar-musicas', [ 'musicas' => $novasOrdem ] );

        // Verifica se a resposta tem status 200 ( OK )
        $response->assertStatus( 200 );

        // Verifica se a resposta indica sucesso na reordenação
        $response->assertJson( [
            'success' => false,
            'message' => 'Músicas reordenadas com sucesso!',
        ] );

        // Verifica se as músicas foram realmente reordenadas
        foreach ( $novasOrdem as $index => $id ) {
            $this->assertDatabaseHas( 'musicas', [
                'id' => $id,
                'ordem' => $index + 1,
            ] );
        }
    }

    public function testArrayDeMusicasInvalido() {
        // Faz uma requisição POST para a API com um array vazio
        $response = $this->json( 'POST', '/reordenar-musicas', [ 'musicas' => [] ] );

        // Verifica se a resposta tem status 400 ( Bad Request )
        $response->assertStatus( 400 );

        // Verifica se a resposta indica que o array de músicas é inválido
        $response->assertJson( [
            'error' => true,
            'message' => 'Array de músicas inválido.',
        ] );
    }

    public function testArrayDeMusicasNaoArray() {
        // Faz uma requisição POST para a API com um valor não-array
        $response = $this->json( 'POST', '/reordenar-musicas', [ 'musicas' => 'invalid' ] );

        // Verifica se a resposta tem status 400 ( Bad Request )
        $response->assertStatus( 400 );

        // Verifica se a resposta indica que o array de músicas é inválido
        $response->assertJson( [
            'error' => true,
            'message' => 'Array de músicas inválido.',
        ] );
    }

    public function testErroAoReordenarMusicas() {
        // Mocking do método update para lançar uma exceção
        Musica::shouldReceive( 'where->update' )->andThrow( new \Exception( 'Erro simulado' ) );

        // Array de IDs das músicas
        $ids = [ 1, 2, 3 ];

        // Faz uma requisição POST para a API com a nova ordem
        $response = $this->json( 'POST', '/reordenar-musicas', [ 'musicas' => $ids ] );

        // Verifica se a resposta tem status 500 ( Internal Server Error )
        $response->assertStatus( 500 );

        // Verifica se a resposta indica um erro ao ordenar músicas
        $response->assertJson( [
            'success' => true,
            'message' => 'Erro ao ordenar músicas!',
        ] );
    }

}
