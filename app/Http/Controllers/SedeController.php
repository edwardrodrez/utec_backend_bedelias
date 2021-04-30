<?php

namespace App\Http\Controllers;

use App\Models\carrera;
use App\Models\direccion;
use App\Models\sede;
use Illuminate\Http\Request;

class SedeController extends Controller
{

    public function __construct()
    {

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sede = sede::all();
        if($sede != null){
        return response()->json($sede, 200);
        }
        else
        return response()->json("No hay sedes creadas",400);

    }

    /**
     * Show the form for creating a new resource.

     * @return \Illuminate\Http\Response
     */

    public function create(Request $request)
    {
        $sede = new sede;
        $sede->nombre = $request->nombre;
        $dire = new direccion($request->direccion);
        $sede->save();
        $sede->direccion()->save($dire);
        $sede->refresh();
        return response()->json($sede);
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

    public function getSede($id)
    {
        $sede = sede::find($id);
        if($sede)
        {
            return response()->json($sede, 200);
        }

        return response()->json("Sede no encontrada",400);

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
        $sede =  sede::find($id);
        if($sede != null){
        $sede->nombre = $request->nombre;
        $dire2 = new direccion($request->direccion);
        $dire = direccion::find($sede->direccion->iddireccion);
        $dire->departamento = $dire2->departamento;
        $dire->ciudad = $dire2->ciudad;
        $dire->calle = $dire2->calle;
        $dire->push();
        $sede->push();
        $sede->refresh();
        return response()->json($sede);

        }
        else
        return response()->json("Sede no encontrada",400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $sede =  sede::find($id);

        if($sede != null){
            if(sede::find($id)->periodos != null){
                return response()->json("No se pudo eliminar la sede por que ya tiene periodos",400);
            }
            sede::find($id)->carreras()->detach();
            $sede->direccion()->delete();
            $sede->delete();
         return response()->json("Sede eliminada correctamente",200);
        }
        else
        return response()->json("Sede no encontrada",400);
    }

    public function addcarrera(Request $request)
    {
        $sede =  sede::find($request->idsede);
        if($sede != null){
            $carrera =  carrera::find($request->idcarrera);
            if($carrera != null){

                foreach($sede->carreras as $car){
                    if($car != null){
                            if( $car->idcarrera == $request->idcarrera){
                                return response()->json("La carrera ya pertenece a esta sede",400);
                    }}}
                $sede->carreras()->save($carrera);
                $sede->refresh();
                return response()->json($sede);
                }
                else{
                return response()->json("Carrera no encontrada",400);
                }

        return response()->json($sede);
        }
        else
        return response()->json("Sede no encontrada",400);
    }

    public function quitcarrera(Request $request)
    {
        $sede =  sede::find($request->idsede);
        if($sede != null){
            $carrera =  carrera::find($request->idcarrera);
            if($carrera != null){

                $sede->carreras()->detach($carrera);
                return response()->json($sede);
                }
                else{
                return response()->json("Carrera no encontrada",400);
                }

        return response()->json($sede);
        }
        else
        return response()->json("Sede no encontrada",400);
    }

}


