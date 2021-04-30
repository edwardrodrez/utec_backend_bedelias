<?php

namespace App\Http\Controllers;

use App\Models\acta;
use App\Models\areaDeEstudio;
use App\Models\tiposdecurso;
use App\Models\carrera;
use App\Models\carreraarea;
use App\Models\curso;
use App\Models\direccion;
use App\Models\fechainscripcion;
use App\Models\inscripcion;
use App\Models\periodo;
use App\Models\periododeincripciones;
use App\Models\persona;
use App\Models\previa;
use App\Models\roles;
use App\Models\sede;
use App\Models\Usuario;
use DateTime;
use Illuminate\Http\Request;

class precarga extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Usuario = Usuario::where('nombre', '=', "Juan.Sosa")->get();

        if($Usuario != null){
            //Usuarios
            //secretarios
        $secretario = new Usuario();
        $secretario->password= app('hash')->make("1234");
        $secretario->nombre ="secretario";
        $secretario->save();

        $secretaria = new Usuario();
        $secretaria->password= app('hash')->make("1234");
        $secretaria->nombre ="secretaria";
        $secretaria->save();

            //docentes
        $docente = new Usuario();
        $docente->password= app('hash')->make("1234");
        $docente->nombre ="docente";
        $docente->save();

        $profesor = new Usuario();
        $profesor->password= app('hash')->make("1234");
        $profesor->nombre ="profesor";
        $profesor->save();
            //Administrativos
        $Administrativo = new Usuario();
        $Administrativo->password= app('hash')->make("1234");
        $Administrativo->nombre ="admin";
        $Administrativo->save();
            //Multiroles
        $multi = new Usuario();
        $multi->password= app('hash')->make("1234");
        $multi->nombre ="multi";
        $multi->save();

        $Juan = new Usuario();
        $Juan->password= app('hash')->make("1234");
        $Juan->nombre ="Juan.Sosa";
        $Juan->save();
        $Pedro = new Usuario();
        $Pedro->password= app('hash')->make("1234");
        $Pedro->nombre ="Pedro.Sosa";
        $Pedro->save();
        $Marta = new Usuario();
        $Marta->password= app('hash')->make("1234");
        $Marta->nombre ="Marta.Sosa";
        $Marta->save();
        $Ana = new Usuario();
        $Ana->password= app('hash')->make("1234");
        $Ana->nombre ="Ana.Sosa";
        $Ana->save();
        $Eric = new Usuario();
        $Eric->password= app('hash')->make("1234");
        $Eric->nombre ="Eric.Sosa";
        $Eric->save();
        $Hugo = new Usuario();
        $Hugo->password= app('hash')->make("1234");
        $Hugo->nombre ="Hugo.Sosa";
        $Hugo->save();
        $Lara = new Usuario();
        $Lara->password= app('hash')->make("1234");
        $Lara->nombre ="Lara.Sosa";
        $Lara->save();
        $Leo = new Usuario();
        $Leo->password= app('hash')->make("1234");
        $Leo->nombre ="Leo.Sosa";
        $Leo->save();
        $Luz = new Usuario();
        $Luz->password= app('hash')->make("1234");
        $Luz->nombre ="Luz.Sosa";
        $Luz->save();
            //Personas
            $secretarioP = new persona();
            $secretarioP->ci = "52325278";
            $secretarioP->nombre = "Secretario";
            $secretarioP->apellido = "Sosa";
            $secretarioP->telefono = "092345678";
            $secretarioP->fechaDeNacimiento = "1996/03/06";
            $secretarioP->sexo = "Hombre";
            $secretarioP->save();

            $secretariaP = new persona();
            $secretariaP->ci = "82823974";
            $secretariaP->nombre = "Secretaria";
            $secretariaP->apellido = "Sosa";
            $secretariaP->telefono = "092345678";
            $secretariaP->fechaDeNacimiento = "1996/03/06";
            $secretariaP->sexo = "Mujer";
            $secretariaP->save();

            $docenteP = new persona();
            $docenteP->ci = "42525954";
            $docenteP->nombre = "Docente";
            $docenteP->apellido = "Sosa";
            $docenteP->telefono = "092345678";
            $docenteP->fechaDeNacimiento = "1996/03/06";
            $docenteP->sexo = "Hombre";
            $docenteP->save();

            $profesorP = new persona();
            $profesorP->ci = "52323334";
            $profesorP->nombre = "Profesor";
            $profesorP->apellido = "Sosa";
            $profesorP->telefono = "092345678";
            $profesorP->fechaDeNacimiento = "1996/03/06";
            $profesorP->sexo = "Hombre";
            $profesorP->save();

            $AdministrativoP = new persona();
            $AdministrativoP->ci = "58322234";
            $AdministrativoP->nombre = "Admin";
            $AdministrativoP->apellido = "Sosa";
            $AdministrativoP->telefono = "092345678";
            $AdministrativoP->fechaDeNacimiento = "1996/03/06";
            $AdministrativoP->sexo = "Hombre";
            $AdministrativoP->save();

            $multiP = new persona();
            $multiP->ci = "39329229";
            $multiP->nombre = "Multi";
            $multiP->apellido = "Sosa";
            $multiP->telefono = "092345678";
            $multiP->fechaDeNacimiento = "1996/03/06";
            $multiP->sexo = "Hombre";
            $multiP->save();

        $JuanP = new persona();
        $JuanP->ci = "12345678";
        $JuanP->nombre = "Juan";
        $JuanP->apellido = "Sosa";
        $JuanP->telefono = "092345678";
        $JuanP->fechaDeNacimiento = "1996/03/06";
        $JuanP->sexo = "Hombre";
        $JuanP->save();
        $PedroP = new persona();
        $PedroP->ci = "87654321";
        $PedroP->nombre = "Pedro";
        $PedroP->apellido = "Sosa";
        $PedroP->telefono = "092345678";
        $PedroP->fechaDeNacimiento = "1996/03/06";
        $PedroP->sexo = "Hombre";
        $PedroP->save();
        $MartaP = new persona();
        $MartaP->ci = "17654321";
        $MartaP->nombre = "Marta";
        $MartaP->apellido = "Sosa";
        $MartaP->telefono = "092345678";
        $MartaP->fechaDeNacimiento = "1996/03/06";
        $MartaP->sexo = "Mujer";
        $MartaP->save();
        $AnaP = new persona();
        $AnaP->ci = "27654322";
        $AnaP->nombre = "Ana";
        $AnaP->apellido = "Sosa";
        $AnaP->telefono = "092345678";
        $AnaP->fechaDeNacimiento = "1996/03/06";
        $AnaP->sexo = "Mujer";
        $AnaP->save();
        $EricP = new persona();
        $EricP->ci = "47654223";
        $EricP->nombre = "Eric";
        $EricP->apellido = "Sosa";
        $EricP->telefono = "092345678";
        $EricP->fechaDeNacimiento = "1996/03/06";
        $EricP->sexo = "Hombre";
        $EricP->save();
        $HugoP = new persona();
        $HugoP->ci = "86664223";
        $HugoP->nombre = "Hugo";
        $HugoP->apellido = "Sosa";
        $HugoP->telefono = "092345678";
        $HugoP->fechaDeNacimiento = "1996/03/06";
        $HugoP->sexo = "Hombre";
        $HugoP->save();
        $LaraP = new persona();
        $LaraP->ci = "38634223";
        $LaraP->nombre = "Lara";
        $LaraP->apellido = "Sosa";
        $LaraP->telefono = "092345678";
        $LaraP->fechaDeNacimiento = "1996/03/06";
        $LaraP->sexo = "Mujer";
        $LaraP->save();
        $LeoP = new persona();
        $LeoP->ci = "38534253";
        $LeoP->nombre = "Leo";
        $LeoP->apellido = "Sosa";
        $LeoP->telefono = "092345678";
        $LeoP->fechaDeNacimiento = "1996/03/06";
        $LeoP->sexo = "Hombre";
        $LeoP->save();
        $LuzP = new persona();
        $LuzP->ci = "67638223";
        $LuzP->nombre = "Luz";
        $LuzP->apellido = "Sosa";
        $LuzP->telefono = "092345678";
        $LuzP->fechaDeNacimiento = "1996/03/06";
        $LuzP->sexo = "Hombre";
        $LuzP->save();
            //direccion
        $JuanD = new direccion();
        $JuanD->departamento = "San Jose";
        $JuanD->ciudad = "San Jose de Mayo";
        $JuanD->calle = "Artigas";
        $JuanP->direccion()->save($JuanD);
        $PedroD = new direccion();
        $PedroD->departamento = "San Jose";
        $PedroD->ciudad = "San Jose de Mayo";
        $PedroD->calle = "Artigas";
        $PedroP->direccion()->save($PedroD);
        $MartaD = new direccion();
        $MartaD->departamento = "San Jose";
        $MartaD->ciudad = "San Jose de Mayo";
        $MartaD->calle = "Artigas";
        $MartaP->direccion()->save($MartaD);
        $AnaD = new direccion();
        $AnaD->departamento = "San Jose";
        $AnaD->ciudad = "San Jose de Mayo";
        $AnaD->calle = "Artigas";
        $AnaP->direccion()->save($AnaD);
        $EricD = new direccion();
        $EricD->departamento = "San Jose";
        $EricD->ciudad = "San Jose de Mayo";
        $EricD->calle = "Artigas";
        $EricP->direccion()->save($EricD);
        $HugoD = new direccion();
        $HugoD->departamento = "San Jose";
        $HugoD->ciudad = "San Jose de Mayo";
        $HugoD->calle = "Artigas";
        $HugoP->direccion()->save($HugoD);
        $LaraD = new direccion();
        $LaraD->departamento = "San Jose";
        $LaraD->ciudad = "San Jose de Mayo";
        $LaraD->calle = "Artigas";
        $LaraP->direccion()->save($LaraD);
        $LeoD = new direccion();
        $LeoD->departamento = "San Jose";
        $LeoD->ciudad = "San Jose de Mayo";
        $LeoD->calle = "Artigas";
        $LeoP->direccion()->save($LeoD);
        $LuzD = new direccion();
        $LuzD->departamento = "San Jose";
        $LuzD->ciudad = "San Jose de Mayo";
        $LuzD->calle = "Artigas";
        $LuzP->direccion()->save($LuzD);

        $secretarioD = new direccion();
        $secretarioD->departamento = "San Jose";
        $secretarioD->ciudad = "San Jose de Mayo";
        $secretarioD->calle = "Artigas";
        $secretarioP->direccion()->save($secretarioD);
        $secretariaD = new direccion();
        $secretariaD->departamento = "San Jose";
        $secretariaD->ciudad = "San Jose de Mayo";
        $secretariaD->calle = "Artigas";
        $secretariaP->direccion()->save($secretariaD);
        $docenteD = new direccion();
        $docenteD->departamento = "San Jose";
        $docenteD->ciudad = "San Jose de Mayo";
        $docenteD->calle = "Artigas";
        $docenteP->direccion()->save($docenteD);
        $profesorD = new direccion();
        $profesorD->departamento = "San Jose";
        $profesorD->ciudad = "San Jose de Mayo";
        $profesorD->calle = "Artigas";
        $profesorP->direccion()->save($profesorD);
        $AdministrativoD = new direccion();
        $AdministrativoD->departamento = "San Jose";
        $AdministrativoD->ciudad = "San Jose de Mayo";
        $AdministrativoD->calle = "Artigas";
        $AdministrativoP->direccion()->save($AdministrativoD);
        $multiD = new direccion();
        $multiD->departamento = "San Jose";
        $multiD->ciudad = "San Jose de Mayo";
        $multiD->calle = "Artigas";
        $multiP->direccion()->save($multiD);

        $Juan->persona()->save($JuanP);
        $Ana->persona()->save($AnaP);
        $Pedro->persona()->save($PedroP);
        $Marta->persona()->save($MartaP);
        $Eric->persona()->save($EricP);
        $Hugo->persona()->save($HugoP);
        $Lara->persona()->save($LaraP);
        $Leo->persona()->save($LeoP);
        $Luz->persona()->save($LuzP);

        $secretario->persona()->save($secretarioP);
        $secretaria->persona()->save($secretariaP);
        $docente->persona()->save($docenteP);
        $profesor->persona()->save($profesorP);
        $Administrativo->persona()->save($AdministrativoP);
        $multi->persona()->save($multiP);

        $sede1D = new direccion();
        $sede1D->departamento = "San Jose";
        $sede1D->ciudad = "San Jose";
        $sede1D->calle = "Artigas";
        $sede1 = new sede();
        $sede1->nombre ="Sede1";
        $sede1->save();
        $sede1->direccion()->save($sede1D);

        $sede2D = new direccion();
        $sede2D->departamento = "San Jose";
        $sede2D->ciudad = "San Jose";
        $sede2D->calle = "Artigas";
        $sede2 = new sede();
        $sede2->nombre ="Sede2";
        $sede2->save();
        $sede2->direccion()->save($sede2D);

        $sede3D = new direccion();
        $sede3D->departamento = "San Jose";
        $sede3D->ciudad = "San Jose";
        $sede3D->calle = "Artigas";
        $sede3 = new sede();
        $sede3->nombre ="Sede3";
        $sede3->save();
        $sede3->direccion()->save($sede3D);

        $sede4D = new direccion();
        $sede4D->departamento = "San Jose";
        $sede4D->ciudad = "San Jose";
        $sede4D->calle = "Artigas";
        $sede4 = new sede();
        $sede4->nombre ="Sede4";
        $sede4->save();
        $sede4->direccion()->save($sede4D);

        $carrera1 = new carrera();
        $carrera1->nombre = "Tecnologo informático";
        $carrera1->creditoMinimo = "100";
        $carrera1->save();

        $sede1->carreras()->save($carrera1);
        $sede2->carreras()->save($carrera1);

        $carrera2 = new carrera();
        $carrera2->nombre = "Maquinista Naval";
        $carrera2->creditoMinimo = "100";
        $carrera2->save();

        $sede3->carreras()->save($carrera2);
        $sede2->carreras()->save($carrera2);

        $carrera3 = new carrera();
        $carrera3->nombre = "Diseño Gráfico";
        $carrera3->creditoMinimo = "100";
        $carrera3->save();

        $sede1->carreras()->save($carrera3);
        $sede3->carreras()->save($carrera3);

        $carrera4 = new carrera();
        $carrera4->nombre = "Técnico Forestal";
        $carrera4->creditoMinimo = "100";
        $carrera4->save();

        $sede1->carreras()->save($carrera4);
        $sede2->carreras()->save($carrera4);
        $sede3->carreras()->save($carrera4);
        $sede4->carreras()->save($carrera4);

        $tiposdecurso1 = new tiposdecurso;
        $tiposdecurso1->nombre = "Sin calificación";
        $tiposdecurso1->save();
        $tiposdecurso2 = new tiposdecurso;
        $tiposdecurso2->nombre = "Proyecto";
        $tiposdecurso2->save();
        $tiposdecurso3 = new tiposdecurso;
        $tiposdecurso3->nombre = "Con examen";
        $tiposdecurso3->save();
        $tiposdecurso4 = new tiposdecurso;
        $tiposdecurso4->nombre = "Pasantía";
        $tiposdecurso4->save();


        $curso1 = new curso();
        $curso1->credito = "10";
        $curso1->nombre = "Principios de Programación";
        $curso1->tipoDeCurso()->associate($tiposdecurso3);
        $curso1->save();
        $carrera1->cursos()->save($curso1);

        $curso2 = new curso();
        $curso2->credito = "5";
        $curso2->nombre = "Arquitectura de Computadoras";
        $curso2->tipoDeCurso()->associate($tiposdecurso3);
        $curso2->save();
        $carrera1->cursos()->save($curso2);

        $curso3 = new curso();
        $curso3->credito = "4";
        $curso3->nombre = "Matemática Discreta y Lógica 1";
        $curso3->tipoDeCurso()->associate($tiposdecurso3);
        $curso3->save();
        $carrera1->cursos()->save($curso3);

        $curso4 = new curso();
        $curso4->credito = "4";
        $curso4->nombre = "Matemáticas";
        $curso4->tipoDeCurso()->associate($tiposdecurso3);
        $curso4->save();
        $carrera1->cursos()->save($curso4);
        $carrera2->cursos()->save($curso4);
        $carrera3->cursos()->save($curso4);
        $carrera4->cursos()->save($curso4);

        $curso5 = new curso();
        $curso5->credito = "8";
        $curso5->nombre = "Actividad Complementaria";
        $curso5->tipoDeCurso()->associate($tiposdecurso3);
        $curso5->save();
        $carrera1->cursos()->save($curso5);

        $curso6 = new curso();
        $curso6->credito = "10";
        $curso6->nombre = "Estructura de Datos y Algoritmos";
        $curso6->tipoDeCurso()->associate($tiposdecurso3);
        $curso6->save();
        $carrera1->cursos()->save($curso6);

        $curso7 = new curso();
        $curso7->credito = "6";
        $curso7->nombre = "Sistemas Operativos";
        $curso7->tipoDeCurso()->associate($tiposdecurso3);
        $curso7->save();
        $carrera1->cursos()->save($curso7);

        $curso8 = new curso();
        $curso8->credito = "6";
        $curso8->nombre = "Matemática Discreta y Lógica 2";
        $curso8->tipoDeCurso()->associate($tiposdecurso3);
        $curso8->save();
        $carrera1->cursos()->save($curso8);

        $curso9 = new curso();
        $curso9->credito = "12";
        $curso9->nombre = "Programación de Aplicaciones";
        $curso9->tipoDeCurso()->associate($tiposdecurso2);
        $curso9->save();
        $carrera1->cursos()->save($curso9);

        $curso19 = new curso();
        $curso19->credito = "15";
        $curso19->nombre = "Pasantía Laboral";
        $curso19->tipoDeCurso()->associate($tiposdecurso4);
        $curso19->save();
        $carrera1->cursos()->save($curso19);


        $previa = new previa();
        $previa->tipoPrevia = "Con Derecho a Examen";
        $previa->save();
        $previa->carrera()->associate($carrera1);
        $previa->curso()->associate($curso3);
        $curso8->previas()->save($previa);

        $previa = new previa();
        $previa->tipoPrevia = "Con Derecho a Examen";
        $previa->save();
        $previa->carrera()->associate($carrera1);
        $previa->curso()->associate($curso1);
        $curso6->previas()->save($previa);

        $previa = new previa();
        $previa->tipoPrevia = "Con Derecho a Examen";
        $previa->save();
        $previa->carrera()->associate($carrera1);
        $previa->curso()->associate($curso2);
        $curso7->previas()->save($previa);

        $previa = new previa();
        $previa->tipoPrevia = "Previa Aprobada";
        $previa->save();
        $previa->carrera()->associate($carrera1);
        $previa->curso()->associate($curso1);
        $curso9->previas()->save($previa);


        $areaDeEstudio = new areaDeEstudio();
        $areaDeEstudio->nombre = "Programación";
        $areaDeEstudio->save();

        $carreraarea = new carreraarea();
        $carreraarea->creditoMinimo = 30;
        $carreraarea->save();
        $carreraarea->carrera()->associate($carrera1);
        $areaDeEstudio->carreraArea()->save($carreraarea);

        $areaDeEstudio->cursos()->save($curso9);
        $areaDeEstudio->cursos()->save($curso7);
        $areaDeEstudio->cursos()->save($curso6);
        $areaDeEstudio->cursos()->save($curso2);
        $areaDeEstudio->cursos()->save($curso1);

        $areaDeEstudio3 = new areaDeEstudio();
        $areaDeEstudio3->nombre = "Otras";
        $areaDeEstudio3->save();

        $areaDeEstudio->cursos()->save($curso19);
        $areaDeEstudio->cursos()->save($curso5);

        $areaDeEstudio2 = new areaDeEstudio();
        $areaDeEstudio2->nombre = "Matematica";
        $areaDeEstudio2->save();

        $carreraarea2 = new carreraarea();
        $carreraarea2->creditoMinimo = 20;
        $carreraarea2->save();
        $carreraarea2->carrera()->associate($carrera1);
        $areaDeEstudio2->carreraArea()->save($carreraarea2);

        $carreraarea3 = new carreraarea();
        $carreraarea3->creditoMinimo = 10;
        $carreraarea3->save();
        $carreraarea3->carrera()->associate($carrera2);
        $areaDeEstudio2->carreraArea()->save($carreraarea3);
        $carreraarea4 = new carreraarea();
        $carreraarea4->creditoMinimo = 10;
        $carreraarea4->save();
        $carreraarea4->carrera()->associate($carrera3);
        $areaDeEstudio2->carreraArea()->save($carreraarea4);
        $carreraarea5 = new carreraarea();
        $carreraarea5->creditoMinimo = 15;
        $carreraarea5->save();
        $carreraarea5->carrera()->associate($carrera4);
        $areaDeEstudio2->carreraArea()->save($carreraarea5);

        $areaDeEstudio2->cursos()->save($curso8);
        $areaDeEstudio2->cursos()->save($curso4);
        $areaDeEstudio2->cursos()->save($curso3);

            //periodos
        $periodo1 = new periodo();
        $periodo1->tipo = "lectivo";
        $periodo1->fechaInicial = new DateTime('2020/11/11');
        $periodo1->fechaFinal = new DateTime('2021/04/29');
        $periodo1->save();
        $periodo1->curso()->associate($curso1);
        $periodo1->sede()->associate($sede1);
        $periodo1->save();

        $periodo2 = new periodo();
        $periodo2->tipo = "lectivo";
        $periodo2->fechaInicial = new DateTime('2020/11/11');
        $periodo2->fechaFinal = new DateTime('2021/04/29');
        $periodo2->save();
        $periodo2->curso()->associate($curso2);
        $periodo2->sede()->associate($sede1);
        $periodo2->save();

        $periodo3 = new periodo();
        $periodo3->tipo = "lectivo";
        $periodo3->fechaInicial = new DateTime('2020/11/11');
        $periodo3->fechaFinal = new DateTime('2021/04/29');
        $periodo3->save();
        $periodo3->curso()->associate($curso3);
        $periodo3->sede()->associate($sede2);
        $periodo3->save();

        $periodo4 = new periodo();
        $periodo4->tipo = "lectivo";
        $periodo4->fechaInicial = new DateTime('2020/11/11');
        $periodo4->fechaFinal = new DateTime('2021/04/29');
        $periodo4->save();
        $periodo4->curso()->associate($curso4);
        $periodo4->sede()->associate($sede3);
        $periodo4->save();

        $periodo5 = new periodo();
        $periodo5->tipo = "lectivo";
        $periodo5->fechaInicial = new DateTime('2020/01/15');
        $periodo5->fechaFinal = new DateTime('2021/04/29');
        $periodo5->save();
        $periodo5->curso()->associate($curso1);
        $periodo5->sede()->associate($sede1);
        $periodo5->save();

        $periodo6 = new periodo();
        $periodo6->tipo = "lectivo";
        $periodo6->fechaInicial = new DateTime('2020/01/15');
        $periodo6->fechaFinal = new DateTime('2021/04/29');
        $periodo6->save();
        $periodo6->curso()->associate($curso2);
        $periodo6->sede()->associate($sede1);
        $periodo6->save();

        $periodo7 = new periodo();
        $periodo7->tipo = "lectivo";
        $periodo7->fechaInicial = new DateTime('2020/01/15');
        $periodo7->fechaFinal = new DateTime('2021/04/29');
        $periodo7->save();
        $periodo7->curso()->associate($curso3);
        $periodo7->sede()->associate($sede4);
        $periodo7->save();

        $periodo8 = new periodo();
        $periodo8->tipo = "examen";
        $periodo8->fechaInicial = new DateTime('2020/01/15');
        $periodo8->fechaFinal = new DateTime('2021/04/29');
        $periodo8->save();
        $periodo8->curso()->associate($curso1);
        $periodo8->sede()->associate($sede1);
        $periodo8->save();

        $periodo9 = new periodo();
        $periodo9->tipo = "examen";
        $periodo9->fechaInicial = new DateTime('2020/01/15');
        $periodo9->fechaFinal = new DateTime('2021/04/29');
        $periodo9->save();
        $periodo9->curso()->associate($curso2);
        $periodo9->sede()->associate($sede3);
        $periodo9->save();

        $periodo11 = new periodo();
        $periodo11->tipo = "examen";
        $periodo11->fechaInicial = new DateTime('2020/01/13');
        $periodo11->fechaFinal = new DateTime('2021/04/29');
        $periodo11->save();
        $periodo11->curso()->associate($curso5);
        $periodo11->sede()->associate($sede3);
        $periodo11->save();

        $periodo22 = new periodo();
        $periodo22->tipo = "examen";
        $periodo22->fechaInicial = new DateTime('2020/01/13');
        $periodo22->fechaFinal = new DateTime('2021/04/29');
        $periodo22->save();
        $periodo22->curso()->associate($curso4);
        $periodo22->sede()->associate($sede3);
        $periodo22->save();

        $periodo33 = new periodo();
        $periodo33->tipo = "examen";
        $periodo33->fechaInicial = new DateTime('2020/12/15');
        $periodo33->fechaFinal = new DateTime('2021/04/29');
        $periodo33->save();
        $periodo33->curso()->associate($curso3);
        $periodo33->sede()->associate($sede2);
        $periodo33->save();

        $periodo44 = new periodo();
        $periodo44->tipo = "examen";
        $periodo44->fechaInicial = new DateTime('2020/12/16');
        $periodo44->fechaFinal = new DateTime('2021/04/29');
        $periodo44->save();
        $periodo44->curso()->associate($curso5);
        $periodo44->sede()->associate($sede2);
        $periodo44->save();

        $periodo55 = new periodo();
        $periodo55->tipo = "examen";
        $periodo55->fechaInicial = new DateTime('2020/12/17');
        $periodo55->fechaFinal = new DateTime('2021/04/29');
        $periodo55->save();
        $periodo55->curso()->associate($curso7);
        $periodo55->sede()->associate($sede2);
        $periodo55->save();

        $periodo66 = new periodo();
        $periodo66->tipo = "examen";
        $periodo66->fechaInicial = new DateTime('2020/12/15');
        $periodo66->fechaFinal = new DateTime('2021/04/29');
        $periodo66->save();
        $periodo66->curso()->associate($curso1);
        $periodo66->sede()->associate($sede1);
        $periodo66->save();

        $periodo77 = new periodo();
        $periodo77->tipo = "examen";
        $periodo77->fechaInicial = new DateTime('2020/12/15');
        $periodo77->fechaFinal = new DateTime('2021/04/29');
        $periodo77->save();
        $periodo77->curso()->associate($curso1);
        $periodo77->sede()->associate($sede1);
        $periodo77->save();

        $fechainscripcion77 = new fechainscripcion();
        $fechainscripcion77->fechaInicial = new DateTime('2020/11/01');
        $fechainscripcion77->fechaFinal = new DateTime('2021/04/29');
        $fechainscripcion77->save();
        $periodo77->fechainscripcion()->save($fechainscripcion77);
        $periodo77->save();

        $fechainscripcion = new fechainscripcion();
        $fechainscripcion->fechaInicial = new DateTime('2020/11/01');
        $fechainscripcion->fechaFinal = new DateTime('2021/04/29');
        $fechainscripcion->save();
        $periodo55->fechainscripcion()->save($fechainscripcion);
        $periodo55->save();

        $fechainscripcion = new fechainscripcion();
        $fechainscripcion->fechaInicial = new DateTime('2020/11/01');
        $fechainscripcion->fechaFinal = new DateTime('2021/04/29');
        $fechainscripcion->save();
        $periodo44->fechainscripcion()->save($fechainscripcion);
        $periodo44->save();

        $fechainscripcion = new fechainscripcion();
        $fechainscripcion->fechaInicial = new DateTime('2020/11/01');
        $fechainscripcion->fechaFinal = new DateTime('2021/04/29');
        $fechainscripcion->save();
        $periodo4->fechainscripcion()->save($fechainscripcion);
        $periodo4->save();

        $fechainscripcion = new fechainscripcion();
        $fechainscripcion->fechaInicial = new DateTime('2020/11/01');
        $fechainscripcion->fechaFinal = new DateTime('2021/04/29');
        $fechainscripcion->save();
        $periodo5->fechainscripcion()->save($fechainscripcion);
        $periodo5->save();
        }

        $roles2 = roles::create(['nombre' => 'Estudiante']);
        $roles1 = roles::create(['nombre' => 'Docente']);
        $roles3 = roles::create(['nombre' => 'Secretario']);
        $roles4 = roles::create(['nombre' => 'Administrativo']);

        //estudiantes
        $Juan->roles()->save($roles2);
        $Pedro->roles()->save($roles2);
        $Marta->roles()->save($roles2);
        $Eric->roles()->save($roles2);
        $Ana->roles()->save($roles2);
        $Hugo->roles()->save($roles2);
        $Lara->roles()->save($roles2);
        $Leo->roles()->save($roles2);
        $Luz->roles()->save($roles2);
        // docentes
        $docente->roles()->save($roles1);
        $profesor->roles()->save($roles1);
        // administrativos
        $Administrativo->roles()->save($roles4);
        //secretarios
        $secretario->roles()->save($roles3);
        $secretaria->roles()->save($roles3);
        // multi
        $multi->roles()->save($roles1);
        $multi->roles()->save($roles2);
        $multi->roles()->save($roles3);
        $multi->roles()->save($roles4);

        $Juan->carrera()->save($carrera1);
        $Pedro->carrera()->save($carrera1);
        $Marta->carrera()->save($carrera1);
        $Ana->carrera()->save($carrera1);
        $Hugo->carrera()->save($carrera1);
        $Lara->carrera()->save($carrera1);
        $Leo->carrera()->save($carrera1);
        $Luz->carrera()->save($carrera1);
        $multi->carrera()->save($carrera1);
        $Eric->carrera()->save($carrera1);

        $per = new periododeincripciones();
        $per->fechaInicial = new DateTime('2019/11/01');
        $per->fechaFinal = new DateTime('2021/04/29');
        $per->save();
        $carrera1->periodoDeIncripciones()->save($per);

        $per2 = new periododeincripciones();
        $per2->fechaInicial = new DateTime('2020/11/01');
        $per2->fechaFinal = new DateTime('2021/04/29');
        $per2->save();
        $carrera1->periodoDeIncripciones()->save($per2);

            $incripcion = new inscripcion();
            $incripcion->ci = "";
            $incripcion->escolaridad = "";
            $incripcion->carnetSalud = "";
            $incripcion->estado = "aprobada";
            $incripcion->save();
            $incripcion->persona()->associate($JuanP);
            $per->inscripciones()->save($incripcion);
            $per->refresh();

            $incripcion = new inscripcion();
            $incripcion->ci = "";
            $incripcion->escolaridad = "";
            $incripcion->carnetSalud = "";
            $incripcion->estado = "aprobada";
            $incripcion->save();
            $incripcion->persona()->associate($PedroP);
            $per->inscripciones()->save($incripcion);
            $per->refresh();

            $incripcion = new inscripcion();
            $incripcion->ci = "";
            $incripcion->escolaridad = "";
            $incripcion->carnetSalud = "";
            $incripcion->estado = "aprobada";
            $incripcion->save();
            $incripcion->persona()->associate($MartaP);
            $per->inscripciones()->save($incripcion);
            $per->refresh();

            $incripcion = new inscripcion();
            $incripcion->ci = "";
            $incripcion->escolaridad = "";
            $incripcion->carnetSalud = "";
            $incripcion->estado = "aprobada";
            $incripcion->save();
            $incripcion->persona()->associate($AnaP);
            $per->inscripciones()->save($incripcion);
            $per->refresh();

            $incripcion = new inscripcion();
            $incripcion->ci = "";
            $incripcion->escolaridad = "";
            $incripcion->carnetSalud = "";
            $incripcion->estado = "aprobada";
            $incripcion->save();
            $incripcion->persona()->associate($EricP);
            $per->inscripciones()->save($incripcion);
            $per->refresh();

            $incripcion = new inscripcion();
            $incripcion->ci = "";
            $incripcion->escolaridad = "";
            $incripcion->carnetSalud = "";
            $incripcion->estado = "aprobada";
            $incripcion->save();
            $incripcion->persona()->associate($HugoP);
            $per->inscripciones()->save($incripcion);
            $per->refresh();

            $incripcion = new inscripcion();
            $incripcion->ci = "";
            $incripcion->escolaridad = "";
            $incripcion->carnetSalud = "";
            $incripcion->estado = "aprobada";
            $incripcion->save();
            $incripcion->persona()->associate($LaraP);
            $per->inscripciones()->save($incripcion);
            $per->refresh();

            $incripcion = new inscripcion();
            $incripcion->ci = "";
            $incripcion->escolaridad = "";
            $incripcion->carnetSalud = "";
            $incripcion->estado = "aprobada";
            $incripcion->save();
            $incripcion->persona()->associate($LeoP);
            $per->inscripciones()->save($incripcion);
            $per->refresh();

            $incripcion = new inscripcion();
            $incripcion->ci = "";
            $incripcion->escolaridad = "";
            $incripcion->carnetSalud = "";
            $incripcion->estado = "aprobada";
            $incripcion->save();
            $incripcion->persona()->associate($LuzP);
            $per->inscripciones()->save($incripcion);
            $per->refresh();

            $incripcion = new inscripcion();
            $incripcion->ci = "";
            $incripcion->escolaridad = "";
            $incripcion->carnetSalud = "";
            $incripcion->estado = "aprobada";
            $incripcion->save();
            $incripcion->persona()->associate($multiP);
            $per->inscripciones()->save($incripcion);
            $per->refresh();


        $periodo1->docente()->associate($docente);
        $periodo1->save();
        $periodo2->docente()->associate($docente);
        $periodo2->save();
        $periodo3->docente()->associate($docente);
        $periodo3->save();
        $periodo4->docente()->associate($profesor);
        $periodo4->save();
        $periodo5->docente()->associate($docente);
        $periodo5->save();
        $periodo6->docente()->associate($docente);
        $periodo6->save();
        $periodo7->docente()->associate($profesor);
        $periodo7->save();
        $periodo8->docente()->associate($docente);
        $periodo8->save();
        $periodo9->docente()->associate($docente);
        $periodo9->save();
        $periodo11->docente()->associate($docente);
        $periodo11->save();
        $periodo22->docente()->associate($profesor);
        $periodo22->save();
        $periodo33->docente()->associate($profesor);
        $periodo33->save();
        $periodo44->docente()->associate($profesor);
        $periodo44->save();
        $periodo55->docente()->associate($docente);
        $periodo55->save();
        $periodo66->docente()->associate($docente);
        $periodo66->save();
        $periodo77->docente()->associate($docente);
        $periodo77->save();

        $acta = new acta();
        $acta->estado = "cerrada";
        $acta->calificacion = 2.1;
        $acta->save();
        $acta->usuario()->associate($Juan);
        $periodo7->actas()->save($acta);
        $periodo7->save();

        $acta = new acta;
        $acta->estado = "cerrada";
        $acta->calificacion = 4.3;
        $acta->save();
        $acta->usuario()->associate($Juan);
        $periodo2->actas()->save($acta);
        $periodo2->save();

        $acta = new acta;
        $acta->estado = "cerrada";
        $acta->calificacion = 4;
        $acta->save();
        $acta->usuario()->associate($Juan);
        $periodo1->actas()->save($acta);
        $periodo1->save();

        $acta = new acta;
        $acta->estado = "cerrada";
        $acta->calificacion = 4.6;
        $acta->save();
        $acta->usuario()->associate($Juan);
        $periodo8->actas()->save($acta);
        $periodo8->save();

        $acta = new acta;
        $acta->estado = "abierta";
        $acta->calificacion = 0;
        $acta->save();
        $acta->usuario()->associate($Juan);
        $periodo3->actas()->save($acta);
        $periodo3->save();

        $acta = new acta;
        $acta->estado = "abierta";
        $acta->calificacion = 0;
        $acta->save();
        $acta->usuario()->associate($Pedro);
        $periodo3->actas()->save($acta);
        $periodo3->save();

        $acta = new acta;
        $acta->estado = "abierta";
        $acta->calificacion = 0;
        $acta->save();
        $acta->usuario()->associate($Marta);
        $periodo3->actas()->save($acta);
        $periodo3->save();

        $acta = new acta;
        $acta->estado = "abierta";
        $acta->calificacion = 0;
        $acta->save();
        $acta->usuario()->associate($Ana);
        $periodo3->actas()->save($acta);
        $periodo3->save();

        $acta = new acta;
        $acta->estado = "abierta";
        $acta->calificacion = 0;
        $acta->save();
        $acta->usuario()->associate($Eric);
        $periodo3->actas()->save($acta);
        $periodo3->save();

        $acta = new acta;
        $acta->estado = "abierta";
        $acta->calificacion = 0;
        $acta->save();
        $acta->usuario()->associate($Hugo);
        $periodo3->actas()->save($acta);
        $periodo3->save();

        $acta = new acta;
        $acta->estado = "abierta";
        $acta->calificacion = 0;
        $acta->save();
        $acta->usuario()->associate($Lara);
        $periodo3->actas()->save($acta);
        $periodo3->save();

        $acta = new acta;
        $acta->estado = "abierta";
        $acta->calificacion = 0;
        $acta->save();
        $acta->usuario()->associate($Leo);
        $periodo3->actas()->save($acta);
        $periodo3->save();

        $acta = new acta;
        $acta->estado = "abierta";
        $acta->calificacion = 0;
        $acta->save();
        $acta->usuario()->associate($Luz);
        $periodo3->actas()->save($acta);
        $periodo3->save();

        $acta = new acta;
        $acta->estado = "abierta";
        $acta->calificacion = 0;
        $acta->save();
        $acta->usuario()->associate($Pedro);
        $periodo66->actas()->save($acta);
        $periodo66->save();

        $acta = new acta;
        $acta->estado = "abierta";
        $acta->calificacion = 0;
        $acta->save();
        $acta->usuario()->associate($Leo);
        $periodo66->actas()->save($acta);
        $periodo66->save();

        $acta = new acta;
        $acta->estado = "abierta";
        $acta->calificacion = 0;
        $acta->save();
        $acta->usuario()->associate($Lara);
        $periodo66->actas()->save($acta);
        $periodo66->save();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
}
