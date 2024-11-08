<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;

class MovieController extends Controller
{
    public function index(Request $request){
        $movies = Movie::all();
        return response()->json($movies);

    }
    public function create(Request $request)
    {

        $movie = Movie::create([
       'title'=> $request->title,
       'synopsis'=> $request->synopsis,
       'year'=> $request->year,
       'cover'=> $request->cover,
        ]);

        return response()->json([
            'message'=> 'Pelicula agregada',
            'movie' => $movie,
        ]);
    }
    public function detail(Request $request, $id){
        $movie = Movie::findOrFail($id);        
        return response()->json($movie);
    }

    public function update(Request $request, $id)
    {
        $movie = Movie::findOrFail($id);

        $movie->update([
            'title'=> $request->title,
            'synopsis'=> $request->synopsis,
            'year'=> $request->year,
            'cover'=> $request->cover,
        ]);

        return response()->json([
            'message'=> 'Pelicula actualizada',
            'movie' => $movie,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $movie = Movie::findOrFail($id);

        $movie->delete();

        return response()->json([
            'message'=> 'Pelicula eliminada',
        ]);
    }
}
