<?php

namespace App\Http\Controllers;

use App\Http\Resources\PokemonCollection;
use App\Services\PokemonApiWrapper;
use Illuminate\Http\Request;

class PokemonController extends Controller
{
    protected $pokemonApiWrapper;

    public function __construct(PokemonApiWrapper $pokemonApiWrapper)
    {
        $this->pokemonApiWrapper = $pokemonApiWrapper;
    }

    /**
     * @OA\Get(
     *      path="/api/pokemons",
     *      operationId="getPaginatadPokemons",
     *      tags={"Tests"},

     *      summary="Get List Of Pokemons",
     *      description="Returns pokemons with pagination",
     *      @OA\Parameter(
     *          name="offset",
     *          in="query",
     *          required=false,
     *          @OA\Schema(
     *           type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="limit",
     *          in="query",
     *          required=false,
     *          @OA\Schema(
     *           type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      )
     * )
     */
    public function index(Request $request)
    {
        try {
            $apiResults = $this->pokemonApiWrapper->index($request);
            $result = new PokemonCollection($apiResults);

            if ('xml' === $request->getContentType()) {
                return response()->xml($result->toArray($request));
            }

            return $result;
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
