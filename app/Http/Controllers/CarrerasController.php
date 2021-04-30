<?php

namespace App\Http\Controllers;

use App\Models\carrera;
use App\Models\curso;
use App\Models\periodo;
use App\Models\Usuario;
use App\Models\areaDeEstudio;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\carreraarea;

class CarrerasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carrera = carrera::all();
        if($carrera != null){
        return response()->json($carrera, 200);
        }
        else
        return response()->json("No hay sedes creadas",400);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $carrera = new carrera;
        $carrera->nombre = $request->nombre;
        $carrera->creditoMinimo = $request->creditoMinimo;
        $carrera->save();
        $carrera->refresh();
        return response()->json($carrera);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getCarrera($id)
    {
        $carrera = carrera::find($id);
        if($carrera)
        {
            return response()->json($carrera, 200);
        }

        return response()->json("Carrera no encontrada",400);

    }

    public function getCarrerasUs($id)
    {
        $usuario = Usuario::find($id);
        if($usuario)
        {
            return response()->json($usuario->carrera, 200);
        }

        return response()->json("Usuario no encontrado",400);
    }

    public function getSedes($id)
    {
        $carrera = carrera::find($id);
        if($carrera != null)
        {
            return response()->json($carrera->sedes, 200);
        }

        return response()->json("Carrera no encontrada",400);

    }

    public function getLectivos($id)
    {
        $carrera = carrera::find($id)->with('cursos')->get();
        if($carrera != null)
        {
        $cursos = $carrera->cursos;
        $pila = array();
        foreach($cursos as $c){
            $curso = curso::find($id)->with('periodos')->get();
            if($curso != null)
                {
                    foreach($curso->periodos as $per){
                        $periodo = periodo::find($per->idperiodo);
                        if($periodo->tipo == 'lectivo'){
                        $fe = $periodo->fechainscripcion;
                        $hoy = Carbon::today();
                        if($fe != null ){
                            $fecha = Carbon::parse($fe->fechaFinal);
                            if($hoy <= $fecha){
                                array_push($pila, $periodo);
                            }

                        }
                        }

                    }

                }
        }

        return response()->json($pila, 200);
        }
        else
        return response()->json("Carrera no encontrada",400);

    }

    public function getExsamenes($id)
    {
        $carrera = carrera::find($id)->with('cursos')->get();
        if($carrera != null)
        {
        $cursos = $carrera->cursos;
        $pila = array();
        foreach($cursos as $c){
            $curso = curso::find($id)->with('periodos')->get();
            if($curso != null)
                {
                    foreach($curso->periodos as $per){
                        $periodo = periodo::find($per->idperiodo);
                        if($periodo->tipo == 'examen'){
                        $fe = $periodo->fechainscripcion;
                        $hoy = Carbon::today();
                        if($fe != null ){
                            $fecha = Carbon::parse($fe->fechaFinal);
                            if($hoy <= $fecha){
                                array_push($pila, $periodo);
                            }

                        }
                        }

                    }

                }
        }

        return response()->json($pila, 200);
        }
        else
        return response()->json("Carrera no encontrada",400);

    }

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
        $carrera =  carrera::find($id);
        if($carrera != null){
        $carrera->nombre = $request->nombre;
        $carrera->creditoMinimo = $request->creditoMinimo;
        $carrera->save();
        $carrera->refresh();
        return response()->json($carrera);

        }
        else
        return response()->json("Carrera no encontrada",400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $carrera =  carrera::find($id);
        if($carrera != null){
            $aux = false;
            foreach($carrera->usuarios as $a){
                $aux = true;
            }
            if($aux){
                return response()->json("La carrera no puede ser borrada ya que tiene estudiantes",400);
            }
            carrera::find($id)->sedes()->detach();
            carreraarea::where('idcarrera', '=',$carrera->idcarrera)->delete();
            carrera::find($id)->cursos()->detach();
            $carrera->periodoDeIncripciones()->delete();
            $carrera->delete();
         return response()->json("Carrera eliminada correctamente",200);
        }
        else
        return response()->json("Carrera no encontrada",400);
    }

    public function addcurso(Request $request)
    {
        $carrera =  carrera::find($request->idcarrera);
        if($carrera != null){
            $curso =  curso::find($request->idcurso);
            if($curso != null){

                foreach($carrera->cursos as $car){
                    if($car != null){
                            if( $car->idcurso == $request->idcurso){
                                return response()->json("El curso ya pertenece a esta carrera",400);
                    }}}

                $carrera->cursos()->save($curso);
                if($curso->areaDeEstudio != null){
                    $a = $curso->areaDeEstudio;
                    $area = areaDeEstudio::find($a->idareadeestudio);

                    if ($area->carreraArea()->where('idcarrera', '=',$request->idcarrera)->where('idareadeestudio', '=',$a->idareadeestudio)->first() == null)
                    {
                    $carreraarea = new carreraarea();
                    $carreraarea->creditoMinimo = 0;
                    $carreraarea->save();
                    $carreraarea->carrera()->associate($carrera);
                    $area->carreraArea()->save($carreraarea);
                    }

                }

                $carrera->refresh();
                return response()->json($carrera,200);
                }
                else{
                return response()->json("Sede no encontrada",400);
                }

        return response()->json($carrera,200);
        }
        else
        return response()->json("Carrera no encontrada",400);
    }

    public function quitcurso(Request $request)
    {
        $carrera =  carrera::find($request->idcarrera);
        if($carrera != null){
            $curso =  curso::find($request->idcurso);
            if($curso != null){
                if($curso->areaDeEstudio != null){
                    $a = $curso->areaDeEstudio;
                    $area = areaDeEstudio::find($a->idareadeestudio);
                    $area->carreraArea()->where('idcarrera', '=',$request->idcarrera)->delete();
                }
                $carrera->cursos()->detach($curso);
                return response()->json($carrera,200);
                }
                else{
                return response()->json("Sede no encontrada",400);
                }

        return response()->json($carrera,200);
        }
        else
        return response()->json("Carrera no encontrada",400);
    }


}
