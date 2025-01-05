<?php

namespace App\Http\Controllers\Control;

use App\Http\Resources\Control\ConfigResource;
use App\Models\Config;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Brediweb\ImagemUpload\ImagemUpload;

class ConfigController extends Controller
{
    public function index()
    {
        $config = Config::first();

        return apiResponse(false, [], new ConfigResource($config));
    }

    public function update(Request $request)
    {
        $input = $request->except('_token');

        $background_image = ImagemUpload::salva([
            'input_file' => 'background_image',
            'destino' => 'background_image/',
            'resolucao' => ['h' => 1280, 'w' => 1280]
        ]);

        if ($background_image) {
            $input['config']['layout']['background_image'] = $background_image;
        }

        $logo = ImagemUpload::salva([
            'input_file' => 'logo',
            'destino' => 'company/',
            'resolucao' => ['g' => ['h' => 30, 'w' => 100], 'p' => ['h' => 200, 'w' => 200]]
        ]);

        if ($logo) {
            $input['config']['layout']['logo'] = $logo;
        }

        $config = Config::first();

        if (isset($config->id)) {
            $input = $this->atualizaRegistro($config, $input);

            $config->update($input);
        } else {
            Config::create($input);
        }

        return apiResponse(false, ['Configurações atualizadas com sucesso']);
    }

    function atualizaRegistro($config, $input)
    {
        if (isset($input['config'])) {
            $input['config']['layout'] = (!empty($config->config['layout'])) ? array_merge($config->config['layout'], $input['config']['layout']) : $input['config']['layout'];
        }

        return $input;
    }
    
    public function uploadEditor(Request $request)
    {
        $imagem = ImagemUpload::salva(['input_file' => 'file', 'destino' => 'upload']);

        return route('imagem.render', 'upload/' . $imagem);
    }

    public function deleteImageEditor(Request $request)
    {
        $nomeImagem = explode("/", $request->get('image'));
        $deleteImagem = ImagemUpload::deleta(['imagem' => end($nomeImagem), 'destino' => 'upload']);

        return response(['status' => $deleteImagem]);
    }
}
