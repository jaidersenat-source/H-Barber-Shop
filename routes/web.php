<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PersonalController;
use App\Http\Controllers\Admin\SedeController;
use App\Http\Controllers\Admin\DisponibilidadController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\ServicioController;
use App\Http\Controllers\Admin\ProductoController;
use App\Http\Controllers\Admin\TurnoController;
use App\Http\Controllers\Admin\FidelizacionController;
use App\Http\Controllers\Admin\FacturaController;
use App\Http\Controllers\Admin\FacturaDetalleController;
use App\Http\Controllers\Admin\CRMClienteController;
use App\Http\Controllers\Auth\ResetPasswordController;


Route::get('/', fn () => view('welcome'))->name('welcome');



// Ruta comodín para compatibilidad: redirige /dashboard según rol
Route::get('/dashboard', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }

     $user = Auth::user();

    if ($user->rol === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    
    return redirect()->route('barbero.dashboard');
})->name('dashboard');
// LOGIN / LOGOUT
// ----------------------
Route::get('/login', [LoginController::class, 'loginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:5,1')->name('login.process');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rutas de registro (barbero se registra por su cuenta; debe existir `persona` previa)
Route::get('/register', [LoginController::class, 'registerForm'])->name('register.form');
Route::post('/register', [LoginController::class, 'register'])->name('register');

// Recuperación de contraseña
use App\Http\Controllers\Auth\ForgotPasswordController;
Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');

// ----------------------
// PANEL ADMINISTRADOR
// ----------------------
Route::middleware(['auth', 'admin', 'active'])->group(function () {

    Route::get('/admin/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::post('/admin/logout', [LoginController::class, 'logout'])
        ->name('admin.logout');
    
    // (El registro de usuarios lo realiza el barbero); las rutas públicas están declaradas fuera
        
        // Usuarios (barberos) - activación
        Route::get('/admin/usuarios', [UsuarioController::class, 'index'])->name('admin.usuarios')->middleware('admin');
        Route::post('/admin/usuarios/{id}/activar', [UsuarioController::class, 'activate'])->name('admin.usuarios.activar')->middleware('admin');
            Route::post('/admin/notifications/{id}/leer', [NotificationController::class, 'markAsRead'])->name('admin.notifications.read')->middleware('admin');
});

// Desactivar usuario (admin/personal)
Route::post('admin/usuarios/{usuario_id}/desactivar', [\App\Http\Controllers\Admin\PersonalController::class, 'desactivarUsuario'])->name('admin.usuarios.desactivar');


// ----------------------
// PANEL BARBERO
// ----------------------


Route::middleware(['auth', 'barbero', 'active'])->group(function () {
    Route::get('/barbero/dashboard', [\App\Http\Controllers\Barbero\DashboardController::class, 'index'])->name('barbero.dashboard');

    // Horario semanal solo lectura
    Route::get('/barbero/horario', [\App\Http\Controllers\Barbero\HorarioController::class, 'index'])->name('barbero.horario');
    // Turnos de la semana
    Route::get('/barbero/turnos', [\App\Http\Controllers\Barbero\TurnoController::class, 'index'])->name('barbero.turnos');
    Route::get('/barbero/turnos/crear', [\App\Http\Controllers\Barbero\TurnoController::class, 'create'])->name('barbero.turnos.create');
    Route::post('/barbero/turnos/guardar', [\App\Http\Controllers\Barbero\TurnoController::class, 'store'])->name('barbero.turnos.store');
    Route::post('/barbero/turnos/{id}/estado', [\App\Http\Controllers\Barbero\TurnoController::class, 'updateEstado'])->name('barbero.turnos.estado');
    Route::get('/barbero/turnos/available', [\App\Http\Controllers\Barbero\TurnoController::class, 'available'])->name('barbero.turnos.available');

    // Perfil de barbero
    Route::get('/barbero/perfil', [\App\Http\Controllers\Barbero\PerfilController::class, 'show'])->name('barbero.perfil.show');
    Route::put('/barbero/perfil', [\App\Http\Controllers\Barbero\PerfilController::class, 'update'])->name('barbero.perfil.update');
});






Route::middleware('auth')->group(function () {

    // Barberos / Personal
    Route::get('/admin/personal', [PersonalController::class, 'index'])->name('personal.index');
    Route::get('/admin/personal/crear', [PersonalController::class, 'create'])->name('personal.create');
    Route::post('/admin/personal/guardar', [PersonalController::class, 'store'])->name('personal.store');
});
// Sedes
Route::middleware('auth')->group(function () {

    Route::get('/admin/sedes', [SedeController::class, 'index'])->name('sedes.index');
    Route::get('/admin/sedes/crear', [SedeController::class, 'create'])->name('sedes.create');
    Route::post('/admin/sedes', [SedeController::class, 'store'])->name('sedes.store');

    Route::get('/admin/sedes/{id}/editar', [SedeController::class, 'edit'])->name('sedes.edit');
    Route::put('/admin/sedes/{id}', [SedeController::class, 'update'])->name('sedes.update');

    Route::delete('/admin/sedes/{id}', [SedeController::class, 'destroy'])->name('sedes.destroy');
    
});
// Disponibilidad de Barberos
Route::prefix('admin')->middleware('auth')->group(function () {

    Route::get('/disponibilidad', [DisponibilidadController::class, 'index'])->name('disponibilidad.index');

     // formulario semanal
   
    Route::post('/disponibilidad/guardar-semanal', [DisponibilidadController::class, 'storeWeekly'])->name('disponibilidad.storeWeekly');
    Route::get('/disponibilidad/por-fecha', [DisponibilidadController::class, 'byDate'])->name('disponibilidad.byDate');


    Route::get('/disponibilidad/crear', [DisponibilidadController::class, 'create'])->name('disponibilidad.create');
    Route::post('/disponibilidad/guardar', [DisponibilidadController::class, 'store'])->name('disponibilidad.store');
    Route::get('/disponibilidad/{id}/editar', [DisponibilidadController::class, 'edit'])->name('disponibilidad.edit');
    Route::post('/disponibilidad/{id}/actualizar', [DisponibilidadController::class, 'update'])->name('disponibilidad.update');
    Route::delete('/disponibilidad/{id}/eliminar', [DisponibilidadController::class, 'destroy'])->name('disponibilidad.destroy');

});

// Servicios
Route::prefix('admin')->middleware(['auth:usuario'])->group(function () {

    Route::resource('servicios', ServicioController::class);

});

// Productos
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::resource('productos', ProductoController::class)
        ->names([
            'index' => 'productos.index',
            'create' => 'productos.create',
            'store' => 'productos.store',
            'show' => 'productos.show',
            'edit' => 'productos.edit',
            'update' => 'productos.update',
            'destroy' => 'productos.destroy',
        ]);
});


// Turnos

Route::middleware(['auth','admin'])->prefix('admin')->group(function() {
    Route::get('turnos', [TurnoController::class, 'index'])->name('turnos.index');
    Route::get('turnos/crear', [TurnoController::class, 'create'])->name('turnos.create'); // vista calendario
    Route::post('turnos/guardar', [TurnoController::class, 'store'])->name('turnos.store');


    // Endpoints AJAX
    Route::get('api/available', [TurnoController::class, 'availableByDate'])->name('turnos.available');
    // Buscar datos de turno por cédula (AJAX)
    Route::get('api/turnos/buscar-cedula/{cedula}', [TurnoController::class, 'buscarPorCedula'])->name('turnos.buscarCedula');

    Route::get('turnos', [TurnoController::class, 'index'])->name('turnos.index');
    Route::post('turnos/{id}/cancelar', [TurnoController::class, 'cancel'])->name('turnos.cancel');
    Route::post('turnos/{id}/realizar', [TurnoController::class, 'complete'])->name('turnos.complete');
    Route::put('turnos/{id}/reprogramar', [TurnoController::class, 'reprogramar'])->name('turnos.reprogramar');

});

// Fidelización

Route::prefix('admin')->middleware('auth')->group(function() {

    Route::get('/fidelizacion', [FidelizacionController::class, 'index'])
        ->name('fidelizacion.index');

    Route::get('/fidelizacion/{id}', [FidelizacionController::class, 'show'])
        ->name('fidelizacion.show');

    // Configuración global
    Route::get('/fidelizacion-config', [FidelizacionController::class, 'config'])->name('fidelizacion.config');
    Route::post('/fidelizacion-config', [FidelizacionController::class, 'updateConfig'])->name('fidelizacion.config.update');

});

// Facturas
Route::prefix('admin')->group(function () {
    Route::get('facturas', [FacturaController::class, 'index'])->name('factura.index');
    Route::get('facturas/create/{tur_id}', [FacturaController::class, 'create'])->name('factura.create');
    Route::post('facturas', [FacturaController::class, 'store'])->name('factura.store');
    Route::get('facturas/{fac_id}', [FacturaController::class, 'show'])->name('facturas.show');
    Route::get('facturas/{fac_id}/detalle', [App\Http\Controllers\Admin\FacturaController::class, 'detalle'])->name('facturas.detalle');
    Route::post('facturas/{fac_id}/detalle', [App\Http\Controllers\Admin\FacturaDetalleController::class, 'store'])->name('facturadetalle.store');
    Route::delete('facturas/detalle/{facdet_id}', [App\Http\Controllers\Admin\FacturaDetalleController::class, 'destroy'])->name('facturadetalle.destroy');
    Route::delete('facturas/{fac_id}', [FacturaController::class, 'destroy'])->name('facturas.destroy');
    Route::get('facturas/create-from-turno/{tur_id}', [App\Http\Controllers\Admin\FacturaController::class, 'create'])->name('facturas.createFromTurno');
    Route::get('admin/facturas/{fac_id}/pdf', [App\Http\Controllers\Admin\FacturaController::class, 'descargarPdf'])->name('facturas.pdf');
});

// CRM Clientes
Route::middleware('auth')->group(function() {

    Route::get('/admin/crm/clientes', 
        [CRMClienteController::class, 'index'])
        ->name('crm.clientes');

    Route::get('/admin/crm/clientes/export-pdf', [CRMClienteController::class, 'exportPdf'])
        ->name('crm.clientes.exportPdf');

    Route::get('/admin/crm/clientes/{cedula}', 
        [CRMClienteController::class, 'show'])
        ->name('crm.clientes.detalle');

});

// Perfil de usuario
Route::get('admin/perfil', [\App\Http\Controllers\Admin\PerfilController::class, 'show'])->name('perfil.show');
Route::put('admin/perfil', [\App\Http\Controllers\Admin\PerfilController::class, 'update'])->name('perfil.update');

// Reporte General
Route::middleware(['auth', 'admin', 'active'])->group(function () {
    Route::get('/admin/reportes/general', [\App\Http\Controllers\Admin\ReporteGeneralController::class, 'index'])->name('admin.reportes.general');
    Route::get('/admin/reportes/general/pdf', [\App\Http\Controllers\Admin\ReporteGeneralController::class, 'exportarPdf'])->name('admin.reportes.general.pdf');
    Route::get('/admin/reportes/general/excel', [\App\Http\Controllers\Admin\ReporteGeneralController::class, 'exportarExcel'])->name('admin.reportes.general.excel');
});

Route::get('/servicios', function () {
    return view('Home.Servicio');
})->name('servicios');

Route::get('/productos', function () {
    return view('Home.Productos');
})->name('productos');

Route::get('/nosotros', fn () => view('Home.Nosotros'))
    ->name('nosotros');

Route::get('/contacto', fn () => view('Home.Contacto'))
    ->name('contacto');

Route::get('/fidelizacion', fn () => view('Home.Fidelizacion'))
    ->name('fidelizacion');

Route::get('/agendar', fn () => view('Home.Agendar'))
    ->name('agendar');
