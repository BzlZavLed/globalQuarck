<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Encuesta;
use App\Models\Pregunta;
use App\Models\Opciones;
use Illuminate\Support\Facades\DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $encuestas = Encuesta::all();
        $preguntas = Pregunta::all();
        return view('home',['encuestas' => $encuestas,
                            'preguntas' => $preguntas]);
    }
    /**
     * Crear encuesta 
     */
    public function crearEncuesta(Request $request){
        $request->validate([
            'nombre_encuesta' => 'required'
        ]);
        Encuesta::updateOrCreate(['nombre_encuesta' => $request->nombre_encuesta],
            [
                'nombre_encuesta' => $request->nombre_encuesta
            ]);
        return redirect()->back()->with('message', 'Encuesta guardada!');
    }
    /**
     * Crear pregunta para encuesta
     */
    public function crearPregunta(Request $request){
        $request->validate([
            'nombre_pregunta' => 'required',
            'id_encuesta' => 'required'
        ]);
        Pregunta::updateOrCreate(['nombre_pregunta' => $request->nombre_pregunta],
            [
                'nombre_pregunta' => $request->nombre_pregunta,
                'id_encuesta' => $request->id_encuesta
            ]);
        return redirect()->back()->with('message', 'Pregunta guardada!');  
    }
    /**
     * Crear opciones para preguntas
     */
    public function crearOpcion(Request $request){
        //dd($request);
        $request->validate([
            'nombre_opcion' => 'required',
            'id_pregunta' => 'required'
        ]);
        Opciones::updateOrCreate(['nombre_opcion' => $request->nombre_opcion],
            [
                'nombre_opcion' => $request->nombre_opcion,
                'id_pregunta' => $request->id_pregunta
            ]);
        return redirect()->back()->with('message', 'Opcion guardada!');
    }
    /**
     * Ver encuestas con preguntas
     */
    public function verEncuestas($id_encuesta){
        $query = "SELECT e.nombre_encuesta,p.nombre_pregunta,o.nombre_opcion 
        FROM globalquarck.encuestas e
        INNER JOIN globalquarck.preguntas p ON p.id_encuesta = e.id
        INNER JOIN globalquarck.opciones o ON o.id_pregunta = p.id
        WHERE e.id = $id_encuesta;";
        $encuestas = DB::select($query);
        
        return response()->json($encuestas);
        
    } 
}
