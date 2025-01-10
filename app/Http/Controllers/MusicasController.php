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
            if ( !isset( $input['status'] ) ) $input['status'] = 'ativo';
            if ( !isset( $input['visualizacoes'] ) ) $input['visualizacoes'] = 0;
            if ( !isset( $input['ano'] ) ) $input['ano'] = date( 'Y' );
            if ( !isset( $input['autor'] ) ) $input['autor'] = 'Autor Desconhecido';

            $dadosVideo = $this->getYouTubeVideoInfo( $input['link'] );
            $input['nome'] = $dadosVideo['title'] ?? 'Música sem título';
            $input['description'] = $dadosVideo['description'] ?? 'Música sem descrição';
            $input['thumbnail'] = $dadosVideo['thumbnail'] ?? 'https://via.placeholder.com/150';

            $musica = Musica::create( $input );

            $response = new ApiMessage( false, 'Música salva com sucesso!', $musica );
            return response()->json( $response->getResponse() );

        } catch ( \Throwable $th ) {
            $response = new ApiMessage( true, 'Erro ao salvar música!', $th->getMessage() );
            return response()->json( $response->getResponse() );
        }
    }

    public function musicas( Request $request , $id = null)
    {
        try {

            if (isset($id)){
                $musica = Musica::find($id);
                if (!$musica) {
                    $response = new ApiMessage( true, 'Música não encontrada!', null );
                    return response()->json( $response->getResponse() );
                }

                $response = new ApiMessage( false, 'Música encontrada!', $musica );
                return response()->json( $response->getResponse() );

            }
            $musicas = Musica::where( 'status', 'ativo' )->orderBy('ordem')->get();
            $result = [];
            $result = MusicasResource::collection( $musicas );
            $response = new ApiMessage( false, 'Músicas encontradas!', $result );

            return response()->json( $response->getResponse() );

        } catch ( \Throwable $th ) {
            $response = new ApiMessage( true, 'Erro ao buscar músicas!', $th->getMessage() );
            return response()->json( $response->getResponse() );
        }
    }

    public function getYouTubeVideoInfo($url) {

        try {
        if (strpos($url, '?v=') !== false) {
            $videoId = explode('?v=', $url)[1];
        } else {

        $videoId = explode('/', $url)[3];
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $response = curl_exec($ch);
        curl_close($ch);

        if (preg_match('/<meta name="title" content="(.*?)">/', $response, $matches)) {
            $title = $matches[1];
        } else {
            $title = "Título não encontrado.";
        }

        if (preg_match('/<meta name="description" content="(.*?)">/', $response, $matches)) {
            $description = $matches[1];
        } else {
            $description = "Descrição não encontrada.";
        }

        $thumbnail = "https://img.youtube.com/vi/$videoId/hqdefault.jpg";

        return [
            'title' => $title,
            'description' => $description,
            'thumbnail' => $thumbnail,
        ];


        } catch (\Throwable $th) {
            // dd($th);
            Log::error('Erro ao buscar informações do vídeo do YouTube: ' . $th->getMessage());
            return null;
        }
    }

    public function atualiza( Request $request, $id ) {
        try {
            $input = $request->all();

            // Log::info(json_encode($input));
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

    public function ordena( Request $request ) {
        try {
            $input = $request->all();
            $musicas = Musica::where( 'status', 'ativo' )->get();

            foreach ( $musicas as $musica ) {
                $ordem = array_search( $musica->id, $input['musicas'] );
                $musica->update( [ 'ordem' => $ordem ] );
            }

            $response = new ApiMessage( false, 'Músicas ordenadas com sucesso!', $musicas );
            return response()->json( $response->getResponse() );

        } catch ( \Throwable $th ) {
            $response = new ApiMessage( true, 'Erro ao ordenar músicas!', $th->getMessage() );
            return response()->json( $response->getResponse() );
        }
    }


}
