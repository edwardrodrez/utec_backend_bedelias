<?php

namespace App\Http\Controllers;

use App\Models\areaDeEstudio;
use App\Models\carrera;
use App\Models\carreraarea;
use App\Models\curso;
use Illuminate\Http\Request;

class AreasDeEstudioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $areaDeEstudio = areaDeEstudio::all();
        if($areaDeEstudio != null){
        return response()->json($areaDeEstudio, 200);
        }
        else
        return response()->json("No hay áreas de estudio creadas",400);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $areaDeEstudio = new areaDeEstudio;
        $areaDeEstudio->nombre = $request->nombre;
        $areaDeEstudio->save();
        $areaDeEstudio->refresh();
        return response()->json($areaDeEstudio);
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
    public function getAreasDeEstudio($id)
    {
        $areaDeEstudio = areaDeEstudio::find($id);
        if($areaDeEstudio)
        {
            return response()->json($areaDeEstudio, 200);
        }

        return response()->json("Área de estudio no encontrada",400);
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
        $areaDeEstudio = areaDeEstudio::find($id);
        if($areaDeEstudio != null){
        $areaDeEstudio->nombre = $request->nombre;
        $areaDeEstudio->save();
        return response()->json($areaDeEstudio);
        }
        else
        return response()->json("Área de estudio no encontrada",400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $areaDeEstudio =  areaDeEstudio::find($id);
        if($areaDeEstudio != null){
         $areaDeEstudio->carreraArea()->delete();
         $areaDeEstudio->cursos()->update(['idareadeestudio' => null]);
         $areaDeEstudio->delete();
         return response()->json("Área de estudio eliminada correctamente",200);
        }
        else
        return response()->json("Área de estudio no encontrada",400);
    }

    public function addcurso(Request $request)
    {
        $areaDeEstudio =  areaDeEstudio::find($request->idareaDeEstudio);
        if($areaDeEstudio != null){
            $curso =  curso::find($request->idcurso);
            if($curso != null){

                foreach($areaDeEstudio->cursos as $car){
                    if($car != null){
                            if( $car->idcurso == $request->idcurso){
                                return response()->json("El curso ya pertenece a esta área de estudio",400);
                    }}}

                    foreach($curso->carreras as $car){
                        $cont = 0;
                        $carrera =  carrera::find($car->idcarrera);
                        foreach($areaDeEstudio->carreraArea as $carar){
                            $carreraArea2 =  carreraArea::find($carar->idcarreraarea);
                            if ($carreraArea2->carrera->idcarrera == $carrera->idcarrera){
                                $cont = $cont +1;
                            }
                        }
                        if($cont == 0){
                            $carreraarea = new carreraarea();
                            $carreraarea->creditoMinimo = 0;
                            $carreraarea->save();
                            $carrera =  carrera::find($car->idcarrera);
                            $carreraarea->carrera()->associate($carrera);
                            $areaDeEstudio->carreraArea()->save($carreraarea);
                        }
                    }


                $areaDeEstudio->cursos()->save($curso);
                $areaDeEstudio->refresh();
                return response()->json($areaDeEstudio);
                }
                else{
                return response()->json("Curso no encontrado",400);
                }
        $areaDeEstudio->refresh();
        return response()->json($areaDeEstudio);
        }
        else
        return response()->json("Área no encontrada",400);
    }

    public function quitcurso(Request $request)
    {
        $areaDeEstudio =  areaDeEstudio::find($request->idareaDeEstudio);
        if($areaDeEstudio != null){
            $curso =  curso::find($request->idcurso);
            if($curso != null){

                $areaDeEstudio->cursos()->where('idcurso', '=' ,$request->idcurso)->update(['idareadeestudio' => null]);
                $areaDeEstudio->refresh();
                foreach($curso->carreras as $car){
                    $cont = 0;
                    $carrera =  carrera::find($car->idcarrera);
                    foreach($areaDeEstudio->cursos as $carar){
                        $curso2 =  curso::find($carar->idcurso);
                        foreach($curso2->carreras as $car2){
                                if ($car2->idcarrera == $carrera->idcarrera){
                                    $cont = $cont +1;
                                }
                        }
                    }
                    if($cont == 0){
                        $areaDeEstudio->carreraArea()->where('idcarrera', '=',$car->idcarrera)->delete();
                    }
                }

                $areaDeEstudio->refresh();
                return response()->json($areaDeEstudio);
                }
                else{
                return response()->json("Curso no encontrado",400);
                }
        $areaDeEstudio->refresh();
        return response()->json($areaDeEstudio);
        }
        else
        return response()->json("Área no encontrada",400);
    }

    public function addCredito(Request $request)
    {
        $carreraarea =  carreraarea::find($request->idcarreraarea);
        if($carreraarea != null){
            $carreraarea->creditoMinimo = $request->creditoMinimo;
            $carreraarea->save();
            $carreraarea->refresh();
            return response()->json($carreraarea,200);
        }
        else
        return response()->json("Carrera area  no encontrada",400);
    }

}

