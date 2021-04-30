<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/


$router->group(['prefix' => 'usuario'], function () use ($router) {

    $router->post('login', 'UsuarioController@login');

});


$router->group(['middleware' => 'Admin'], function () use ($router) {

$router->get('/usuarios', 'UsuarioController@index');
$router->get('/usuario/getUsuarioId/{id}', 'UsuarioController@getUsuarioId');
$router->get('/usuarios/getDocentes', 'UsuarioController@getDocentes');
$router->get('/usuarios/getAdmin', 'UsuarioController@getAdmin');
$router->get('/usuarios/getSecretarios', 'UsuarioController@getSecretarios');
});

$router->group(['middleware' => 'Docente'], function () use ($router) {
$router->get('/usuario/getLectivosDocentes/{id}', 'UsuarioController@getLectivosDocentes');
$router->get('/usuario/getExsamenDocentes/{id}', 'UsuarioController@getExsamenDocentes');
});

$router->group(['middleware' => 'Admin'], function () use ($router) {

$router->post('/usuario/create', 'UsuarioController@create');
$router->post('/usuario/edit', 'UsuarioController@edit');
$router->post('/usuario/addDocente/{id}', 'UsuarioController@addDocente');
$router->post('/usuario/addEstudiante/{id}', 'UsuarioController@addEstudiante');
$router->post('/usuario/addSecretario/{id}', 'UsuarioController@addSecretario');
$router->post('/usuario/addAdministrativo/{id}', 'UsuarioController@addAdministrativo');
$router->post('/usuario/quitDocente/{id}', 'UsuarioController@quitDocente');
$router->post('/usuario/quitEstudiante/{id}', 'UsuarioController@quitEstudiante');
$router->post('/usuario/quitSecretario/{id}', 'UsuarioController@quitSecretario');
$router->post('/usuario/quitAdministrativo/{id}', 'UsuarioController@quitAdministrativo');
});

$router->post('/usuario/getUsuarioCi', 'UsuarioController@getUsuarioCi');
$router->post('/usuario/Validacion', 'UsuarioController@Validacion');

$router->group(['middleware' => 'Secretario'], function () use ($router) {

$router->post('/usuario/addCertificados', 'UsuarioController@addCertificados');
});

$router->group(['middleware' => 'Estudiente'], function () use ($router) {
$router->post('/usuario/getEscolaridadInfo', 'UsuarioController@getEscolaridadInfo');
$router->post('/usuario/getEscolaridadPdf', 'UsuarioController@getEscolaridadPdf');
$router->post('/usuario/addEscolaridad', 'UsuarioController@addEscolaridad');
});

$router->post('/usuario/cambiarPass', 'UsuarioController@cambiarPass');

$router->group(['middleware' => 'Admin'], function () use ($router) {
$router->get('/Curso/destroy/{id}', 'CursosController@destroy');
});
$router->get('/Cursos', 'CursosController@index');

$router->group(['middleware' => 'Admin'], function () use ($router) {
$router->get('/Cursos/getCursoSinArea', 'CursosController@getCursoSinArea');
});
$router->get('/Curso/getCarreras/{id}', 'CursosController@getCarreras');

$router->group(['middleware' => 'Admin'], function () use ($router) {
$router->post('/Curso/create', 'CursosController@create');
$router->post('/Curso/update/{id}', 'CursosController@update');
$router->post('/Curso/addprevia', 'CursosController@addprevia');
$router->post('/Curso/quitprevia', 'CursosController@quitprevia');
});

$router->post('/Curso/getPrevias', 'CursosController@getPrevias');
$router->get('/sedes', 'SedeController@index');
$router->group(['middleware' => 'Admin'], function () use ($router) {
$router->get('/sede/destroy/{id}', 'SedeController@destroy');
});

$router->get('/sede/{id}', 'SedeController@getSede');

$router->group(['middleware' => 'Admin'], function () use ($router) {
$router->post('/sede/create', 'SedeController@create');
$router->post('/sede/update/{id}', 'SedeController@update');
$router->post('/sede/addcarrera', 'SedeController@addcarrera');
$router->post('/sede/quitcarrera', 'SedeController@quitcarrera');
});


$router->get('/Carreras', 'CarrerasController@index');
$router->get('/Carrera/{id}', 'CarrerasController@getSede');

$router->group(['middleware' => 'Admin'], function () use ($router) {
$router->get('/Carrera/destroy/{id}', 'CarrerasController@destroy');
$router->post('/Carrera/create', 'CarrerasController@create');
$router->post('/Carrera/update/{id}', 'CarrerasController@update');
$router->post('/Carrera/addcurso', 'CarrerasController@addcurso');
$router->post('/Carrera/quitcurso', 'CarrerasController@quitcurso');
});

$router->get('/Carrera/getSedes/{id}', 'CarrerasController@getSedes');
$router->get('/Carrera/getCarrerasUs/{id}', 'CarrerasController@getCarrerasUs');
$router->get('/AreasDeEstudio', 'AreasDeEstudioController@index');

$router->group(['middleware' => 'Admin'], function () use ($router) {

$router->get('/AreasDeEstudio/destroy/{id}', 'AreasDeEstudioController@destroy');
$router->get('/AreasDeEstudio/{id}', 'AreasDeEstudioController@getAreasDeEstudio');
$router->post('/AreasDeEstudio/create', 'AreasDeEstudioController@create');
$router->post('/AreasDeEstudio/update/{id}', 'AreasDeEstudioController@update');
$router->post('/AreasDeEstudio/addcurso', 'AreasDeEstudioController@addcurso');
$router->post('/AreasDeEstudio/quitcurso', 'AreasDeEstudioController@quitcurso');
$router->post('/AreasDeEstudio/addCredito', 'AreasDeEstudioController@addCredito');
});

$router->get('/TipoDeCurso', 'TiposDeCursosController@index');
$router->get('/TipoDeCurso/{id}', 'TiposDeCursosController@getTipoDeCurso');

$router->group(['middleware' => 'Admin'], function () use ($router) {
$router->get('/TipoDeCurso/destroy/{id}', 'TiposDeCursosController@destroy');
$router->post('/TipoDeCurso/create', 'TiposDeCursosController@create');
$router->post('/TipoDeCurso/update/{id}', 'TiposDeCursosController@update');
});

$router->get('/Periodos/getLectivos', 'PeriodosController@getLectivos');
$router->get('/Periodos/getExamenes', 'PeriodosController@getExamenes');

$router->group(['middleware' => 'Secretario'], function () use ($router) {
$router->get('/Periodos/getLectivosSecretario', 'PeriodosController@getLectivosSecretario');
$router->get('/Periodos/getExsamenesSecretario', 'PeriodosController@getExsamenesSecretario');
});

$router->get('/Periodos/getLectivosActuales', 'PeriodosController@getLectivosActuales');
$router->get('/Periodos/getExamenesActuales', 'PeriodosController@getExamenesActuales');

$router->group(['middleware' => 'Admin'], function () use ($router) {

$router->get('/Periodos/getLectivosAdmin', 'PeriodosController@getLectivosAdmin');
$router->get('/Periodos/getExsamenesAdmin', 'PeriodosController@getExsamenesAdmin');
$router->post('/Periodos/create', 'PeriodosController@create');
$router->post('/Periodos/update/{id}', 'PeriodosController@update');
$router->get('/Periodos/destroy/{id}', 'PeriodosController@destroy');
});
$router->get('/Periodos/{id}', 'PeriodosController@getSede');

$router->group(['middleware' => 'Admin'], function () use ($router) {
$router->post('/Periodos/addDocente', 'PeriodosController@addDocente');
$router->post('/Periodos/quitDocente', 'PeriodosController@quitDocente');
$router->post('/Periodos/addfechainscripcion', 'PeriodosController@addfechainscripcion');
});
$router->post('/Periodos/quitfechainscripcion', 'PeriodosController@quitfechainscripcion');
$router->post('/Periodos/updatefechainscripcion', 'PeriodosController@updatefechainscripcion');

$router->post('/Periodos/addEstudiante', 'PeriodosController@addEstudiante');
$router->post('/Periodos/cerrarInscripcion', 'PeriodosController@cerrarInscripcion');
$router->post('/Periodos/getActas/{id}', 'PeriodosController@getActas');

$router->group(['middleware' => 'Secretario'], function () use ($router) {
$router->post('/Periodos/cerrarActasAll', 'PeriodosController@cerrarActasAll');
$router->post('/Periodos/cerrarActa', 'PeriodosController@cerrarActa');
});

$router->group(['middleware' => 'Docente'], function () use ($router) {
$router->post('/Periodos/calificarActa', 'PeriodosController@calificarActa');
});

$router->group(['middleware' => 'Estudiente'], function () use ($router) {
$router->post('/Periodos/getLectivosAlumno', 'PeriodosController@getLectivosAlumno');
$router->post('/Periodos/getExamenAlumno', 'PeriodosController@getExamenAlumno');
});

$router->group(['middleware' => 'Docente'], function () use ($router) {
$router->post('/Periodos/addClase', 'PeriodosController@addClase');
$router->post('/Periodos/getClase', 'PeriodosController@getClase');
$router->post('/Periodos/getAssistencias', 'PeriodosController@getAssistencias');
$router->post('/Periodos/addAssistencias', 'PeriodosController@addAssistencias');
});



$router->group(['middleware' => 'Admin'], function () use ($router) {
$router->get('/Inscripcion', 'InscripciónController@index');
$router->get('/Inscripcion/destroy/{id}', 'InscripciónController@destroy');
$router->post('/Inscripcion/create', 'InscripciónController@create');
$router->post('/Inscripcion/update/{id}', 'InscripciónController@update');
$router->post('/Inscripcion/Aceptarinscripcion', 'InscripciónController@Aceptarinscripcion');
$router->post('/Inscripcion/DenegarInscripcion', 'InscripciónController@DenegarInscripcion');
$router->post('/Inscripcion/informarInscripcion', 'InscripciónController@informarInscripcion');
$router->post('/Inscripcion/updateInscripcion', 'InscripciónController@updateInscripcion');
$router->post('/Inscripcion/getInscripcionesDePeriodo', 'InscripciónController@getInscripcionesDePeriodo');

});

$router->post('/Inscripcion/addInscripcion', 'InscripciónController@addInscripcion');
$router->get('/Inscripcion/getPeriodoInscripcionesValidas', 'InscripciónController@getPeriodoInscripcionesValidas');
$router->get('/precarga', 'precarga@index');

