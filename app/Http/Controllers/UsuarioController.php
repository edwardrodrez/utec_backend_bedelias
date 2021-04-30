<?php

namespace App\Http\Controllers;

use App\Models\acta;
use App\Models\areaDeEstudio;
use App\Models\carrera;
use App\Models\carreraarea;
use App\Models\certificado;
use App\Models\curso;
use App\Models\direccion;
use App\Models\DTOarea;
use App\Models\DTOescolaridad;
use App\Models\DTOMaterias;
use App\Models\DTOsemestre;
use App\Models\periodo;
use App\Models\Usuario;
use App\Models\persona;
use App\Models\roles;
use App\Models\DTOValid;
use App\Models\escolaridad;
use App\Models\inscripcion;
use App\Models\periododeincripciones;
use Carbon\Carbon;
use Carbon\Exceptions\NotAPeriodException;
use Egulias\EmailValidator\Exception\CharNotAllowed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\List_;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuario = Usuario::all();
        return response()->json($usuario, 200);
    }

    public function login(Request $request)
    {
          //validate incoming request
        $this->validate($request, [
            'nombre' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['nombre', 'password']);

        if (! $token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'El usuario o password son incorrectos'], 400);
        }
        $us = Usuario::where('nombre', $request->nombre)->first();
        if($us != null){
            $us->token = $token;
            $us->save();
        }
        $us->refresh();
        return response()->json($us,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $usuario = new Usuario();
        $length = 6;
        $chars = 'bcdfghjklmnopqrstuvwxyzABCDEFGHIJKLMNPQRSTVWXYZ0123456789';
        $count = mb_strlen($chars);

        for ($i = 0, $result = ''; $i < $length; $i++) {
            $index = rand(0, $count - 1);
            $result .= mb_substr($chars, $index, 1);
        }

        $usuario->password = app('hash')->make($result);
        $nombre = $request->input('persona.nombre').".".$request->input('persona.apellido');
        $us = Usuario::where('nombre', $nombre)->first();
        if($us == null){
            $usuario->nombre = $nombre;
        }
        else
        {
            $usuario->nombre = $request->input('persona.ci');
        }
        $per = new persona($request->persona);
        $direccion = new direccion($request->input('persona.direccion'));
        $Usuario2 = Usuario::with('persona')->get();
        foreach($Usuario2 as $us){

            if($us->persona != null){
                if($us->persona->ci == $per->ci){
                    return response()->json('Usuario ya registrado en la plataforma',400);
                }
            }

        }

        $to = $per->correo;
        $subject = "UTEC";
        $htmlContent = '<html><body><hr>
        <div style="width:100%;text-align: initial;padding-left:100px"><p style="color:#4984de;font-size:18px">Universidad Tecnológica del Uruguay.</p></div>
        <div style="width:100%;text-align: initial;padding-left:100px"><p style="color:#4984de;font-size:18px">Sección de Formación Profesional</p></div><br><br>
        <div style="width:100%;text-align:center"> <h1 style="color:#4786e6">Información de cuenta</h1></div>    

        <div style="width:100%;text-align: initial;"><p style="color:#333c4a;font-size:22px;padding-left:100px"> Su cuenta se ha registrado en la plataforma </p></div>
        <br><br><br><br><br><hr>
        <div style="width:100%;text-align:initial"><p style="color:#4984de;font-size:19px;padding-left:100px">Información de cuenta</p></div>

        <div style="width:100%;text-align:initial"><p style="color:#4984de;font-size:19px;padding-left:100px">Usuario: '.$nombre.'</p></div>
        <div style="width:100%;text-align:initial"><p style="color:#333c4a;font-size:19px;padding-left:100px">Contraseña : '.$result.'</p></div>
        


        </body></html>';
        
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        mail($to, $subject, $htmlContent ,$headers);
        $usuario->save();
        $per->save();
        $per->direccion()->save($direccion);
        $usuario->persona()->save($per);
        $usuario->refresh();
        return response()->json($usuario,200);
    }

    public function getUsuarioId($id)
    {
        $usuario = usuario::find($id);
        if($usuario)
        {
            return response()->json($usuario, 200);
        }

        return response()->json("Usuario no encontrado",400);
    }

    public function getUsuarioCi(Request $request)
    {
        $Usuario2 = Usuario::with('persona')->get();
        foreach($Usuario2 as $us){

            if($us->persona != null){
                if($us->persona->ci == $request->ci){
                    return response()->json($us,200);
                }
            }

        }

        return response()->json("Usuario no encontrado",400);
    }



    public function getLectivosDocentes($id)
    {
        $periodos = periodo::where('idusuario', '=', $id)->get();
        if($periodos != null)
        {
        $pila = array();
        foreach($periodos as $per){
            $aux = periodo::find($per->idperiodo);
            if($aux != null){
                if($aux->tipo == 'lectivo'){
                    $actas = $aux->actas;
                    foreach($actas as $acta){
                        if($acta->estado == 'abierta' ){
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
        return response()->json("Periodo no encontrado",400);
    }

    public function getExsamenDocentes($id)
    {
        $periodos = periodo::where('idusuario', '=', $id)->get();
        if($periodos != null)
        {
        $pila = array();
        foreach($periodos as $per){
            $aux = periodo::find($per->idperiodo);
            if($per != null){
                if($aux->tipo == 'examen'){
                    $us = $aux->idusuario;
                        if($us == $id ){
                            $actas = $aux->actas;
                            foreach($actas as $acta){
                                if($acta->estado == 'abierta' ){
                                    array_push($pila, $aux);
                                    break;
                                }

                            }
                        }

                    }

                }
            }



        return response()->json($pila, 200);
        }
        else
        return response()->json("Periodo no encontrado",400);
    }

    public function getDocentes()
    {
        $us = Usuario::all();
        $pila = array();
        if($us != null){
            foreach( $us as $u ){
                if($u != null){
                    $usuario = usuario::find($u->idusuario);
                    foreach( $usuario->roles as $rol ){
                        if($rol->nombre == 'Docente'){
                            array_push($pila, $usuario);
                        }
                    }
                }
            }
        }
        return response()->json($pila,200);
    }

    public function getAdmin()
    {
        $us = Usuario::all();
        $pila = array();
        if($us != null){
            foreach( $us as $u ){
                if($u != null){
                    $usuario = usuario::find($u->idusuario);
                    foreach( $usuario->roles as $rol ){
                        if($rol->nombre == 'Administrativo'){
                            array_push($pila, $usuario);
                        }
                    }
                }
            }
        }
        return response()->json($pila,200);
    }

    public function getSecretarios()
    {
        $us = Usuario::all();
        $pila = array();
        if($us != null){
            foreach( $us as $u ){
                if($u != null){
                    $usuario = usuario::find($u->idusuario);
                    foreach( $usuario->roles as $rol ){
                        if($rol->nombre == 'Secretario'){
                            array_push($pila, $usuario);
                        }
                    }
                }
            }
        }
        return response()->json($pila,200);
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
    public function edit(Request $request)
    {
        $usuario = usuario::find($request->idusuario);
        $persona = persona::find($usuario->persona->ci);
        $direccion = direccion::find($usuario->persona->direccion->iddireccion);

        $per = new persona($request->persona);
        $dir = new direccion($request->input('persona.direccion'));

        $persona->nombre = $per->nombre;
        $persona->apellido = $per->apellido;
        $persona->correo = $per->correo;
        $persona->telefono = $per->telefono;
        $persona->fechaDeNacimiento = $per->fechaDeNacimiento;
        $persona->sexo = $per->sexo;

        $direccion->departamento = $dir->departamento;
        $direccion->ciudad = $dir->ciudad;
        $direccion->calle = $dir->calle;

        $persona->save();
        $direccion->save();
        $usuario->refresh();
        return response()->json($usuario,200);
    }



    public function addDocente($id)
    {
        $Usuario =  Usuario::find($id);
        if($Usuario != null){
            $v = false;
            $roles2 = roles::all();
            foreach($roles2 as $rol){
                if( $rol->nombre == 'Docente'){
                    $v = true;
            }}
        if($v){
            foreach(Usuario::find($id)->roles as $rol){
                if($rol != false){
                        if( $rol->nombre == 'Docente'){
                    return response()->json("El usuario ya es Docente",400);
                }

                }
            }
            $roles2 = roles::all();
            foreach($roles2 as $rol){
                if( $rol->nombre == 'Docente'){
                    $roles2 = roles::find($rol->idroles);
                    $Usuario->roles()->save($roles2);
                    $Usuario->refresh();
                    return response()->json($Usuario);
            }}

        }
        else{
            $roles = roles::create(['nombre' => 'Docente']);
            $Usuario->roles()->save($roles);
            $Usuario->push();
            $Usuario->refresh();
            return response()->json($Usuario);
        }

        }
        else
        return response()->json("Usuario no encontrado",400);
    }
    public function quitDocente($id)
    {
        $Usuario =  Usuario::find($id);
        if($Usuario != null){
            foreach(Usuario::find($id)->roles as $rol){
                if($rol != false){
                        if( $rol->nombre == 'Docente'){
                            Usuario::find($id)->roles()->detach($rol->idroles);
                        }

                }
            }

        }
        else
        return response()->json("Usuario no encontrado",400);
    }

    public function addEstudiante($id)
    {
        $Usuario =  Usuario::find($id);
        if($Usuario != null){
            $v = false;
            $roles2 = roles::all();
            foreach($roles2 as $rol){
                if( $rol->nombre == 'Estudiante'){
                    $v = true;
            }}
        if($v){
            foreach(Usuario::find($id)->roles as $rol){
                if($rol != false){
                        if( $rol->nombre == 'Estudiante'){
                    return response()->json("El usuario ya es Estudiante",400);
                }

                }
            }
            $roles2 = roles::all();
            foreach($roles2 as $rol){
                if( $rol->nombre == 'Estudiante'){
                    $roles2 = roles::find($rol->idroles);
                    $Usuario->roles()->save($roles2);
                    $Usuario->refresh();
                    return response()->json($Usuario);
            }}

        }
        else{
            $roles = roles::create(['nombre' => 'Estudiante']);
            $Usuario->roles()->save($roles);
            $Usuario->push();
            $Usuario->refresh();
            return response()->json($Usuario);
        }

        }
        else
        return response()->json("Usuario no encontrado",400);
    }

    public function quitEstudiante($id)
    {
        $Usuario =  Usuario::find($id);
        if($Usuario != null){
            foreach(Usuario::find($id)->roles as $rol){
                if($rol != false){
                        if( $rol->nombre == 'Estudiante'){
                            Usuario::find($id)->roles()->detach($rol->idroles);
                        }

                }
            }

        }
        else
        return response()->json("Usuario no encontrado",400);
    }

    public function addSecretario($id)
    {
        $Usuario =  Usuario::find($id);
        if($Usuario != null){
            $v = false;
            $roles2 = roles::all();
            foreach($roles2 as $rol){
                if( $rol->nombre == 'Secretario'){
                    $v = true;
            }}
        if($v){
            foreach(Usuario::find($id)->roles as $rol){
                if($rol != false){
                        if( $rol->nombre == 'Secretario'){
                    return response()->json("El usuario ya es Secretario",400);
                }

                }
            }
            $roles2 = roles::all();
            foreach($roles2 as $rol){
                if( $rol->nombre == 'Secretario'){
                    $roles2 = roles::find($rol->idroles);
                    $Usuario->roles()->save($roles2);
                    $Usuario->refresh();
                    return response()->json($Usuario);
            }}

        }
        else{
            $roles = roles::create(['nombre' => 'Secretario']);
            $Usuario->roles()->save($roles);
            $Usuario->push();
            $Usuario->refresh();
            return response()->json($Usuario);
        }

        }
        else
        return response()->json("Usuario no encontrado",400);
    }

    public function quitSecretario($id)
    {
        $Usuario =  Usuario::find($id);
        if($Usuario != null){
            foreach(Usuario::find($id)->roles as $rol){
                if($rol != false){
                        if( $rol->nombre == 'Secretario'){
                            Usuario::find($id)->roles()->detach($rol->idroles);
                        }

                }
            }

        }
        else
        return response()->json("Usuario no encontrado",400);
    }

    public function addAdministrativo($id)
    {
        $Usuario =  Usuario::find($id);
        if($Usuario != null){
            $v = false;
            $roles2 = roles::all();
            foreach($roles2 as $rol){
                if( $rol->nombre == 'Administrativo'){
                    $v = true;
            }}
        if($v){
            foreach(Usuario::find($id)->roles as $rol){
                if($rol != false){
                        if( $rol->nombre == 'Administrativo'){
                        return response()->json("El usuario ya es Administrativo",400);
                        }

                }
            }
            $roles2 = roles::all();
            foreach($roles2 as $rol){
                if( $rol->nombre == 'Administrativo'){
                    $roles2 = roles::find($rol->idroles);
                    $Usuario->roles()->save($roles2);
                    $Usuario->refresh();
                    return response()->json($Usuario);
            }}

        }
        else{
            $roles = roles::create(['nombre' => 'Administrativo']);
            $Usuario->roles()->save($roles);
            $Usuario->push();
            $Usuario->refresh();
            return response()->json($Usuario);
        }

        }
        else
        return response()->json("Usuario no encontrado",400);
    }

    public function quitAdministrativo($id)
    {
        $Usuario =  Usuario::find($id);
        if($Usuario != null){
            foreach(Usuario::find($id)->roles as $rol){
                if($rol != false){
                        if( $rol->nombre == 'Administrativo'){
                            Usuario::find($id)->roles()->detach($rol->idroles);
                        }

                }
            }

        }
        else
        return response()->json("Usuario no encontrado",400);
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

    public function Validacion(Request $request)
    {
        $usuario = usuario::find($request->idusuario);
        if($usuario)
        {
            $periodo = periodo::find($request->idperiodo);
            if($periodo)
            {

            foreach($periodo->Estudiantes as $e){
               if($e->idusuario == $request->idusuario){
                $ret = new DTOValid();
                $ret->res = false;
                $ret->mensaje = "Ya estas anotado en este periodo";
                return response()->json($ret);
               }
            }
            if($periodo->docente->idusuario == $request->idusuario){
                $ret = new DTOValid();
                $ret->res = false;
                $ret->mensaje = "Eres el docente de esta materia";
                return response()->json($ret);
               }
               $cu = $periodo->curso;
               $curso = curso::find($cu->idcurso);
        


            
               if($curso)
               {
                    $pre = $curso->previas; //previas de la materia
                    foreach($pre as $p){
                        $valid = false;
                        $acta = acta::where('estado', '=', 'cerrada')->where('idusuario', '=', $request->idusuario)->get();
                        foreach($acta as $a){
                            $aux = periodo::find($a->idperiodo); // periodo del acta
                            if($aux->idcurso == $pre->idcurso)
                            {

                                if($p->tipoPrevia == "Con Derecho a Examen")
                                {

                                    if($aux->tipo == "lectivo")
                                    {

                                        if($a->calificacion >= 2)
                                        {
                                            $valid = true;
                                        }

                                    }


                                }

                                if($p->tipoPrevia == "Previa Aprobada")
                                {

                                        if($a->calificacion >= 3)
                                        {
                                            $valid = true;
                                        }
                                }

                            }

                        }
                        if($valid == false)
                        {

                            if($p->tipoPrevia == "Previa Aprobada")
                            {
                                $curso2 = curso::find($p->idcursoprevio);
                                $ret = new DTOValid();
                                $ret->res = false;
                                $ret->mensaje = "No de tener el curso ".$curso2->nombre." aprobado";
                                return response()->json($ret);
                            }


                            if($p->tipoPrevia == "Con Derecho a Examen")
                            {
                                $curso2 = curso::find($p->idcursoprevio);
                                $ret = new DTOValid();
                                $ret->res = false;
                                $ret->mensaje = "No tenes derecho a examen en el curso ".$curso2->nombre;
                                return response()->json($ret);
                            }
                        }

                    }
                    $ret = new DTOValid();
                    $ret->res = True;
                    $ret->mensaje = "El Estudiante cumple los requisitos necesarios";
                    return response()->json($ret);
               }


            }
            else{
            return response()->json("Periodo no encontrado",400);
            }
        }
        else{
        return response()->json("Usuario no encontrado",400);
        }

    }

    public function addCertificados(Request $request)
    {
        $us = Usuario::find($request->idusuario);
        if($us)
        {
            $ce = new certificado();
            $ce->FechaInicial = $request->FechaInicial;
            $ce->fechaFinal = $request->fechaFinal;
            $us->certificados()->save($ce);
        }
        else{
        return response()->json("Usuario no encontrado",400);
        }

    }

    public function getEscolaridadInfo(Request $request)
    {
        $usuario = usuario::find($request->idusuario);
        if($usuario)
        {

            $carrera = carrera::find($request->idcarrera);
               if($carrera)
               {
                        $listaAreas= array();
                        $pro = 0;
                        $cant = 0;
                        $creT = 0;
                        $carreraarea = carreraarea::where('idcarrera', '=', $request->idcarrera)->get();
                        foreach($carreraarea as $c){
                            $areaDeEstudio = areaDeEstudio::find($c->idareadeestudio);
                            $listaMateria = array();
                            $Cre = 0;
                            $acta = acta::where('estado', '=', 'cerrada')->where('idusuario', '=', $request->idusuario)->get();
                            foreach($acta as $a2){
                                $periodo2 = periodo::find($a2->idperiodo);
                                $mat = curso::find($periodo2->idcurso);

                                if($mat->idareadeestudio == $c->idareadeestudio){

                                    $materia = $mat->nombre;
                                    $tipo = $periodo2->tipo;
                                    $fecha = $periodo2->fechaFinal;
                                    $Nota = $a2->calificacion;
                                    $pro = $pro + $a2->calificacion;
                                    if($mat->tipoDeCurso->nombre != "Sin calificación"){
                                        $cant = $cant + 1;
                                        $Cre = $Cre + $mat->credito;
                                    }                               
                                    $credito = $mat->credito;
                                    $dto = new DTOMaterias($materia,$tipo,$fecha,$Nota,$credito);
                                    $dto->materia = $materia;
                                    $dto->tipo =$tipo;
                                    $dto->fecha =$fecha;
                                    $dto->nota =$Nota;
                                    $dto->creditos =$credito;
                                    array_push($listaMateria, $dto);
                                }
                            }
                            $nombre = $areaDeEstudio->nombre;
                            $creditosMinimos = $c->creditoMinimo;
                            $creditosTiene = $Cre;
                            $creT = $creT + $Cre;            
                            $dto2 = new DTOarea($nombre,$creditosMinimos,$creditosTiene,$listaMateria);
                            $dto2->nombre = $nombre;
                            $dto2->creditosMinimos = $creditosMinimos;
                            $dto2->creditosTiene = $creditosTiene;
                            $dto2->materias = $listaMateria;
                            array_push($listaAreas,  $dto2);
                        }
                         $nombre = $usuario->persona->nombre;
                         $apellido = $usuario->persona->apellido;
                         $cedula = $usuario->persona->ci;

                         $incr = inscripcion::where('estado', '=', 'aprobada')->where('idpersona', '=', $usuario->persona->ci)->get();
                         foreach($incr as $in){
                            $per = periododeincripciones::find($in->idperiododeincripciones);
                            if($per->idcarrera = $carrera->idcarrera){
                                $añoDeIngreso = $per->fechaFinal;
                            }
                         }
                         $creditosDeCarrera = $carrera->creditoMinimo;
                         $carrera = $carrera->nombre;
                         if($cant != 0){
                            $Promedio = $pro/$cant;
                         }else{
                            $Promedio = 0;
                         }
                         $creditosTotales = $creT;
                         $areas = $listaAreas;
                         $ret = new DTOescolaridad($nombre,$apellido,$cedula,$añoDeIngreso,$carrera,$Promedio,$creditosTotales,$creditosDeCarrera,$areas);
                         $ret->nombre = $nombre;
                         $ret->apellido = $apellido;
                         $ret->cedula =$cedula;
                         $ret->añoDeIngreso =$añoDeIngreso;
                         $ret->carrera =$carrera;
                         $ret->Promedio =$Promedio;
                         $ret->creditosTotales =$creditosTotales;
                         $ret->creditosDeCarrera =$creditosDeCarrera;
                         $ret->areas =$areas;
                         return response()->json($ret,200);
                }
                else{
                return response()->json("Carrera no encontrada",400);
                }
        }
        else{
        return response()->json("Usuario no encontrado",400);
        }

    }

    public function addEscolaridad(Request $request)
    {
            $escolaridad = new escolaridad();
            $escolaridad->codigo = $request->codigo;
            $escolaridad->fechaExpiracion = $request->fechaExpiracion;
            $escolaridad->pdf = $request->pdf;
            $escolaridad->save();
    }

    public function getEscolaridadPdf(Request $request)
    {
        $escolaridad = escolaridad::where('codigo', '=', $request->codigo);
		$escolaridad = escolaridad::Where('codigo', $request->codigo)->first();        if($escolaridad)
        {
            $hoy = Carbon::today();
            $fecha = Carbon::parse($escolaridad->fechaExpiracion);
            if($hoy <= $fecha){

                return response()->json($escolaridad->pdf,200);
            }
            else{
                return response()->json("El tiempo de expiración de la escolaridad (PDF) ha caducado",400);
            }
        }
        else{
            return response()->json("Código no encontrado",400);
        }

    }

    public function cambiarPass(Request $request)
    {

        $token2=str_replace('"','',$request->bearerToken());

        $us = Usuario::where('token', $token2)->first();
        if($us)
        {
            $us->password = app('hash')->make($request->pass);
            $us->save();
            return response()->json("Contraseña cambiada correctamente",200);
        }
        else{
           return response()->json("Usuario no encontrado",400);        }

    }


}
