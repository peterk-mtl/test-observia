<?php

namespace App\Http\Resources;

use App\Services\PokemonApiWrapper;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class PokemonCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //format pokemon details
        $pokemons = new Collection();

        foreach ($this->collection['results'] as $pokemonResponse) {
            $pokemonResponse = $pokemonResponse->json();

            $pokemons->add([
               'name' => $pokemonResponse['name'],
               'height' => $pokemonResponse['height'],
               'weight' => $pokemonResponse['weight'],
               'types' => $pokemonResponse['types'],
               'image' => 'data:image/png;base64,' . base64_encode(file_get_contents($pokemonResponse['sprites']['front_default'])),
            ]);
        }

        return [
            'count' => $this->collection['count'],
            'next' => str_replace(PokemonApiWrapper::BASE_URL, url()->current(), $this->collection['next']),
            'previous' => str_replace(PokemonApiWrapper::BASE_URL, url()->current(), $this->collection['previous']),
            'pokemons' => $pokemons
        ];
    }
}
