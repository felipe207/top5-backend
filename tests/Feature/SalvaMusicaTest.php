<?php

namespace Tests\Feature;

use App\Http\Controllers\MusicasController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Mockery;
use Tests\TestCase;

class SalvaMusicaTest extends TestCase {
    use RefreshDatabase;

    public function testSalvaMusicaComDadosValidos() {
        // Cria uma instância do controlador
        $controller = new MusicasController();
        // Dados de entrada simulados
        $input = [ 'link' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', ];
        // Cria uma solicitação HTTP simulada com os dados de entrada
        $request = Request::create( '/salva-musica', 'POST', $input );

        // dd($request);
        // Chama o método salva do controlador
        $response = $controller->salva( $request );
        // Decodifica a resposta JSON
        $responseData = $response->getData();
        // Verifica se a resposta foi um sucesso
        $this->assertFalse( $responseData->error );
        $this->assertEquals( 'Música salva com sucesso!', $responseData->message );
        // Verifica se a música foi salva no banco de dados
        $this->assertDatabaseHas( 'musicas', [ 'link' => $input[ 'link' ], 'status' => 'ativo', 'visualizacoes' => 0, 'ano' => date( 'Y' ), 'autor' => 'Autor Desconhecido' ] );
    }

    public function testSalvaMusicaComErro() {
        // Cria uma instância do controlador
        $controller = Mockery::mock('App\Http\Controllers\MusicasController')->makePartial();
        // Gera uma exceção quando o método salva é chamado
        $controller->shouldReceive( 'getYouTubeVideoInfo' )->andThrow( \Exception::class );
        // Dados de entrada simulados
        $input = [ 'link' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', ];
        // Cria uma solicitação HTTP simulada com os dados de entrada
        $request = Request::create( '/salva-musica', 'POST', $input );
        // Chama o método salva do controlador
        $response = $controller->salva( $request );
        // Decodifica a resposta JSON
        $responseData = $response->getData();
        // Verifica se a resposta indicou erro
        $this->assertTrue( $responseData->error );
        $this->assertEquals( 'Erro ao salvar música!', $responseData->message );
    }
}
