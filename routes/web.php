<?php

use App\Http\Controllers\ActividadController;
use App\Http\Controllers\CronogramaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\inicioControl;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InformeController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\Materials_informesController;
use App\Http\Controllers\DescargoController;
use App\Http\Controllers\PDFController;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
*/

Route::get('/', inicioControl::class);

Route::middleware(['auth:sanctum', 'verified'])->get('/dash', function () {
    return view('dash.index');
})->name('dash');
// CRUD USUARIOS
Route::resource('users', UserController::class)->only('index','edit','update','create','registrar')->names('users');
// Crud SOLICITUD
Route::get('Lista_solicitud', [SolicitudController::class, 'index'])->middleware('can:solicitud.index')->name('solicitud.index');
Route::get('solicitud/registrar_solicitud', [SolicitudController::class, 'create'])->middleware('can:solicitud.create')->name('solicitud.create');
Route::post('solicitud/registrar_solicitud', [SolicitudController::class, 'store'])->name('solicitud.store');
Route::get('solicitud/{solicitud}/edit', [SolicitudController::class, 'edit'])->middleware('can:solicitud.edit')->name('solicitud.edit');
Route::put('solicitud/{solicitud}', [SolicitudController::class, 'update'])->middleware('can:solicitud.edit')->name('solicitud.update');
Route::delete('solicitud/{solicitud}', [SolicitudController::class, 'destroy'])->middleware('can:solicitud.delete')->name('solicitud.destroy');
Route::get('solicitud/{solicitud}/aprobar', [SolicitudController::class, 'aprobar'])->middleware('can:jefe-red')->name('solicitud.aprobar');
Route::post('solicitud/{solicitud}/rechazar', [SolicitudController::class, 'rechazar'])->middleware('can:jefe-red')->name('solicitud.rechazar');
Route::get('Solicitudes_rechazadas', [SolicitudController::class, 'reject'])->middleware('can:jefe-red')->name('solicitud.reject');
Route::get('solicitud/{solicitud}/reporte_rechazado', [SolicitudController::class, 'PDF_rechazado'])->middleware('can:jefe-red')->name('solicitud.PDFrechazado');
// Crud solicitud

// Route::resource('informes', InformeController::class);
Route::get('Informes', [InformeController::class, 'index'])->middleware('can:informes.index')->name('informes.index');
Route::get('Informes/autorizados', [InformeController::class, 'autorizado'])->name('informes.autorizado');
Route::get('Informes/registrar_informes', [InformeController::class, 'create'])->middleware('can:informes.create')->name('informes.create');
Route::post('Informes/registrar_informe', [InformeController::class, 'store'])->middleware('can:informes.create')->name('informes.store');
Route::get('Informes/{informe}/edit', [InformeController::class, 'edit'])->middleware('can:informes.edit')->name('informes.edit');
Route::get('Informes/{informe}/show', [InformeController::class, 'show'])->name('informes.show');
Route::put('Informes/{informe}', [InformeController::class, 'update'])->middleware('can:informes.edit')->name('informes.update');
Route::get('PDF/{informe}/PDFinforme', [PDFController::class, 'PDF'])->name('descargarPDF.informe');
Route::delete('Informes/{Informe}', [InformeController::class, 'destroy'])->name('informes.destroy');
Route::get('Informes/{informe}/registrar_material', [InformeController::class, 'registrar_material'])->name('informes.registrar_material');
Route::get('Informes/{Informe}/autorizar', [InformeController::class, 'autorizar'])->middleware('can:jefe-red')->name('informes.autorizar');
Route::get('Informes/{informe}/rechazar', [InformeController::class, 'no_autorizar'])->middleware('can:jefe-red')->name('informes.no_autorizar');
Route::get('Informes/{informe}/firmar', [InformeController::class, 'firmar_informe'])->middleware('can:jefe-red')->name('informes.firmar');
// CRUD MATERIALES
Route::resource('materials', MaterialController::class)->names('materials');
// Asigacion de materiales a los informes´
Route::resource('material_informe', Materials_informesController::class)->names('material_informe');
Route::get('PDF/{informe}/PDFpedido', [PDFController::class, 'PDF_pedido'])->name('pedidoPDF.informe');
Route::get('PDF/{informe}/PDFreporte_ampliacion', [PDFController::class, 'PDF_informe_material'])->name('reportePDF.informe_material');

// Asigacion de Solicitudes a Inspectores
Route::resource('cronograma', CronogramaController::class)->names('cronograma');
Route::get('Cronograma/registro_cronograma', [CronogramaController::class, 'mostrar'])->name('cronograma.reporte');
Route::get('PDF/{cronograma}/{user_id?}/PDFcronograma', [PDFController::class, 'PDF_cronograma'])->name('descargarPDF.cronograma');

//___________________________________DESCARGO DE MATERIALES____________________________________________________________________ 
Route::resource('descargo', DescargoController::class)->names('descargo'); //Metodo index
// APORTE MATERIAL VECINOS
Route::get('Descargos/{descargo}/{fecha_descargo?}/{valor?}/mostrar_aportes_v', [DescargoController::class, 'mostrar_aportes_v'])->name('descargo.mostrar_aportes_v');
Route::get('Descargos/{descargo}/{fecha_descargo?}/{valor?}/crear_aportes_v', [DescargoController::class, 'crear_aport_v'])->name('descargo.crear_aport_v');
Route::post('Descargos/registrar_aporte_v', [DescargoController::class, 'registrar_aporte_v'])->name('descargo.registrar_aporte_v');
Route::delete('Aporte_eliminar/{descargo}/{fecha_descargo?}/{valor?}', [DescargoController::class, 'eliminar_aporte'])->name('descargo.eliminar_aporte');
// ----------------------------------------------------------------------------------------------------
// Actividades del computo de elapas y vecinos
Route::resource('actividad', ActividadController::class)->names('actividad');
// ___________________________________________________________________________________________________________________-
Route::get('Descargos/{descargo}/{fecha_descargo?}/{valor?}/mostrar_computo_e', [DescargoController::class, 'mostrar_computos_e'])->name('descargo.mostrar_computo_e');
Route::get('Descargos/{descargo}/{fecha_descargo?}/{valor?}/crear_computo_e', [DescargoController::class, 'crear_computo_e'])->name('descargo.crear_computo_e');
Route::post('Descargos/registrar_computo_e', [DescargoController::class, 'registrar_computo_e'])->name('descargo.registrar_computo_e');
Route::delete('Computo_eliminar/{descargo}/{fecha_descargo?}/{valor?}', [DescargoController::class, 'eliminar_computo_e'])->name('descargo.eliminar_computo_e');