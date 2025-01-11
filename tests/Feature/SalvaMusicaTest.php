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
        $controller = new MusicasController();
        $input = [ 'link' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', ];
        $request = Request::create( '/salva-musica', 'POST', $input );
        $response = $controller->salva( $request );
        $responseData = $response->getData();
        $this->assertFalse( $responseData->error );
        $this->assertEquals( 'Música salva com sucesso!', $responseData->message );
        $this->assertDatabaseHas( 'musicas', [ 'link' => $input[ 'link' ], 'status' => 'ativo', 'visualizacoes' => 0, 'ano' => date( 'Y' ), 'autor' => 'Autor Desconhecido' ] );
    }

    public function testSalvaMusicaComErro() {
        $controller = Mockery::mock('App\Http\Controllers\MusicasController')->makePartial();
        $controller->shouldReceive( 'getYouTubeVideoInfo' )->andThrow( \Exception::class );
        $input = [ 'link' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', ];
        $request = Request::create( '/salva-musica', 'POST', $input );
        $response = $controller->salva( $request );
        $responseData = $response->getData();
        $this->assertTrue( $responseData->error );
        $this->assertEquals( 'Erro ao salvar música!', $responseData->message );
    }
}
