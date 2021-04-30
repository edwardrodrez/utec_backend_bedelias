<?php

namespace App\Http\Controllers;

use App\Models\tiposdecurso;
use Illuminate\Http\Request;

class TiposDeCursosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tiposdecurso = tiposdecurso::all();
        if($tiposdecurso != null){
        return response()->json($tiposdecurso, 200);
        }
        else
        return response()->json("No hay tipos de curso creados",400);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $tiposdecurso = new tiposdecurso;
        $tiposdecurso->nombre = $request->nombre;
        $tiposdecurso->save();
        $tiposdecurso->refresh();
        return response()->json($tiposdecurso);
    }

    public function getTipoDeCurso($id)
    {
        $tiposdecurso = tiposdecurso::find($id);
        if($tiposdecurso != null)
        {
            return response()->json($tiposdecurso, 200);
        }

        return response()->json("Tipo de curso no encontrado",400);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        $tiposdecurso = tiposdecurso::find($id);
        if($tiposdecurso != null){
        $tiposdecurso->nombre = $request->nombre;
        $tiposdecurso->save();
        return response()->json($tiposdecurso);
        }
        else
        return response()->json("Tipo de curso no encontrado",400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $tiposdecurso =  tiposdecurso::find($id);
        if($tiposdecurso != null){
         $tiposdecurso->delete();
         return response()->json("Tipo de curso eliminado correctamente",200);
        }
        else
        return response()->json("Tipo de curso no encontrada",400);
    }

}
