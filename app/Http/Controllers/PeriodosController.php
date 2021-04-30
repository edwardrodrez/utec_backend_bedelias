<?php

namespace App\Http\Controllers;

use App\Models\acta;
use App\Models\asistencia;
use App\Models\carrera;
use App\Models\clase;
use App\Models\curso;
use App\Models\DTOasistencia;
use App\Models\fechainscripcion;
use App\Models\periodo;
use App\Models\sede;
use App\Models\Usuario;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;

class PeriodosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getLectivos()
    {
        $periodo = periodo::where('tipo', '=', "lectivo")->get();
        if($periodo != null){
        return response()->json($periodo, 200);
        }
        else
        return response()->json("No hay periodos creados",400);

    }

    public function getExamenes()
    {
        $periodo = periodo::where('tipo', '=', "examen")->get();
        if($periodo != null){
        return response()->json($periodo, 200);
        }
        else
        return response()->json("No hay periodos creados",400);

    }

    public function getLectivosActuales()
    {
        $periodo = periodo::where('tipo', '=', "lectivo")->whereDate('fechaFinal', '>', Carbon::today()->toDateString())->get();
        if($periodo != null){

        return response()->json($periodo, 200);
        }
        else
        return response()->json("No hay periodos creados",400);

    }

    public function getExamenesActuales()
    {
        $periodo = periodo::where('tipo', '=', "examen")->whereDate('fechaFinal', '>', Carbon::today()->toDateString())->get();
        if($periodo != null){
        return response()->json($periodo, 200);
        }
        else
        return response()->json("No hay periodos creados",400);

    }

    public function getActas($id){
        $periodo = periodo::find($id);
        if($periodo != null)
        {
            return response()->json($periodo->actas, 200);
        }

        return response()->json("Periodo no encontrado",400);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if($request->tipo == 'lectivo'){
            $periodo = new periodo;
            $periodo->tipo = $request->tipo;
            $periodo->fechaInicial = new DateTime($request->fechaInicial);
            $periodo->fechaFinal = new DateTime($request->fechaFinal);
            $curso = curso::find($request->idcurso);
            $sede = sede::find($request->idsede);
            $periodo->save();
            $periodo->curso()->associate($curso);
            $periodo->sede()->associate($sede);
            $periodo->save();
            $periodo->refresh();
            return response()->json($periodo);
        }
        if($request->tipo == 'examen'){
            $periodo = new periodo;
            $periodo->tipo = $request->tipo;
            $periodo->fechaInicial = new DateTime($request->fechaInicial);
            $periodo->fechaFinal = new DateTime($request->fechaInicial);
            $curso = curso::find($request->idcurso);
            $sede = sede::find($request->idsede);
            $periodo->save();
            $periodo->curso()->associate($curso);
            $periodo->sede()->associate($sede);
            $periodo->save();
            $periodo->refresh();
            return response()->json($periodo);
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
        $periodo = periodo::find($id);
        if($periodo != null){
            if($request->tipo == 'lectivo'){
                $periodo->tipo = $request->tipo;
                $periodo->fechaInicial = new DateTime($request->fechaInicial);
                $periodo->fechaFinal = new DateTime($request->fechaFinal);
                $periodo->curso()->dissociate();
                $periodo->sede()->dissociate();
                $periodo->save();
                $curso = curso::find($request->idcurso);
                $sede = sede::find($request->idsede);
                $periodo->curso()->associate($curso);
                $periodo->sede()->associate($sede);
                $periodo->save();
                $periodo->refresh();
                return response()->json($periodo);
            }
            if($request->tipo == 'examen'){
                $periodo->tipo = $request->tipo;
                $periodo->fechaInicial = new DateTime($request->fechaInicial);
                $periodo->fechaFinal = new DateTime($request->fechaInicial);
                $periodo->curso()->dissociate();
                $periodo->sede()->dissociate();
                $periodo->save();
                $curso = curso::find($request->idcurso);
                $sede = sede::find($request->idsede);
                $periodo->curso()->associate($curso);
                $periodo->sede()->associate($sede);
                $periodo->save();
                $periodo->refresh();
                return response()->json($periodo);
            }
        }
        else
        return response()->json("Periodo no encontrado",400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $periodo =  periodo::find($id);
        if($periodo != null){
            $periodo->docente()->dissociate();
            $periodo->curso()->dissociate();
            $periodo->sede()->dissociate();
            $periodo->clases()->delete();
            $periodo->fechainscripcion()->delete();
            $periodo->actas()->update(['idperiodo' => null]);
            periodo::find($id)->Estudiantes()->detach();
            $periodo->delete();
         return response()->json("Periodo eliminado correctamente",200);
        }
        else
        return response()->json("Periodo no encontrado",400);
    }

    public function addDocente(Request $request)
    {
        $periodo =  periodo::find($request->idperiodo);
        if($periodo != null){
            $Usuario =  Usuario::find($request->idusuario);
            if($Usuario != null){

                    if($periodo->docente != null){
                        $periodo->docente()->dissociate();
                        $periodo->save();
                        $periodo->refresh();
                    }
                $periodo->docente()->associate($Usuario);
                $periodo->save();
                $periodo->refresh();
                return response()->json($periodo);
                }
                else{
                return response()->json("Usuario no encontrado",400);
                }
        }
        else
        return response()->json("Periodo no encontrado",400);
    }

    public function quitDocente(Request $request)
    {
        $periodo =  periodo::find($request->idperiodo);
        if($periodo != null){

                    if($periodo->docente != null){
                        $periodo->docente()->dissociate();
                        $periodo->save();
                        $periodo->refresh();
                        return response()->json($periodo);
                    }
                else{
                return response()->json("El periodo no tiene docente",400);
                }
        }
        else
        return response()->json("Periodo no encontrado",400);
    }

    public function addfechainscripcion(Request $request)
    {
        $periodo =  periodo::find($request->idperiodo);
        if($periodo != null){

                if($periodo->fechainscripcion != null){
                    return response()->json("El periodo ya tiene fecha de inscripción",400);
                }
                else{
                $fechainscripcion = new fechainscripcion;
                $fechainscripcion->fechaInicial = new DateTime($request->fechaInicial);
                $fechainscripcion->fechaFinal = new DateTime($request->fechaFinal);
                $fechainscripcion->save();
                $periodo->fechainscripcion()->save($fechainscripcion);
                $periodo->save();
                $periodo->refresh();
                return response()->json($periodo,200);
                }
        }
        else
        return response()->json("Periodo no encontrado",400);
    }

    public function getLectivosAdmin()
    {
        $periodos = periodo::all();
        if($periodos != null)
        {
        $pila = array();
        foreach($periodos as $per){
            $aux = periodo::find($per->idperiodo);
            if($per != null){
                if($aux->tipo == 'lectivo'){
                    $actas = $aux->actas;
                    foreach($actas as $acta){
                        if($acta->estado == 'calificado' ){
                            array_push($pila, $aux);
                            break;
                        }

                    }

                }
            }

        }

        return response()->json($pila, 200);
        }
        else
        return response()->json("Periodos no encontrado",400);

    }

    public function getExsamenesAdmin()
    {
        $periodos = periodo::all();
        if($periodos != null)
        {
        $pila = array();
        foreach($periodos as $per){
            $aux = periodo::find($per->idperiodo);
            if($per != null){
                if($aux->tipo == 'examen'){
                    $actas = $aux->actas;
                    foreach($actas as $acta){
                        if($acta->estado == 'calificado' ){
                            array_push($pila, $aux);
                            break;
                        }

                    }

                }
            }

        }

        return response()->json($pila, 200);
        }
        else
        return response()->json("Periodos no encontrado",400);

    }

    public function getLectivosAlumno(Request $request)
    {
        $periodos = periodo::all();
        $us = Usuario::find($request->idusuario);
        if($periodos != null)
        {
        $pila = array();
        foreach($periodos as $per){
            $aux = periodo::find($per->idperiodo);
            if($aux != null){
                if($aux->tipo == 'lectivo'){
                    $cu = $aux->curso;
                    $cu2 = curso::find($cu->idcurso);
                    $carr = $cu2->carreras;
                    foreach($carr as $car){
                        $carrera =  $us->carrera;
                        foreach($carrera as $car2){
                            if($car->idcarrera == $car2->idcarrera ){
                                $fe = $aux->fechainscripcion;
                                $hoy = Carbon::today();
                                if($fe != null ){
                                    $fecha = Carbon::parse($fe->fechaFinal);
                                    if($hoy <= $fecha){
                                        $acta = acta::where('idusuario', '=',$request->idusuario);
                                        $t = true;
                                        foreach($acta as $a){
                                            if($a->estado == "cerrada"){
                                                $aux4 = periodo::find($a->idperiodo);
                                                if($aux4->idcurso == $aux->idcurso){
                                                    if($a->calificacion >= 3){
                                                        $t = false;
                                                    }
                                                }
                                            }

                                      }
                                        if($t){
                                            array_push($pila, $aux);
                                        }
                                    }
                                }
                            }
                        }

                    }

                }
            }

        }

        return response()->json($pila, 200);
        }
        else
        return response()->json("Periodos no encontrado",400);

    }

    public function getExsamenesSecretario()
    {
        $periodos = periodo::all();
        if($periodos != null)
        {
        $pila = array();
        foreach($periodos as $per){
            $aux = periodo::find($per->idperiodo);
            if($per != null){
                if($aux->tipo == 'examen'){
                        if($aux->fechainscripcion != null ){
                            array_push($pila, $aux);
                        }
                }
            }

        }

        return response()->json($pila, 200);
        }
        else
        return response()->json("Periodos no encontrado",400);

    }

    public function getLectivosSecretario()
    {
        $periodos = periodo::all();
        if($periodos != null)
        {
        $pila = array();
        foreach($periodos as $per){
            $aux = periodo::find($per->idperiodo);
            if($per != null){
                if($aux->tipo == 'lectivo'){
                        if($aux->fechainscripcion != null ){
                            array_push($pila, $aux);
                        }
                }
            }

        }

        return response()->json($pila, 200);
        }
        else
        return response()->json("Periodos no encontrado",400);

    }

    public function getExamenAlumno(Request $request)
    {
        $periodos = periodo::all();
        if($periodos != null)
        {
        $pila = array();
        foreach($periodos as $per){
            $aux = periodo::find($per->idperiodo);
            if($per != null){
                if($aux->tipo == 'examen'){
                    $cu = $aux->curso;
                    $cu2 = curso::find($cu->idcurso);
                    $carr = $cu2->carreras;
                    foreach($carr as $car){
                        $carrera =  Usuario::find($request->idusuario)->carrera;
                        foreach($carrera as $car2){
                            if($car->idcarrera == $car2->idcarrera ){
                                $fe = $aux->fechainscripcion;
                                $hoy = Carbon::today();
                                if($fe != null ){
                                    $fecha = Carbon::parse($fe->fechaFinal);
                                    if($hoy <= $fecha){
                                        $acta = acta::where('idusuario', '=',$request->idusuario);
                                        $t = true;
                                        foreach($acta as $a){
                                            if($a->estado == "cerrada"){
                                                $aux4 = periodo::find($a->idperiodo)->with('curso')->get();
                                                if($aux4->idcurso == $aux->idcurso){
                                                    if($a->calificacion >= 3){
                                                        $t = false;
                                                    }
                                                }
                                            }

                                        }
                                        if($t){
                                            array_push($pila, $aux);
                                        }
                                    }
                                }
                            }
                        }

                    }

                }
            }

        }

        return response()->json($pila, 200);
        }
        else
        return response()->json("Periodos no encontrado",400);

    }

    public function quitfechainscripcion(Request $request)
    {
        $periodo =  periodo::find($request->idperiodo);
        if($periodo != null){

                    if($periodo->docente != null){
                        $periodo->fechainscripcion()->delete();
                        $periodo->save();
                        $periodo->refresh();
                        return response()->json($periodo);
                    }
                else{
                return response()->json("El periodo no tiene fecha de inscripción",400);
                }
        }
        else
        return response()->json("Periodo no encontrado",400);
    }

    public function updatefechainscripcion(Request $request)
    {
        $periodo =  periodo::find($request->idperiodo);
        if($periodo != null){

                    if($periodo->fechainscripcion != null){
                        $periodo->fechainscripcion()->delete();
                        $periodo->save();
                        $fechainscripcion = new fechainscripcion();
                        $fechainscripcion->fechaInicial = new DateTime($request->fechaInicial);
                        $fechainscripcion->fechaFinal = new DateTime($request->fechaFinal);
                        $fechainscripcion->save();
                        $periodo->fechainscripcion()->save($fechainscripcion);
                        $periodo->save();
                        $periodo->refresh();
                        return response()->json($periodo,200);
                    }
                else{
                return response()->json("El periodo no tiene fecha de inscripción",400);
                }
        }
        else
        return response()->json("Periodo no encontrado",400);
    }

    public function addEstudiante(Request $request)
    {
        $periodo =  periodo::find($request->idperiodo);
        if($periodo != null){
            $Estudante =  Usuario::find($request->idusuario);
            if($Estudante != null){

                foreach($periodo->Estudiantes as $car){
                    if($car != null){
                            if( $car->idusuario == $request->idusuario){
                                return response()->json("El estudiante ya esta inscripto a este periodo",400);
                    }}}
                $periodo->Estudiantes()->save($Estudante);
                $periodo->refresh();
                return response()->json($periodo);
                }
                else{
                return response()->json("Usuario no encontrado",400);
                }

        return response()->json($periodo);
        }
        else
        return response()->json("Periodo no encontrado",400);
    }

    public function cerrarInscripcion(Request $request)
    {
        $periodo =  periodo::find($request->idperiodo);
        if($periodo != null){

                    if($periodo->fechainscripcion != null){
                        $periodo->fechainscripcion()->delete();
                        $periodo->save();
                        foreach($periodo->Estudiantes as $es){
                            if($es != null){
                                $Estudante =  Usuario::find($es->idusuario);
                                $acta = new acta;
                                $acta->estado = "abierta";
                                $acta->calificacion = 0;
                                $acta->save();
                                $acta->usuario()->associate($Estudante);
                                $periodo->actas()->save($acta);
                                $periodo->save();
                            }}
                        $periodo->refresh();
                        return response()->json($periodo);
                    }
                else{
                return response()->json("El periodo no tiene fecha de inscripción",400);
                }
        }
        else
        return response()->json("Periodo no encontrado",400);
    }

    public function cerrarActasAll(Request $request)
    {
        $periodo =  periodo::find($request->idperiodo);
        if($periodo != null){
                        $actas = $periodo->actas;
                        foreach($actas as $ac){
                            $acta =  acta::find($ac->idacta);
                            if($acta != null){
                                $acta->estado = "cerrada";
                                $acta->save();
                            }}
                        $periodo->refresh();
                        return response()->json($periodo);
        }
        else
        return response()->json("Periodo no encontrado",400);
    }

    public function cerrarActa(Request $request)
    {
        $acta =  acta::find($request->idacta);
        if($acta != null){
            $acta->estado = "cerrada";
            $acta->save();
            $acta->refresh();
            return response()->json($acta);
        }
        else
        return response()->json("Acta no encontrada",400);
    }

    public function calificarActa(Request $request)
    {
        $acta =  acta::find($request->idacta);
        if($acta != null){
            $acta->calificacion = $request->calificacion;
            $acta->estado = "calificado";
            $acta->save();
            $acta->refresh();
            return response()->json($acta);
        }
        else
        return response()->json("Acta no encontrada",400);
    }

    public function addClase(Request $request)
    {
        $periodo =  periodo::find($request->idperiodo);
        if($periodo != null){
            $case = new clase();
            $case->fecha = $request->fecha;
            $case->save();
            foreach($periodo->actas as $a){
                $asistencia = new asistencia();
                $asistencia->asistio = true;
                $asistencia->idusuario =$a->idusuario;
                $case->asistencias()->save($asistencia);
            }
            $periodo->clases()->save($case);
            return response()->json($case);
        }
        else
        return response()->json("Periodo no encontrada",400);
    }

    public function getClase(Request $request)
    {
        $periodo =  periodo::find($request->idperiodo);
        if($periodo != null){
            return response()->json($periodo->clases,200);
        }
        else
        return response()->json("Periodo no encontrado",400);
    }

    public function getAssistencias(Request $request)
    {
        $clase =  clase::find($request->idclase);
        $pila = array();
        if($clase != null){
            foreach($clase->asistencias as $a){
                $DTO = new DTOasistencia();
                $a2 =  asistencia::find($a->idasistencia);
                $DTO->idasistencia = $a->idasistencia;
                $DTO->nombre = $a2->usuario->persona->nombre;
                $DTO->apellido =$a2->usuario->persona->apellido;
                $DTO->asistio =$a->asistio;
                $periodo = periodo::find($request->idperiodo);
                $aux= 0;
                $aux2= 0;

                foreach($periodo->clases as $c){
                    $aux2= $aux2 +1;
                    foreach($c->asistencias as $a2)
                    {
                        if($a2->idusuario == $a->idusuario)
                        {
                            if($a2->asistio == false)
                            {
                                $date = Carbon::parse($c->fecha);
                                $Usuario = Usuario::find($a->idusuario);
                                $aux3 = false;
                                foreach($Usuario->certificados as $ce){
                                    $FechaInicial = Carbon::parse($ce->FechaInicial);
                                    $fechaFinal = Carbon::parse($ce->fechaFinal);
                                    if($date >= $FechaInicial){
                                        if($fechaFinal >= $date){
                                            $aux3 = true;
                                        }
                                    }
                                }
                                if($aux3){
                                    $aux= $aux + 0.5;
                                }
                                else{
                                    $aux = $aux + 1;
                                }
                            }


                        }

                    }
                }
                $DTO->inasistencias =$aux;
                $DTO->porsentaje = round(($aux/$aux2)*100);
                array_push($pila, $DTO);
            }
            return response()->json($pila,200);
        }
        else
        return response()->json("Periodo no encontrado",400);
    }

    public function addAssistencias(Request $request)
    {
            foreach($request->json() as $a){

                $as = asistencia::find($a['idasistencia']);
                if($as)
                {
                    $as->asistio = $a['asistio'];
                    $as->save();
                }
                else
                return response()->json("Asistencia no encontrada",400);
            }
            return response()->json("ok",200);
    }


}
