<?php

namespace Tests\Feature;

use App\Http\Controllers\MusicasController;
use App\Models\Musica;
use Illuminate\Http\Request;
use Tests\TestCase;

class GetMusicaTest extends TestCase {
    public function testBuscarMusicaPorId() {

        Musica::factory()->create();
        $controller = new MusicasController();

        $request = Request::create( '/musicas/1', 'GET' );
        $response = $controller->musicas( $request );
        $responseData = $response->getData();
        $this->assertFalse( $responseData->error );

    }

}
