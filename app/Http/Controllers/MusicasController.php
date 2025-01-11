<?php

namespace App\Http\Controllers;

use App\Api\ApiMessage;
use App\Http\Resources\MusicasResource;
use App\Models\Musica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MusicasController extends Controller {

    public function salva( Request $request ) {
        try {
            $input = $request->all();
            if ( !isset( $input[ 'status' ] ) ) $input[ 'status' ] = 'ativo';
            if ( !isset( $input[ 'visualizacoes' ] ) ) $input[ 'visualizacoes' ] = 0;
            if ( !isset( $input[ 'ano' ] ) ) $input[ 'ano' ] = date( 'Y' );
            if ( !isset( $input[ 'autor' ] ) ) $input[ 'autor' ] = 'Autor Desconhecido';

            $dadosVideo = $this->getYouTubeVideoInfo( $input[ 'link' ] );
            $input[ 'nome' ] = $dadosVideo[ 'title' ] ?? 'Música sem título';
            $input[ 'description' ] = $dadosVideo[ 'description' ] ?? 'Música sem descrição';
            $input[ 'thumbnail' ] = $dadosVideo[ 'thumbnail' ] ?? 'https://via.placeholder.com/150';

            $musica = Musica::create( $input );

            $response = new ApiMessage( false, 'Música salva com sucesso!', $musica );
            return response()->json( $response->getResponse() );

        } catch ( \Throwable $th ) {
            $response = new ApiMessage( true, 'Erro ao salvar música!', $th->getMessage() );
            return response()->json( $response->getResponse() );
        }
    }

    public function musicas( Request $request, $id = null ) {
        try {

            if ( isset( $id ) ) {
                $musica = Musica::find( $id );
                if ( !$musica ) {
                    $response = new ApiMessage( true, 'Música não encontrada!', null );
                    return response()->json( $response->getResponse() );
                }

                $response = new ApiMessage( false, 'Música encontrada!', $musica );
                return response()->json( $response->getResponse() );

            }

            $perPage = $request->input( 'per_page', 6 );
            $musicas = Musica::where( 'status', 'ativo' )
            ->orderBy( 'ordem' )
            ->paginate( $perPage );

            // if ( $musicas->isEmpty() ) {
            //     $response = new ApiMessage( true, 'Nenhuma música encontrada!', null );
            //     return response()->json( $response->getResponse(), 404 );
            // }
            $result = MusicasResource::collection( $musicas->items() );

            $responseData = [
                'data' => $result,
                'pagination' => [
                    'current_page' => $musicas->currentPage(),
                    'last_page' => $musicas->lastPage(),
                    'per_page' => $musicas->perPage(),
                    'total' => $musicas->total(),
                ],
            ];

            $response = new ApiMessage( false, 'Músicas encontradas!', $responseData );

            return response()->json( $response->getResponse() );

        } catch ( \Throwable $th ) {
            $response = new ApiMessage( true, 'Erro ao buscar músicas!', $th->getMessage() );
            return response()->json( $response->getResponse() );
        }
    }

    public function getYouTubeVideoInfo( $url ) {

        try {
            if ( strpos( $url, '?v=' ) !== false ) {
                $videoId = explode( '?v=', $url )[ 1 ];
            } else {

                $videoId = explode( '/', $url )[ 3 ];
            }

            $ch = curl_init();
            curl_setopt( $ch, CURLOPT_URL, $url );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
            $response = curl_exec( $ch );
            curl_close( $ch );

            if ( preg_match( '/<meta name="title" content="(.*?)">/', $response, $matches ) ) {
                $title = $matches[ 1 ];
            } else {
                $title = 'Título não encontrado.';
            }

            if ( preg_match( '/<meta name="description" content="(.*?)">/', $response, $matches ) ) {
                $description = $matches[ 1 ];
            } else {
                $description = 'Descrição não encontrada.';
            }

            $thumbnail = "https://img.youtube.com/vi/$videoId/hqdefault.jpg";

            return [
                'title' => $title,
                'description' => $description,
                'thumbnail' => $thumbnail,
            ];

        } catch ( \Throwable $th ) {
            Log::error( 'Erro ao buscar informações do vídeo do YouTube: ' . $th->getMessage() );
            return null;
        }
    }

    public function atualiza( Request $request, $id ) {
        try {
            $input = $request->all();
            $musica = Musica::find( $id );
            $musica->update( $input );
            $response = new ApiMessage( false, 'Música atualizada com sucesso!', $musica );
            return response()->json( $response->getResponse() );

        } catch ( \Throwable $th ) {
            $response = new ApiMessage( true, 'Erro ao atualizar música!', $th->getMessage() );
            return response()->json( $response->getResponse() );
        }
    }

    public function deleta( $id ) {
        try {
            $musica = Musica::find( $id );
            $musica->update( [ 'status' => 'inativo' ] );
            $response = new ApiMessage( false, 'Música deletada com sucesso!', $musica );

            return response()->json( $response->getResponse() );
        } catch ( \Throwable $th ) {
            $response = new ApiMessage( true, 'Erro ao deletar música!', $th->getMessage() );
            return response()->json( $response->getResponse() );
        }
    }

    public function reordenarMusicas( Request $request ) {
        try {
            $musicas = $request->input('musicas');

            if (empty($musicas) || !is_array($musicas)) {
                return response()->json([
                    'error' => true,
                    'message' => 'Array de músicas inválido.',
                ], 400);
            }

            foreach ($musicas as $index => $id) {
                Musica::where('id', $id)->update(['ordem' => $index + 1]);
            }

            $response = new ApiMessage( false, 'Músicas reordenadas com sucesso!', null );
            return response()->json( $response->getResponse() );

        } catch ( \Throwable $th ) {
            $response = new ApiMessage( true, 'Erro ao ordenar música!s', $th->getMessage() );
            return response()->json( $response->getResponse(), 500 );
        }
    }

}
