import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // App principal
                'resources/css/app.css',
                'resources/js/app.js',

                // Layouts
                'resources/css/nav.css',
                'resources/css/footer.css',
                'resources/css/cookie-banner.css',
                'resources/css/accessibility.css',
                'resources/js/accessibility.js',
                'resources/css/Admin/layout.css',

                // Home
                'resources/css/Home/inicio.css',
                'resources/js/Home/inicio.js',
                'resources/css/Home/Agendar.css',
                'resources/js/Home/agendar.js',
                'resources/css/Home/Contacto.css',
                'resources/css/Home/fidelizacion.css',
                'resources/css/Home/membresias.css',
                'resources/css/Home/Nosotros.css',
                'resources/css/Home/Productos.css',
                'resources/css/Home/Servicio.css',
                'resources/css/Home/Politicas.css',

                // Auth
                'resources/css/auth/login.css',
                'resources/css/auth/email.css',
                'resources/css/auth/reset.css',
                'resources/css/auth/register.css',

                // Blog
                'resources/css/Blog/blog.css',
                'resources/css/Blog/index.css',
                'resources/css/Blog/show.css',
                'resources/css/Blog/admin/create.css',
                'resources/css/Blog/admin/edit.css',
                'resources/css/Blog/admin/index.css',
                'resources/css/Blog/admin/comentario.css',

                // Admin
                'resources/css/Admin/dashboard.css',
                'resources/css/Admin/manual-usuario.css',
                'resources/css/Admin/reportes.css',
                'resources/css/Admin/crm/crm.css',
                'resources/css/Admin/crm/detalle.css',
                'resources/css/Admin/dispo/create.css',
                'resources/css/Admin/dispo/edit.css',
                'resources/css/Admin/dispo/disponibilidad.css',
                'resources/css/Admin/factura/create.css',
                'resources/css/Admin/factura/detalle.css',
                'resources/css/Admin/factura/facturas.css',
                'resources/css/Admin/factura/show.css',
                'resources/css/Admin/fidi/fidelizacion.css',
                'resources/css/Admin/fidi/show.css',
                'resources/css/Admin/gastos/create.css',
                'resources/css/Admin/gastos/edit.css',
                'resources/css/Admin/gastos/gastos.css',
                'resources/css/Admin/membresias/clientes.css',
                'resources/css/Admin/membresias/create.css',
                'resources/css/Admin/membresias/membresia.css',
                'resources/css/Admin/config/config.css',
                'resources/css/Admin/config/redes.css',
                'resources/css/Admin/config/informacion.css',
                'resources/css/Admin/config/qr.css',
                'resources/css/Admin/personal/create.css',
                'resources/css/Admin/personal/personal.css',
                'resources/css/Admin/productos/create.css',
                'resources/css/Admin/productos/edit.css',
                'resources/css/Admin/productos/producto.css',
                'resources/css/Admin/sede/create.css',
                'resources/css/Admin/sede/edit.css',
                'resources/css/Admin/sede/sede.css',
                'resources/css/Admin/servicios/create.css',
                'resources/css/Admin/servicios/edit.css',
                'resources/css/Admin/servicios/servicio.css',
                'resources/css/Admin/turnos/create.css',
                'resources/css/Admin/turnos/turnos.css',
                'resources/js/Admin/perfil.js',
                'resources/js/Admin/personal.js',
                'resources/js/Admin/turnos.js',

                // Barberos
                'resources/css/Barberos/dashboard.css',
                'resources/css/Barberos/layout.css',
                'resources/css/Barberos/horarios.css',
                'resources/css/Barberos/configuracion.css',
                'resources/css/Barberos/turnos/create.css',
                'resources/css/Barberos/turnos/turnos.css',
                'resources/js/Barberos/perfil.js',
                'resources/js/Barberos/turnos.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});