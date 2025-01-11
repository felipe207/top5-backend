<?php

namespace Database\Factories;

use App\Models\Musica;
use Illuminate\Database\Eloquent\Factories\Factory;

class MusicaFactory extends Factory
{
    protected $model = Musica::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->sentence(3), // Gera um título de três palavras
            'autor' => $this->faker->name(), // Gera um nome de autor fictício
            'ano' => $this->faker->year(), // Gera um ano aleatório
            'estilo' => $this->faker->word(), // Gera uma palavra aleatória para o estilo
            'visualizacoes' => $this->faker->numberBetween(0, 10000), // Gera um número aleatório de visualizações
            'link' => $this->faker->url(), // Gera um URL fictício
            'status' => $this->faker->randomElement(['ativo', 'inativo']), // Gera o status como 'ativo' ou 'inativo'
            'description' => $this->faker->paragraph(), // Gera um parágrafo de descrição
            'thumbnail' => $this->faker->imageUrl(), // Gera um URL de imagem
            'ordem' => $this->faker->numberBetween(1, 100), // Gera um número aleatório para a ordem
        ];
    }
}
