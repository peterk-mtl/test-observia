<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Client\Pool;
use Illuminate\Http\Request;

class PokemonApiWrapper
{
    const BASE_URL = 'https://pokeapi.co/api/v2/pokemon/';

    public function index(Request $request)
    {
        $response = Http::get(self::BASE_URL . '?' . http_build_query($request->query()));

        if (404 === $response->status()) {
            throw new NotFoundHttpException('Route does not exists.');
        }

        $jsonResponse = $response->json();
        $pokemons = $response->json()['results'];

        // load details about pokemons
        $pokemonsDetails = Http::pool(function (Pool $pool) use ($pokemons) {
            $poolArray = [];

            foreach ($pokemons as $pokemon) {
                $poolArray[] = $pool->get($pokemon['url']);
            }
            return $poolArray;
        });

        $jsonResponse['results'] = $pokemonsDetails;

        return $jsonResponse;

    }
}
