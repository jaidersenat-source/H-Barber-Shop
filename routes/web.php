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
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Admin\MembresiaController;
use App\Http\Controllers\HomeController;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('welcome');

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

// El registro público está deshabilitado: los barberos son dados de alta por el administrador.
Route::get('/register', fn() => redirect()->route('login')->with('info', 'El registro público no está disponible. Contacta al administrador.'))->name('register.form');
Route::post('/register', fn() => redirect()->route('login'))->name('register');

// Recuperación de contraseña
use App\Http\Controllers\Auth\ForgotPasswordController;
Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->middleware('throttle:3,1')->name('password.email');

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
Route::post('admin/usuarios/{usuario_id}/desactivar', [\App\Http\Controllers\Admin\PersonalController::class, 'desactivarUsuario'])->name('admin.usuarios.desactivar')->middleware(['auth', 'admin']);


// ----------------------
// PANEL BARBERO
// ----------------------


// Términos CRM (primer acceso barbero) — sin middleware de términos para no buclear
Route::middleware(['auth', 'barbero', 'active'])->group(function () {
    Route::get('/barbero/terminos-crm', [\App\Http\Controllers\Barbero\TerminosCRMController::class, 'show'])
        ->name('barbero.crm.terminos');
    Route::post('/barbero/terminos-crm/aceptar', [\App\Http\Controllers\Barbero\TerminosCRMController::class, 'aceptar'])
        ->name('barbero.crm.terminos.aceptar');
});

// Cambio de contraseña forzado (solo 'auth' + 'barbero', sin 'active' ni forzar_cambio_password para no buclear)
Route::middleware(['auth', 'barbero'])->group(function () {
    Route::get('/barbero/cambiar-password', [\App\Http\Controllers\Barbero\PasswordController::class, 'show'])->name('barbero.cambiar-password');
    Route::post('/barbero/cambiar-password', [\App\Http\Controllers\Barbero\PasswordController::class, 'update'])->name('barbero.cambiar-password.update');
});

Route::middleware(['auth', 'barbero', 'active', 'forzar_cambio_password', 'aceptar_terminos_crm'])->group(function () {
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
    // Subir/guardar foto de perfil
    Route::post('/barbero/perfil/foto', [\App\Http\Controllers\Barbero\PerfilController::class, 'guardarFoto'])->name('barbero.perfil.guardarFoto');
});






Route::middleware(['auth', 'admin', 'active'])->group(function () {

    // Barberos / Personal
    Route::get('/admin/personal', [PersonalController::class, 'index'])->name('personal.index');
    Route::get('/admin/personal/crear', [PersonalController::class, 'create'])->name('personal.create');
    Route::post('/admin/personal/guardar', [PersonalController::class, 'store'])->name('personal.store');
});
// Sedes
Route::middleware(['auth', 'admin', 'active'])->group(function () {

    Route::get('/admin/sedes', [SedeController::class, 'index'])->name('sedes.index');
    Route::get('/admin/sedes/crear', [SedeController::class, 'create'])->name('sedes.create');
    Route::post('/admin/sedes', [SedeController::class, 'store'])->name('sedes.store');

    Route::get('/admin/sedes/{id}/editar', [SedeController::class, 'edit'])->name('sedes.edit');
    Route::put('/admin/sedes/{id}', [SedeController::class, 'update'])->name('sedes.update');

    Route::delete('/admin/sedes/{id}', [SedeController::class, 'destroy'])->name('sedes.destroy');
    
});
// Disponibilidad de Barberos
Route::prefix('admin')->middleware(['auth', 'admin', 'active'])->group(function () {

    Route::get('/disponibilidad', [DisponibilidadController::class, 'index'])->name('disponibilidad.index');

     // formulario semanal
   
    Route::post('/disponibilidad/guardar-semanal', [DisponibilidadController::class, 'storeWeekly'])->name('disponibilidad.storeWeekly');
    Route::get('/disponibilidad/por-fecha', [DisponibilidadController::class, 'byDate'])->name('disponibilidad.byDate');


    Route::get('/disponibilidad/crear', [DisponibilidadController::class, 'create'])->name('disponibilidad.create');
    Route::post('/disponibilidad/guardar', [DisponibilidadController::class, 'store'])->name('disponibilidad.store');
    Route::get('/disponibilidad/{id}/editar', [DisponibilidadController::class, 'edit'])->name('disponibilidad.edit');
    Route::post('/disponibilidad/{id}/actualizar', [DisponibilidadController::class, 'update'])->name('disponibilidad.update');
    Route::delete('/disponibilidad/{id}', [DisponibilidadController::class, 'destroy'])->name('disponibilidad.destroy');

});

// Servicios
Route::prefix('admin')->middleware(['auth', 'admin', 'active'])->group(function () {

    Route::resource('servicios', ServicioController::class);

   

});

// Productos y Kits (panel admin)
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    // Index de productos y kits con parámetro tipo
    Route::get('productos', [ProductoController::class, 'index'])->name('productos.index');
    // Alternar entre productos y kits en la misma vista
    Route::get('productos/tipo/{tipo}', [ProductoController::class, 'index'])->name('productos.tipo');

    // CRUD productos
    Route::get('productos/create', [ProductoController::class, 'create'])->name('productos.create');
    Route::post('productos', [ProductoController::class, 'store'])->name('productos.store');
    Route::get('productos/{producto}/edit', [ProductoController::class, 'edit'])->name('productos.edit');
    Route::put('productos/{producto}', [ProductoController::class, 'update'])->name('productos.update');
    Route::delete('productos/{producto}', [ProductoController::class, 'destroy'])->name('productos.destroy');

    
});

// Turnos

Route::middleware(['auth','admin','active'])->prefix('admin')->group(function() {
    Route::get('turnos', [TurnoController::class, 'index'])->name('turnos.index');
    Route::get('turnos/crear', [TurnoController::class, 'create'])->name('turnos.create'); // vista calendario
    Route::post('turnos/guardar', [TurnoController::class, 'store'])->name('turnos.store');


    // Endpoints AJAX
    Route::get('api/available', [TurnoController::class, 'availableByDate'])->name('turnos.available');
    // Buscar datos de turno por cédula (AJAX)
    Route::get('api/turnos/buscar-cedula/{cedula}', [TurnoController::class, 'buscarPorCedula'])->name('turnos.buscarCedula');

    Route::post('turnos/{id}/cancelar', [TurnoController::class, 'cancel'])->name('turnos.cancel');
    Route::post('turnos/{id}/realizar', [TurnoController::class, 'complete'])->name('turnos.complete');
    Route::put('turnos/{id}/reprogramar', [TurnoController::class, 'reprogramar'])->name('turnos.reprogramar');
    
    // Rutas de pago
    Route::post('turnos/{id}/confirmar-pago', [TurnoController::class, 'confirmPayment'])->name('turnos.confirm-payment');
    Route::post('turnos/{id}/rechazar-pago', [TurnoController::class, 'rejectPayment'])->name('turnos.reject-payment');

    // Gestión de QR Codes
    Route::get('qr-management', [TurnoController::class, 'qrManagement'])->name('admin.qr.management');
    Route::post('qr/upload', [TurnoController::class, 'uploadQR'])->name('admin.qr.upload');

});

// Fidelización

Route::prefix('admin')->middleware(['auth', 'admin', 'active'])->group(function() {

    Route::get('/fidelizacion', [FidelizacionController::class, 'index'])
        ->name('fidelizacion.index');

    Route::get('/fidelizacion/{id}', [FidelizacionController::class, 'show'])
        ->name('fidelizacion.show');

    // Configuración global
    Route::get('/fidelizacion-config', [FidelizacionController::class, 'config'])->name('fidelizacion.config');
    Route::post('/fidelizacion-config', [FidelizacionController::class, 'updateConfig'])->name('fidelizacion.config.update');

});

// Facturas
Route::prefix('admin')->middleware(['auth', 'admin', 'active'])->group(function () {
    Route::get('facturas', [FacturaController::class, 'index'])->name('factura.index');
    Route::get('facturas/create/{tur_id}', [FacturaController::class, 'create'])->name('factura.create');
    Route::post('facturas', [FacturaController::class, 'store'])->name('factura.store');
    Route::get('facturas/{fac_id}', [FacturaController::class, 'show'])->name('facturas.show');
    Route::get('facturas/{fac_id}/detalle', [App\Http\Controllers\Admin\FacturaController::class, 'detalle'])->name('facturas.detalle');
    Route::post('facturas/{fac_id}/detalle', [App\Http\Controllers\Admin\FacturaDetalleController::class, 'store'])->name('facturadetalle.store');
    Route::delete('facturas/detalle/{facdet_id}', [App\Http\Controllers\Admin\FacturaDetalleController::class, 'destroy'])->name('facturadetalle.destroy');
    Route::post('facturas/{fac_id}/producto', [FacturaDetalleController::class, 'storeProducto'])
    ->name('facturadetalle.storeProducto');
    Route::delete('facturas/{fac_id}', [FacturaController::class, 'destroy'])->name('facturas.destroy');
    Route::get('facturas/create-from-turno/{tur_id}', [App\Http\Controllers\Admin\FacturaController::class, 'create'])->name('facturas.createFromTurno');
    Route::get('facturas/{fac_id}/pdf', [App\Http\Controllers\Admin\FacturaController::class, 'descargarPdf'])->name('facturas.pdf');
});

// CRM Clientes
Route::middleware(['auth', 'admin', 'active'])->group(function() {

    Route::get('/admin/crm/clientes', 
        [CRMClienteController::class, 'index'])
        ->name('crm.clientes');


    Route::get('/admin/crm/clientes/export-excel', [CRMClienteController::class, 'exportExcel'])
        ->name('crm.clientes.exportExcel');
    Route::get('/admin/crm/clientes/export-pdf', [CRMClienteController::class, 'exportPdf'])
        ->name('crm.clientes.exportPdf');

    Route::get('/admin/crm/clientes/{cedula}', 
        [CRMClienteController::class, 'show'])
        ->name('crm.clientes.detalle');

});

// Perfil de usuario
Route::middleware(['auth', 'admin', 'active'])->group(function () {
    Route::get('admin/perfil', [\App\Http\Controllers\Admin\PerfilController::class, 'show'])->name('perfil.show');
    Route::put('admin/perfil', [\App\Http\Controllers\Admin\PerfilController::class, 'update'])->name('perfil.update');

    // Información Personal y Configuración
    Route::get('admin/perfil/informacion', [\App\Http\Controllers\Admin\PerfilController::class, 'informacion'])->name('admin.perfil.informacion');
    Route::put('admin/perfil/informacion', [\App\Http\Controllers\Admin\PerfilController::class, 'updateInformacion'])->name('admin.perfil.informacion.update');
    Route::put('admin/perfil/password', [\App\Http\Controllers\Admin\PerfilController::class, 'updatePassword'])->name('admin.perfil.password.update');
    Route::get('admin/perfil/configuracion', [\App\Http\Controllers\Admin\PerfilController::class, 'index'])->name('admin.configuracion');
    Route::post('admin/perfil/configuracion', [\App\Http\Controllers\Admin\PerfilController::class, 'update'])->name('admin.configuracion.update');
    // Ruta para guardar foto de perfil
    Route::post('admin/perfil/guardar-foto', [\App\Http\Controllers\Admin\PerfilController::class, 'guardarFoto'])->name('perfil.guardarFoto');
    // Ruta para eliminar foto de perfil
    Route::post('admin/perfil/eliminar-foto', [\App\Http\Controllers\Admin\PerfilController::class, 'updateFoto'])->name('perfil.updateFoto');

    // Manual de usuario accesible
    Route::get('admin/perfil/manual-usuario', [\App\Http\Controllers\Admin\PerfilController::class, 'manualUsuario'])->name('admin.manual.usuario');
    Route::get('admin/perfil/manual-usuario/pdf', [\App\Http\Controllers\Admin\PerfilController::class, 'manualUsuarioPdf'])->name('admin.manual.usuario.pdf');

    // Configuraciones Generales del Sitio
    Route::get('admin/configuraciones-generales', [\App\Http\Controllers\Admin\PerfilController::class, 'configuracionesGenerales'])->name('admin.configuraciones.generales');
    Route::put('admin/configuraciones-generales', [\App\Http\Controllers\Admin\PerfilController::class, 'updateConfiguracionesGenerales'])->name('admin.configuraciones.generales.update');
});
// Reporte General
Route::middleware(['auth', 'admin', 'active'])->group(function () {
    Route::get('/admin/reportes/general', [\App\Http\Controllers\Admin\ReporteGeneralController::class, 'index'])->name('admin.reportes.general');
    Route::get('/admin/reportes/general/pdf', [\App\Http\Controllers\Admin\ReporteGeneralController::class, 'exportarPdf'])->name('admin.reportes.general.pdf');
    Route::get('/admin/reportes/general/excel', [\App\Http\Controllers\Admin\ReporteGeneralController::class, 'exportarExcel'])->name('admin.reportes.general.excel');

     // ← AGREGAR ESTAS DOS:
    Route::get('/admin/reportes/productos/pdf', [\App\Http\Controllers\Admin\ReporteGeneralController::class, 'exportarProductosPdf'])->name('admin.reportes.productos.pdf');
    Route::get('/admin/reportes/productos/excel', [\App\Http\Controllers\Admin\ReporteGeneralController::class, 'exportarProductosExcel'])->name('admin.reportes.productos.excel');
});

Route::get('/servicios', [\App\Http\Controllers\HomeController::class, 'servicios'])->name('servicios');



Route::get('/productos', [\App\Http\Controllers\HomeController::class, 'productos'])->name('productos');

Route::get('/nosotros', [\App\Http\Controllers\HomeController::class, 'nosotros'])
    ->name('nosotros');

Route::get('/contacto', [\App\Http\Controllers\HomeController::class, 'contacto'])->name('contacto');

// Políticas legales — Ley 1581/2012, privacidad, términos y condiciones
Route::get('/politicas', function () {
    return view('Home.Politicas');
})->name('politicas');

Route::get('/fidelizacion', [\App\Http\Controllers\HomeController::class, 'consultarFidelizacion'])->name('fidelizacion');
Route::post('/fidelizacion/consultar', [\App\Http\Controllers\HomeController::class, 'consultarFidelizacion'])->name('fidelizacion.consultar');

Route::get('/agendar', [\App\Http\Controllers\HomeController::class, 'agendar'])
    ->name('agendar');
Route::post('/agendar/horarios-disponibles', [\App\Http\Controllers\HomeController::class, 'obtenerHorariosDisponibles'])
    ->middleware('throttle:consulta-horarios')
    ->name('agendar.horarios');
Route::post('/agendar/check-barber', [\App\Http\Controllers\HomeController::class, 'checkBarberAvailability'])
    ->name('agendar.checkBarber');
// Descargar términos (PDF)
Route::get('/terminos/descargar', [\App\Http\Controllers\TerminosController::class, 'download'])->name('terminos.download');
// Vista pública de términos (fallback para ver en HTML)
Route::get('/terminos', function () {
    return view('terms.terms');
})->name('terminos.view');
Route::post('/agendar-cita', [\App\Http\Controllers\HomeController::class, 'agendarCita'])
    ->middleware('throttle:agendar')
    ->name('agendar.cita');

// QR Codes para pagos (con rate limiting)
Route::get('/qr/nequi', [\App\Http\Controllers\HomeController::class, 'generateNequiQR'])
    ->middleware('throttle:20,1')
    ->name('generate.nequi.qr');
Route::get('/qr/nequi-alt', [\App\Http\Controllers\HomeController::class, 'generateNequiQRAlternative'])
    ->middleware('throttle:20,1')
    ->name('generate.nequi.qr.alternative');
Route::get('/qr/daviplata', [\App\Http\Controllers\HomeController::class, 'generateDaviplataQR'])
    ->middleware('throttle:20,1')
    ->name('generate.daviplata.qr');
Route::get('/payment-info', [\App\Http\Controllers\HomeController::class, 'getPaymentInfo'])
    ->middleware('throttle:20,1')
    ->name('payment.info');

// Rutas de desarrollo/debug — solo disponibles en entorno local
if (app()->environment('local')) {
    Route::get('/test-data', function () {
        $turnos = \App\Models\Turno::with(['servicio', 'disponibilidad.persona'])->latest()->take(5)->get();
        
        return response()->json([
            'total_turnos' => \App\Models\Turno::count(),
            'ultimos_turnos' => $turnos,
            'servicios' => \App\Models\Servicio::all(),
            'barberos' => \App\Models\Personal_Sede::with('persona')->where('persede_estado', 'activo')->get()
        ]);
    });
}
Route::post('/contacto/enviar', [\App\Http\Controllers\HomeController::class, 'enviarContacto'])->middleware('throttle:contacto')->name('contacto.enviar');
// ----------------------
// BLOG PÚBLICO (SEO)
// ----------------------
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/categoria/{category}', [BlogController::class, 'category'])->name('blog.category');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Comentarios en artículos
Route::post('/blog/{article:id}/comentario', [CommentController::class, 'store'])->middleware('throttle:comentarios')->name('comments.store');

// ----------------------
// ADMINISTRACIÓN DEL BLOG
// ----------------------
Route::middleware(['auth', 'admin', 'active'])->prefix('admin')->group(function () {
    // Gestión de artículos
    Route::get('/blog', [\App\Http\Controllers\Admin\ArticleController::class, 'index'])->name('admin.blog.index');
    Route::get('/blog/crear', [\App\Http\Controllers\Admin\ArticleController::class, 'create'])->name('admin.blog.create');
    Route::post('/blog', [\App\Http\Controllers\Admin\ArticleController::class, 'store'])->name('admin.blog.store');
    Route::get('/blog/{article}/editar', [\App\Http\Controllers\Admin\ArticleController::class, 'edit'])->name('admin.blog.edit');
    Route::put('/blog/{article}', [\App\Http\Controllers\Admin\ArticleController::class, 'update'])->name('admin.blog.update');
    Route::delete('/blog/{article}', [\App\Http\Controllers\Admin\ArticleController::class, 'destroy'])->name('admin.blog.destroy');
    Route::post('/blog/{article}/toggle-status', [\App\Http\Controllers\Admin\ArticleController::class, 'toggleStatus'])->name('admin.blog.toggle-status');
    Route::get('/blog/{article}/preview', [\App\Http\Controllers\Admin\ArticleController::class, 'preview'])->name('admin.blog.preview');

    // Moderación de comentarios
    Route::get('/comentarios', [\App\Http\Controllers\Admin\CommentController::class, 'index'])->name('admin.comments.index');
    Route::post('/comentarios/{comment}/aprobar', [\App\Http\Controllers\Admin\CommentController::class, 'approve'])->name('admin.comments.approve');
    Route::post('/comentarios/{comment}/rechazar', [\App\Http\Controllers\Admin\CommentController::class, 'reject'])->name('admin.comments.reject');
    Route::delete('/comentarios/{comment}', [\App\Http\Controllers\Admin\CommentController::class, 'destroy'])->name('admin.comments.destroy');
    Route::post('/comentarios/bulk-approve', [\App\Http\Controllers\Admin\CommentController::class, 'bulkApprove'])->name('admin.comments.bulk-approve');
    Route::post('/comentarios/bulk-reject', [\App\Http\Controllers\Admin\CommentController::class, 'bulkReject'])->name('admin.comments.bulk-reject');
    Route::post('/comentarios/bulk-destroy', [\App\Http\Controllers\Admin\CommentController::class, 'bulkDestroy'])->name('admin.comments.bulk-destroy');
});

// ── GASTOS ────────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'admin', 'active'])->prefix('admin')->name('admin.')->group(function () {

    // Gastos
    Route::resource('gastos', \App\Http\Controllers\Admin\GastoController::class)
         ->names('gastos');

    Route::get('gastos-export/excel',
        [\App\Http\Controllers\Admin\GastoController::class, 'exportarExcel'])
        ->name('gastos.excel');

    Route::get('gastos-export/reporte-financiero',
        [\App\Http\Controllers\Admin\GastoController::class, 'reporteFinanciero'])
        ->name('gastos.reporte-financiero');

    // Categorías de gastos
    Route::resource('categorias-gastos', \App\Http\Controllers\Admin\CategoriaGastoController::class)
         ->names('categorias-gastos');
});

// ── ADMIN: Membresías ─────────────────────────────────────────────────────────
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {

    // CRUD principal (index, create, store, edit, update, destroy)
    Route::resource('membresias', MembresiaController::class);

    // Activar / desactivar visibilidad en sitio público
    Route::patch('membresias/{id}/toggle-activo', [MembresiaController::class, 'toggleActivo'])
        ->name('membresias.toggle-activo');

    // Ver todos los clientes con membresías
    Route::get('membresias-clientes', [MembresiaController::class, 'clientes'])
        ->name('membresias.clientes');

    // Asignar membresía a un cliente
    Route::post('membresias-clientes', [MembresiaController::class, 'asignarCliente'])
        ->name('membresias.clientes.asignar');

    // Cancelar membresía de un cliente
    Route::patch('membresias-clientes/{id}/cancelar', [MembresiaController::class, 'cancelarCliente'])
        ->name('membresias.clientes.cancelar');

   
});

  Route::get('/membresias', [HomeController::class, 'membresias'])->name('public.membresias');