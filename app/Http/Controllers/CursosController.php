<?php

namespace App\Http\Controllers;

use App\Models\carrera;
use App\Models\curso;
use App\Models\previa;
use App\Models\tiposdecurso;
use Illuminate\Http\Request;

class CursosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $curso = curso::all();
        if($curso != null){
        return response()->json($curso, 200);
        }
        else
        return response()->json("No hay cursos creados",400);
    }

    public function getCursoSinArea()
    {
        $curso = curso::all();
        if($curso != null){
            $pila = array();
            foreach($curso as $cu){
                if($cu->areaDeEstudio == null){
                    array_push($pila, $cu);
                }
            }
            return response()->json($pila, 200);
        }
        else
        return response()->json("No hay cursos creados",400);
    }


    public function getCarreras($id)
    {
        $curso = curso::find($id);
        if($curso != null){
        return response()->json($curso->carreras, 200);
        }
        else
        return response()->json("Curso no encontrado",400);
    }

    public function getPrevias(Request $request)
    {
        $curso = curso::find($request->idcurso);
        if($curso != null){
        $previas = curso::find($request->idcurso)->previas;
        $pila = array();
        foreach($previas as $p){
            if($p->idcarrera == $request->idcarrera){
                array_push($pila, $p);
            }
        }

        return response()->json($pila, 200);
        }
        else
        return response()->json("Curso no encontrado",400);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $curso = new curso();
        $curso->credito = $request->credito;
        $curso->nombre = $request->nombre;
        $tipo= $request->tiposdecurso;
        $tiposdecurso =  tiposdecurso::find($request->input('tiposdecurso.idtiposDeCurso'));

            if($tiposdecurso != null){

                $curso->tipoDeCurso()->associate($tiposdecurso);
                $curso->save();
                $curso->refresh();
                return response()->json($curso);
                }
            else{
                return response()->json("Tipo de curso no encontrado",400);
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
        $curso =  curso::find($id);
        if($curso != null){
        $curso->credito = $request->credito;
        $curso->nombre = $request->nombre;
        $tipo= $request->tiposdecurso;
        $tiposdecurso =  tiposdecurso::find($request->input('tiposdecurso.idtiposDeCurso'));

            if($tiposdecurso != null){

                $curso->tipoDeCurso()->associate($tiposdecurso);
                $curso->save();
                $curso->refresh();
                return response()->json($curso);
                }
            }
            else
            return response()->json("Curso no encontrado",400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $curso =  curso::find($id);
        if($curso != null){
            $aux = false;
            foreach($curso->periodos as $a){
                $aux = true;
            }
            if($aux){
                return response()->json("La carrera no puede ser borrada ya que tiene periodos",400);
            }
            $curso->tipoDeCurso()->dissociate();
            $curso->areaDeEstudio()->dissociate();
            curso::find($id)->carreras()->detach();
            previa::where('idcursoprevio', '=',$curso->idcurso)->delete();
            $curso->previas()->delete();
            $curso->delete();
        }
        else
        return response()->json("Curso no encontrado",400);
    }

    public function addprevia(Request $request)
    {
        $curso =  curso::find($request->idcurso);
        if($curso != null){
            $cursoprevio =  curso::find($request->idcursoprevio);
            if($cursoprevio != null){

                foreach($curso->previas as $car){
                    if($car != null){
                        $previa =  previa::find($car->idprevia);
                        foreach($curso->previas as $car){
                            if( $previa->idcursoprevio == $request->idcursoprevio){
                                if($previa->idcarrera == $request->idcarrera){
                                    return response()->json("La previa ya pertenece a este curso",400);
                                }

                    }}}}


                $previa = new previa();
                $previa->tipoPrevia = $request->tipoPrevia;
                $previa->save();
                $carrera = carrera::find($request->idcarrera);
                $previa->carrera()->associate($carrera);
                $previa->curso()->associate($cursoprevio);
                $curso->previas()->save($previa);


                $curso->refresh();
                return response()->json($curso);
                }
                else{
                return response()->json("Previa no encontrada",400);
                }
        }
        else
        return response()->json("Curso no encontrado",400);
    }

    public function quitprevia(Request $request)
    {
        $curso =  curso::find($request->idcurso);
        if($curso != null){
            $previa =  previa::find($request->idprevia);
            if($previa != null){
                $curso->previas()->where('idprevia', '=' ,$request->idprevia)->delete();
                $curso->save();
                $curso->refresh();
                return response()->json($curso);
                }
                else{
                return response()->json("Previa no encontrada",400);
                }
        }
        else
        return response()->json("Curso no encontrado",400);
    }

}
