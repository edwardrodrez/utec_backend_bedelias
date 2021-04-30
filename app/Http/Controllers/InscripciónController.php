<?php

namespace App\Http\Controllers;

use App\Models\carrera;
use App\Models\direccion;
use App\Models\incripcion;
use App\Models\inscripcion;
use App\Models\periododeincripciones;
use App\Models\persona;
use App\Models\roles;
use App\Models\Usuario;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;

class InscripciónController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $per = periododeincripciones::all();
        if($per != null){
        return response()->json($per, 200);
        }
        else
        return response()->json("No hay periodos de incripciones",400);

    }

    public function getPeriodoInscripcionesValidas()
    {
        $per = periododeincripciones::whereDate('fechaFinal', '>', Carbon::today()->toDateString())->get();;
        if($per != null){

        return response()->json($per, 200);
        }
        else
        return response()->json("No hay periodos de incripciones",400);

    }


    public function getInscripcionesDePeriodo(Request $request)
    {
        $inscripcion = inscripcion::where('idperiododeincripciones', '=', $request->idperiododeincripciones)->where('estado', '=',"pendiente")->get();
        if($inscripcion != null){
            return response()->json($inscripcion, 200);
        }
        else
        return response()->json("Periodos de incripciones no encontrado",400);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $per = new periododeincripciones;
        $per->fechaInicial = new DateTime($request->fechaInicial);
        $per->fechaFinal = new DateTime($request->fechaFinal);
        $car = carrera::find($request->idcarrera);
        $per->save();
        $car->periodoDeIncripciones()->save($per);
        $per->refresh();
        return response()->json($per);
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
        $per = periododeincripciones::find($id);
        if($per != null){
            $per->fechaInicial = new DateTime($request->fechaInicial);
            $per->fechaFinal = new DateTime($request->fechaFinal);
            $car = carrera::find($request->idcarrera);
            $per->carrera()->dissociate();
            $per->save();
            $car->periodoDeIncripciones()->save($per);
            $per->refresh();
            return response()->json($per);
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
        $per = periododeincripciones::find($id);
        if($per != null){
            $per->carrera()->dissociate();
            $per->inscripciones()->delete();
            $per->delete();
        }
        else
        return response()->json("Periodo no encontrado",400);
    }

    public function addInscripcion(Request $request)
    {
        $periodo =  periododeincripciones::find($request->idperiododeincripciones);
        if($periodo != null){

                $incripcion = new inscripcion;
                $persona =  persona::find($request->input('persona.ci'));
                if($persona == null){
                $per = new persona($request->persona);
                $incripcion->ci = $request->ci;
                $incripcion->escolaridad = $request->escolaridad;
                $incripcion->carnetSalud = $request->carnetSalud;
                $direccion = new direccion($request->input('persona.direccion'));
                $incripcion->estado = "pendiente";
                $incripcion->save();
                
                $per->save();
                $per->direccion()->save($direccion);
                $incripcion->persona()->associate($per);
                $periodo->inscripciones()->save($incripcion);
                $periodo->refresh();
                }
                else{
                    $incripcion->ci = $request->ci;
                    $incripcion->escolaridad = $request->escolaridad;
                    $incripcion->carnetSalud = $request->carnetSalud;
                    $incripcion->estado = "pendiente";
                    $incripcion->save();
                    $incripcion->persona()->associate($persona);
                    $periodo->inscripciones()->save($incripcion);
                    $periodo->refresh();
                }
                return response()->json($periodo,200);
        }
        else
        return response()->json("Periodo no encontrado",400);
    }

    public function updateInscripcion(Request $request)
    {
        $inscripcion =  Inscripcion::find($request->idInscripcion);
        if($inscripcion != null){
                    $inscripcion->ci = $request->ci;
                    $inscripcion->escolaridad = $request->escolaridad;
                    $inscripcion->carnetSalud = $request->carnetSalud;
                    $inscripcion->save();
                    return response()->json("ok",200);
        }
        else
        return response()->json("Periodo no encontrado",400);
    }

    public function Aceptarinscripcion (Request $request)
    {
        $inscripcion = inscripcion::find($request->idInscripcion);
        if($inscripcion != null){
            $usuario = new Usuario();
            $length = 6;
            $chars = 'bcdfghjklmnopqrstuvwxyzABCDEFGHIJKLMNPQRSTVWXYZ0123456789';
            $count = mb_strlen($chars);

            for ($i = 0, $result = ''; $i < $length; $i++) {
                $index = rand(0, $count - 1);
                $result .= mb_substr($chars, $index, 1);
            }

            $periododeincripciones = periododeincripciones::find($inscripcion->idperiododeincripciones);
            $carrera = carrera::find($periododeincripciones->idcarrera);
            $nombreCarrera = $carrera->nombre;

            $usuario->password = app('hash')->make($result);
            $nom = $inscripcion->persona->nombre;
            $ap = $inscripcion->persona->apellido;
            $nombre = $nom.".".$ap;
            $us = Usuario::where('nombre', $nombre)->first();
            if($us == null){
                $usuario->nombre = $nombre;
            }
            else
            {
                $usuario->nombre = $inscripcion->persona->ci;
            }
            $per = $inscripcion->persona;
            $Usuario2 = Usuario::with('persona')->get();

            foreach($Usuario2 as $us){

                if($us->persona != null){
                    if($us->persona->ci == $per->ci){
                    $aux = Usuario::find($us->idusuario);
                    $bool=false;
                    foreach( $aux->carrera as $carr){
                        if ($carr->idcarrera == $carrera->idcarrera){
                            $bool=true;
                        }

                    }
                    if($bool){
                        return response()->json('La persona ya esta inscripta en la carrera',400);
                    }
                    $aux->carrera()->save($carrera);

                    $v = false;
                    $roles2 = roles::all();
                    foreach($roles2 as $rol){
                        if( $rol->nombre == 'Estudiante'){
                            $v = true;
                    }}
                    if($v){
                        $v2 = true;
                        foreach($aux->roles() as $rol){
                            if($rol != false){
                                    if( $rol->nombre == 'Estudiante'){
                                        $v2 = false;
                            }

                            }
                        }
                        if($v2 == true){
                            $roles2 = roles::all();
                            foreach($roles2 as $rol){
                                if( $rol->nombre == 'Estudiante'){
                                    $roles2 = roles::find($rol->idroles);
                                    $aux->roles()->save($roles2);
                                    $aux->refresh();
                            }}
                        }


                }
                else{
                    $roles = roles::create(['nombre' => 'Estudiante']);
                    $aux->roles()->save($roles);
                    $aux->push();
                    $aux->refresh();
                }

                    // correo
                    $to = $per->correo;
                    $subject = "Inscripción a Carrera UTEC";

                    $htmlContent = '<html><body><hr>
                    <div style="width:100%;text-align: initial;padding-left:100px"><p style="color:#4984de;font-size:18px">Universidad Tecnológica del Uruguay.</p></div>
                    <div style="width:100%;text-align: initial;padding-left:100px"><p style="color:#4984de;font-size:18px">Sección de Formación Profesional</p></div><br><br>
                    <div style="width:100%;text-align:center"> <h1 style="color:#4786e6">CARTA DE ACEPTACIÓN</h1></div>
                    <div style="width:100%;text-align: initial;"><p style="color:#333c4a;font-size:22px;padding-left:100px">Sr. '.$nom.' '.$ap.'</p></div>
                    
        
                    <div style="width:100%;text-align: initial;"><p style="color:#333c4a;font-size:22px;padding-left:100px">Por medio de la presente se le informa su admisión en nuestra casa de estudios, en la carrera'.' '.$nombreCarrera.'.</p></div>
                    <br><br><br><br><br><hr>
                    <div style="width:100%;text-align:initial"><p style="color:#4984de;font-size:19px;padding-left:100px">Información de cuenta</p></div>
        
                    <div style="width:100%;text-align:initial"><p style="color:#4984de;font-size:19px;padding-left:100px">Ya posee de una cuenta en la plataforma</p></div>
                    <div style="width:100%;text-align:initial"><p style="color:#333c4a;font-size:19px;padding-left:100px">Usuario: '.$nombre.'</p></div>
                    
        
        
                    </body></html>';
                    $headers = "From: sosasepergo@hotmail.com";
                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                    mail($to, $subject, $htmlContent ,$headers);
                    $inscripcion->estado = "aprobada";
                    $inscripcion->save();
                    return response()->json('ok',200);
                    }
                }

            }
            $usuario->save();
            $usuario->persona()->save($per);
            $usuario->carrera()->save($carrera);
            $usuario->refresh();

            $aux = Usuario::find($usuario->idusuario);

            $v = false;
            $roles2 = roles::all();
            foreach($roles2 as $rol){
                if( $rol->nombre == 'Estudiante'){
                    $v = true;
            }}
            if($v){
                $v2 = true;
                foreach($aux->roles() as $rol){
                    if($rol != false){
                            if( $rol->nombre == 'Estudiante'){
                                $v2 = false;
                    }

                    }
                }
                if($v2 == true){
                    $roles2 = roles::all();
                    foreach($roles2 as $rol){
                        if( $rol->nombre == 'Estudiante'){
                            $roles2 = roles::find($rol->idroles);
                            $aux->roles()->save($roles2);
                            $aux->refresh();
                    }}
                }


        }
        else{
            $roles = roles::create(['nombre' => 'Estudiante']);
            $aux->roles()->save($roles);
            $aux->push();
            $aux->refresh();
            return response()->json($aux);
        }

            // correo
            $to = $per->correo;
            $subject = "Inscripción a Carrera UTEC";
            $htmlContent = '<html><body><hr>
            <div style="width:100%;text-align: initial;padding-left:100px"><p style="color:#4984de;font-size:18px">Universidad Tecnológica del Uruguay.</p></div>
            <div style="width:100%;text-align: initial;padding-left:100px"><p style="color:#4984de;font-size:18px">Sección de Formación Profesional</p></div><br><br>
            <div style="width:100%;text-align:center"> <h1 style="color:#4786e6">CARTA DE ACEPTACIÓN</h1></div>
            <div style="width:100%;text-align: initial;"><p style="color:#333c4a;font-size:22px;padding-left:100px">Sr. '.$nom.' '.$ap.'</p></div>
            

            <div style="width:100%;text-align: initial;"><p style="color:#333c4a;font-size:22px;padding-left:100px">Por medio de la presente se le informa su admisión en nuestra casa de estudios, en la carrera'.' '.$nombreCarrera.'.</p></div>
            <br><br><br><br><br><hr>
            <div style="width:100%;text-align:initial"><p style="color:#4984de;font-size:19px;padding-left:100px">Información de cuenta</p></div>

            <div style="width:100%;text-align:initial"><p style="color:#333c4a;font-size:19px;padding-left:100px">Usuario: '.$nombre.'</p></div>
            <div style="width:100%;text-align:initial"><p style="color:#333c4a;font-size:19px;padding-left:100px">Contraseña : '.$result.'</p></div>

            <div style="width:100%;text-align:center"><p style="color:#333c4a;font-size:20px;padding-left:100px">Por favor cambie la contraseña una ves que inicie sesión.</p></div>

            </body></html>';
            $headers = "From: sosasepergo@hotmail.com";
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            mail($to, $subject, $htmlContent ,$headers );
            $inscripcion->estado = "aprobada";
            $inscripcion->save();
            return response()->json('ok',200);
        }
        else
        return response()->json("Inscripción no encontrada",400);
    }


    public function DenegarInscripcion(Request $request)
    {
        $inscripcion = inscripcion::find($request->idInscripcion);
        if($inscripcion != null){
                        $per = $inscripcion->persona;
                        $nom = $inscripcion->persona->nombre;
                        $ap = $inscripcion->persona->apellido;
                        $motivos = $request->motivos;
                        // correo
                        $to = $per->correo;
                        $subject = "Inscripción a Carrera UTEC";
                        $htmlContent = '<html><body><hr>
                        <div style="width:100%;text-align: initial;padding-left:100px"><p style="color:#4984de;font-size:18px">Universidad Tecnológica del Uruguay.</p></div>
                        <div style="width:100%;text-align: initial;padding-left:100px"><p style="color:#4984de;font-size:18px">Sección de Formación Profesional</p></div><br><br>
                        <div style="width:100%;text-align:center"> <h1 style="color:#4786e6">CARTA DE ACEPTACIÓN</h1></div>
                        <div style="width:100%;text-align: initial;"><p style="color:#333c4a;font-size:22px;padding-left:100px">Sr. '.$nom.' '.$ap.'</p></div>
                        
            
                        <div style="width:100%;text-align: initial;"><p style="color:#333c4a;font-size:22px;padding-left:100px">Por medio de la presente se le informa que su inscripción en nuestra casa de estudios fue rechazada
            
                        Motivos: '.' '.$motivos.'.</p></div>
                        <br><br><br><br><br><hr>
                        
            
            
                        </body></html>';
                        $headers = "From: sosasepergo@hotmail.com";
                        $headers = "MIME-Version: 1.0" . "\r\n";
                        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                        mail($to, $subject,  $htmlContent ,$headers);
                        $inscripcion->estado = "denegada";
                        $inscripcion->save();
                        return response()->json('ok',200);

        }
        else
        return response()->json("Inscripción no encontrada",400);
    }


    public function informarInscripcion(Request $request)
    {
        $inscripcion = inscripcion::find($request->idInscripcion);
        if($inscripcion != null){
                        $per = $inscripcion->persona;
                        $nom = $inscripcion->persona->nombre;
                        $ap = $inscripcion->persona->apellido;
                        $motivos = $request->motivos;
                        // correo
                        $to = $per->correo;
                        $subject = "Inscripcion a Carrera UTEC";
                        $message = $request->message;
                        $headers = "From: ".$request->correo;
                        return response()->json('ok',200);

        }
        else
        return response()->json("Inscripción no encontrada",400);
    }

}
