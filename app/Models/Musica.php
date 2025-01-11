<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Musica extends Model
{
    protected $table = 'musicas';

    use SoftDeletes;
    use HasFactory;
    protected $fillable = [
        'nome', 'autor', 'ano', 'estilo',
        'visualizacoes', 'link', 'status',
        'description', 'thumbnail', 'ordem'
    ];

}
