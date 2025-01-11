<?php

namespace Tests\Feature;

use App\Http\Controllers\MusicasController;
use App\Models\Musica;
use Illuminate\Http\Request;
use Tests\TestCase;

class ReordenarMusicasTest extends TestCase {

    public function testReordenarMusicasComSucesso() {
        $musica = Musica::first();
        if ( !$musica ) $this->seed( 'MusicaSeeder' );
        $musicasIds = Musica::pluck( 'id' )->toArray();
        shuffle( $musicasIds );
        $controller = new MusicasController();
        $request = Request::create( '/musicas/reordenar', 'GET' , [ 'musicas' => $musicasIds ] );
        $response = $controller->reordenarMusicas( $request );
        $responseData = $response->getData();
        $this->assertFalse( $responseData->error );

    }

}
