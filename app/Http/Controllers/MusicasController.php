<?php

namespace App\Http\Controllers;

use App\Api\ApiMessage;
use App\Http\Resources\MusicasResource;
use App\Models\Musica;
use Illuminate\Http\Request;

class MusicasController extends Controller {

    public function salva( Request $request ) {
        try {
            $input = $request->all();
            if ( !isset( $input['status'] ) ) $input['status'] = 'ativo';
            if ( !isset( $input['visualizacoes'] ) ) $input['visualizacoes'] = 0;
            if ( !isset( $input['ano'] ) ) $input['ano'] = date( 'Y' );
            if ( !isset( $input['estilo'] ) ) $input['estilo'] = 'Sertanejo';
            if ( !isset( $input['autor'] ) ) $input['autor'] = 'Tião Carreiro & Pardinho';
            if ( !isset( $input['nome'] ) ) $input['nome'] = 'Boi Soberano';

            $musica = Musica::create( $input );

            $response = new ApiMessage( false, 'Música salva com sucesso!', $musica );
            return response()->json( $response->getResponse() );

        } catch ( \Throwable $th ) {
            $response = new ApiMessage( true, 'Erro ao salvar música!', $th->getMessage() );
            return response()->json( $response->getResponse() );
        }
    }

    public function musicas( Request $request )
    {
        try {
            $musicas = Musica::where( 'status', 'ativo' )->get();
            $result = [];

            $result = MusicasResource::collection( $musicas );
            $response = new ApiMessage( false, 'Músicas encontradas!', $result );
            return response()->json( $response->getResponse() );

        } catch ( \Throwable $th ) {
            $response = new ApiMessage( true, 'Erro ao buscar músicas!', $th->getMessage() );
            return response()->json( $response->getResponse() );
        }
    }
}
