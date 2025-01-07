<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Musica extends Model
{
    protected $table = 'musicas';

    use SoftDeletes;
    protected $fillable = [
        'nome', 'autor', 'ano', 'estilo',
        'visualizacoes', 'link', 'status'
    ];

}
