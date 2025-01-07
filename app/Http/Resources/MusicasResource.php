<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MusicasResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $youtubeId = explode( '/', $this->link );
        $youtubeId = explode( '=', $youtubeId[ count( $youtubeId ) - 1 ] );
        $youtubeId = $youtubeId[0];

        $thumb = 'https://img.youtube.com/vi/'.$youtubeId.'/hqdefault.jpg';

        return [
            'id' => $this->id,
            'titulo' => $this->nome ?? null,
            'visualizacoes' => $this->visualizacoes ?? null,
            'youtube_id' => $youtubeId,
            'thumb' => $thumb
        ];
    }
}
