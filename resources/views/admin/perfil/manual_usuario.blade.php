{{--
    Manual de Usuario Completo y Accesible - H Barber Shop
    Compatible con lectores de pantalla (NVDA, JAWS, VoiceOver)
    Navegable al 100% con teclado
--}}
@extends('admin.layout')

@section('title', 'Manual de Usuario')

@vite(['resources/css/Admin/manual-usuario.css'])

@section('content')

<div class="manual-usuario-container" role="document" aria-label="Manual de usuario completo del sistema H Barber Shop">

    {{-- Encabezado del manual --}}
    <header class="manual-header">
        <h1 id="manual-titulo">Manual de Usuario Completo - H Barber Shop</h1>
        <p class="manual-descripcion">
            Esta guía explica paso a paso todas las funciones del sistema de gestión de la barbería H Barber Shop.
            Está diseñada para ser completamente accesible, compatible con lectores de pantalla como NVDA, JAWS y VoiceOver,
            y se puede navegar únicamente con el teclado. Si usas un lector de pantalla, presiona la tecla H para saltar entre secciones.
        </p>

        {{-- Botón Escuchar Manual con Text-to-Speech --}}
        <button
            type="button"
            id="btn-escuchar-manual"
            class="btn-escuchar"
            aria-label="Escuchar el manual de usuario en voz alta"
            aria-pressed="false"
        >
            <span class="btn-escuchar-icono" aria-hidden="true">🔊</span>
            <span id="btn-escuchar-texto">Escuchar manual</span>
        </button>

        {{-- Botón Descargar Manual en PDF --}}
        <a
            href="{{ route('admin.manual.usuario.pdf') }}"
            class="btn-descargar-pdf"
            aria-label="Descargar el manual de usuario en formato PDF"
        >
            <span aria-hidden="true">📄</span> Descargar PDF
        </a>

        {{-- Enlace para volver a configuración --}}
        <a href="{{ route('admin.configuracion') }}" class="btn-volver" aria-label="Volver a la página de configuración">
            ← Volver a Configuración
        </a>
    </header>

    {{-- ============================================ --}}
    {{-- ÍNDICE DE CONTENIDO --}}
    {{-- ============================================ --}}
    <nav class="manual-nav" aria-label="Índice del manual de usuario">
        <h2 id="indice-titulo">Índice de contenido</h2>
        <ol aria-labelledby="indice-titulo">
            <li><a href="#seccion-introduccion">Introducción al sistema</a></li>
            <li><a href="#seccion-iniciar-sesion">Cómo iniciar sesión</a></li>
            <li><a href="#seccion-recuperar-contrasena">Cómo recuperar la contraseña</a></li>
            <li><a href="#seccion-dashboard">Panel principal (Dashboard)</a></li>
            <li><a href="#seccion-personal">Módulo de Personal (Barberos)</a></li>
            <li><a href="#seccion-sedes">Módulo de Sedes</a></li>
            <li><a href="#seccion-turnos">Módulo de Turnos (Citas)</a></li>
            <li><a href="#seccion-cancelar-reprogramar">Cancelar o reprogramar un turno</a></li>
            <li><a href="#seccion-pagos">Pagos y anticipos con QR</a></li>
            <li><a href="#seccion-disponibilidad">Módulo de Disponibilidad (Horarios)</a></li>
            <li><a href="#seccion-servicios">Módulo de Servicios y Combos</a></li>
            <li><a href="#seccion-productos">Módulo de Productos y Kits</a></li>
            <li><a href="#seccion-crm">Módulo CRM (Gestión de Clientes)</a></li>
            <li><a href="#seccion-fidelizacion">Módulo de Fidelización</a></li>
            <li><a href="#seccion-facturacion">Módulo de Facturación</a></li>
            <li><a href="#seccion-reportes">Módulo de Reportes</a></li>
            <li><a href="#seccion-blog">Módulo de Blog</a></li>
            <li><a href="#seccion-comentarios">Módulo de Comentarios</a></li>
            <li><a href="#seccion-membresias">Módulo de Membresías</a></li>
            <li><a href="#seccion-gastos">Módulo de Gastos</a></li>
            <li><a href="#seccion-perfil">Módulo de Perfil y Configuración de WhatsApp</a></li>
            <li><a href="#seccion-configuracion">Módulo de Configuración</a></li>
            <li><a href="#seccion-sitio-publico">Sitio web público</a></li>
            <li><a href="#seccion-panel-barbero">Panel del Barbero</a></li>
            <li><a href="#seccion-correos">Correos electrónicos automáticos</a></li>
            <li><a href="#seccion-atajos">Atajos de teclado</a></li>
            <li><a href="#seccion-lectores-pantalla">Uso con lectores de pantalla</a></li>
            <li><a href="#seccion-ayuda">Dónde pedir ayuda</a></li>
        </ol>
    </nav>

    {{-- ============================================ --}}
    {{-- CONTENIDO DEL MANUAL --}}
    {{-- ============================================ --}}
    <div id="manual-contenido" class="manual-contenido">

        {{-- ==============================
             SECCIÓN 1: INTRODUCCIÓN
             ============================== --}}
        <section id="seccion-introduccion" class="manual-seccion" aria-labelledby="titulo-introduccion">
            <h2 id="titulo-introduccion">1. Introducción al sistema</h2>
            <p>
                Bienvenido al manual de usuario de <strong>H Barber Shop</strong>.
                Este es un sistema completo de gestión para barbería que permite administrar todos los aspectos del negocio
                desde un navegador web.
            </p>
            <p>
                El sistema tiene tres tipos de usuarios:
            </p>
            <ul>
                <li><strong>Administrador:</strong> Tiene acceso completo a todos los módulos. Puede gestionar barberos, turnos, servicios, productos, facturación, reportes, el blog y toda la configuración del sistema.</li>
                <li><strong>Barbero:</strong> Tiene un panel más sencillo donde puede ver sus turnos de la semana, su horario y gestionar su perfil.</li>
                <li><strong>Visitante público:</strong> Cualquier persona que visite el sitio web puede ver los servicios, productos, agendar una cita, consultar su fidelización y leer el blog.</li>
            </ul>
            <p>
                El menú de navegación se encuentra en el lado izquierdo de la pantalla. Desde allí puedes acceder a cada módulo del sistema.
                En la parte inferior del menú encontrarás el enlace a <strong>Configuración</strong> y el botón para <strong>Cerrar sesión</strong>.
            </p>
            <p>
                Este manual describe cada módulo del sistema con instrucciones paso a paso.
                Si usas un lector de pantalla, puedes navegar entre las secciones usando la tecla <kbd>H</kbd>.
            </p>
        </section>

        {{-- ==============================
             SECCIÓN 2: INICIAR SESIÓN
             ============================== --}}
        <section id="seccion-iniciar-sesion" class="manual-seccion" aria-labelledby="titulo-iniciar-sesion">
            <h2 id="titulo-iniciar-sesion">2. Cómo iniciar sesión</h2>
            <p>
                Para ingresar al sistema necesitas tu nombre de usuario y tu contraseña.
                Sigue estos pasos:
            </p>
            <ol>
                <li>Abre el navegador web de tu computador o teléfono. Puede ser Google Chrome, Firefox, Microsoft Edge o Safari.</li>
                <li>Escribe la dirección del sistema en la barra de direcciones del navegador y presiona la tecla <kbd>Enter</kbd>.</li>
                <li>Cuando se cargue la página de inicio de sesión, busca el campo de texto con la etiqueta <strong>Correo electrónico</strong> o <strong>Usuario</strong>. Escribe allí tu dato de acceso.</li>
                <li>Presiona la tecla <kbd>Tab</kbd> para pasar al siguiente campo. Este campo tiene la etiqueta <strong>Contraseña</strong>. Escribe allí tu contraseña.</li>
                <li>Presiona la tecla <kbd>Tab</kbd> nuevamente para llegar al botón <strong>Iniciar sesión</strong>.</li>
                <li>Presiona la tecla <kbd>Enter</kbd> para enviar el formulario.</li>
                <li>Si los datos son correctos, el sistema te llevará al panel principal. Si eres administrador, irás al panel de administración. Si eres barbero, irás al panel del barbero.</li>
                <li>Si hay un error, aparecerá un mensaje indicando qué salió mal, por ejemplo: "Las credenciales no coinciden con nuestros registros".</li>
            </ol>
            <p>
                <strong>Nota importante:</strong> El sistema limita los intentos de inicio de sesión a 5 por minuto para proteger tu cuenta.
                Si superas este límite, deberás esperar un momento antes de intentar de nuevo.
            </p>
        </section>

        {{-- ==============================
             SECCIÓN 3: RECUPERAR CONTRASEÑA
             ============================== --}}
        <section id="seccion-recuperar-contrasena" class="manual-seccion" aria-labelledby="titulo-recuperar-contrasena">
            <h2 id="titulo-recuperar-contrasena">3. Cómo recuperar la contraseña</h2>
            <p>
                Si olvidaste tu contraseña, puedes restablecerla por correo electrónico. Sigue estos pasos:
            </p>
            <ol>
                <li>En la página de inicio de sesión, busca el enlace <strong>¿Olvidaste tu contraseña?</strong> y presiónalo con la tecla <kbd>Enter</kbd>.</li>
                <li>Se abrirá un formulario que te pide tu correo electrónico. Escribe el correo asociado a tu cuenta.</li>
                <li>Selecciona el botón <strong>Enviar enlace de restablecimiento</strong> y presiona <kbd>Enter</kbd>.</li>
                <li>Revisa tu bandeja de entrada de correo electrónico. Recibirás un mensaje con un enlace para crear una nueva contraseña.</li>
                <li>Abre el enlace del correo. Se abrirá una página donde podrás escribir tu nueva contraseña.</li>
                <li>Escribe la nueva contraseña, confírmala en el segundo campo y selecciona el botón <strong>Restablecer contraseña</strong>.</li>
                <li>Si todo es correcto, el sistema te redirigirá a la página de inicio de sesión para que ingreses con tu nueva contraseña.</li>
            </ol>
        </section>

        {{-- ==============================
             SECCIÓN 4: DASHBOARD
             ============================== --}}
        <section id="seccion-dashboard" class="manual-seccion" aria-labelledby="titulo-dashboard">
            <h2 id="titulo-dashboard">4. Panel principal (Dashboard)</h2>
            <p>
                El panel principal es la primera página que ves al iniciar sesión como administrador.
                Muestra un resumen general del estado de la barbería. Para acceder a él, selecciona <strong>Inicio</strong> en el menú lateral.
            </p>
            <p>
                En el panel principal encontrarás las siguientes tarjetas de resumen:
            </p>
            <ul>
                <li><strong>Clientes totales:</strong> Muestra la cantidad total de clientes registrados en el sistema.</li>
                <li><strong>Turnos pendientes:</strong> Muestra cuántos turnos están programados y aún no se han atendido.</li>
                <li><strong>Turnos realizados:</strong> Muestra cuántos turnos se han completado.</li>
                <li><strong>Ingresos del mes:</strong> Muestra el total de dinero facturado durante el mes actual, en pesos colombianos.</li>
            </ul>
            <p>
                Debajo de las tarjetas encontrarás dos tablas adicionales:
            </p>
            <ul>
                <li><strong>Servicios más vendidos:</strong> Una tabla con los nombres de los servicios más solicitados y la cantidad de veces que se han vendido.</li>
                <li><strong>Clientes frecuentes:</strong> Una tabla con los nombres de los clientes que más visitan la barbería y su número de visitas.</li>
            </ul>
        </section>

        {{-- ==============================
             SECCIÓN 5: PERSONAL
             ============================== --}}
        <section id="seccion-personal" class="manual-seccion" aria-labelledby="titulo-personal">
            <h2 id="titulo-personal">5. Módulo de Personal (Barberos)</h2>
            <p>
                Este módulo permite registrar y gestionar a los barberos de la barbería.
                Para acceder, selecciona <strong>Personal</strong> en el menú lateral.
            </p>

            <h3 id="personal-ver-lista">5.1. Ver la lista de barberos</h3>
            <p>
                Al entrar al módulo verás una tabla con todos los barberos registrados. La tabla muestra las siguientes columnas:
            </p>
            <ul>
                <li><strong>Documento:</strong> Número de cédula del barbero.</li>
                <li><strong>Nombre:</strong> Nombre completo del barbero.</li>
                <li><strong>Sede:</strong> La sede de la barbería donde trabaja.</li>
                <li><strong>Estado:</strong> Si el barbero está activo o inactivo.</li>
                <li><strong>Usuario:</strong> Si el barbero tiene cuenta de usuario creada en el sistema.</li>
                <li><strong>Acciones:</strong> Botones para activar o desactivar al barbero.</li>
            </ul>

            <h3 id="personal-registrar">5.2. Registrar un nuevo barbero</h3>
            <ol>
                <li>En la página de Personal, busca el botón <strong>Registrar nuevo barbero</strong> y presiónalo con <kbd>Enter</kbd>.</li>
                <li>Se abrirá un formulario con los siguientes campos:
                    <ol type="a">
                        <li><strong>Nombre:</strong> Escribe el nombre del barbero.</li>
                        <li><strong>Apellido:</strong> Escribe el apellido del barbero.</li>
                        <li><strong>Documento:</strong> Escribe el número de cédula.</li>
                        <li><strong>Teléfono:</strong> Escribe el número de celular.</li>
                        <li><strong>Sede:</strong> Selecciona la sede donde trabajará.</li>
                    </ol>
                </li>
                <li>Revisa que todos los datos estén correctos.</li>
                <li>Selecciona el botón <strong>Guardar</strong> y presiona <kbd>Enter</kbd>.</li>
                <li>El sistema mostrará un mensaje confirmando que el barbero fue registrado.</li>
            </ol>

            <h3 id="personal-activar">5.3. Activar o desactivar un barbero</h3>
            <p>
                En la columna de acciones de cada barbero encontrarás botones para activar o desactivar su cuenta.
                Un barbero desactivado no podrá iniciar sesión en el sistema.
            </p>

            <h3 id="personal-usuarios">5.4. Crear y activar la cuenta de usuario de un barbero</h3>
            <p>
                Para que un barbero pueda iniciar sesión en el sistema necesita tener una cuenta de usuario activa.
                La gestión de cuentas se realiza dentro del módulo de Personal:
            </p>
            <ol>
                <li>Ve al módulo de <strong>Personal</strong> desde el menú lateral.</li>
                <li>En la tabla de barberos, la columna <strong>Usuario</strong> indica si el barbero ya tiene una cuenta registrada.</li>
                <li>Cuando el barbero haya registrado su cuenta, accede a la sección <strong>Usuarios</strong> dentro del módulo de Personal.</li>
                <li>Busca al barbero en la tabla. Verás su nombre de usuario, número de cédula y estado actual.</li>
                <li>Selecciona el botón <strong>Activar</strong> y presiona <kbd>Enter</kbd>.</li>
                <li>El barbero podrá iniciar sesión en el sistema a partir de ese momento.</li>
            </ol>
        </section>

        {{-- ==============================
             SECCIÓN 6: SEDES
             ============================== --}}
        <section id="seccion-sedes" class="manual-seccion" aria-labelledby="titulo-sedes">
            <h2 id="titulo-sedes">6. Módulo de Sedes</h2>
            <p>
                Este módulo permite gestionar las sedes o ubicaciones de la barbería.
                Para acceder, selecciona <strong>Sedes</strong> en el menú lateral.
            </p>

            <h3 id="sedes-ver">6.1. Ver las sedes</h3>
            <p>
                Al entrar verás una tabla con todas las sedes registradas. La tabla muestra:
            </p>
            <ul>
                <li><strong>ID:</strong> Número identificador de la sede.</li>
                <li><strong>Nombre de la sede:</strong> El nombre asignado a la ubicación.</li>
                <li><strong>Dirección:</strong> La dirección física de la sede.</li>
                <li><strong>Slogan:</strong> Una frase descriptiva de la sede.</li>
                <li><strong>Acciones:</strong> Botones para editar o eliminar la sede.</li>
            </ul>

            <h3 id="sedes-crear">6.2. Crear una nueva sede</h3>
            <ol>
                <li>Selecciona el botón <strong>Registrar nueva sede</strong> y presiona <kbd>Enter</kbd>.</li>
                <li>Completa los campos del formulario: nombre, dirección y slogan.</li>
                <li>Selecciona el botón <strong>Guardar</strong> y presiona <kbd>Enter</kbd>.</li>
            </ol>

            <h3 id="sedes-editar">6.3. Editar una sede</h3>
            <ol>
                <li>En la tabla de sedes, busca la sede que deseas modificar.</li>
                <li>Selecciona el botón <strong>Editar</strong> de esa fila y presiona <kbd>Enter</kbd>.</li>
                <li>Modifica los datos necesarios en el formulario.</li>
                <li>Selecciona el botón <strong>Guardar cambios</strong> y presiona <kbd>Enter</kbd>.</li>
            </ol>

            <h3 id="sedes-eliminar">6.4. Eliminar una sede</h3>
            <ol>
                <li>En la tabla de sedes, busca la sede que deseas eliminar.</li>
                <li>Selecciona el botón <strong>Eliminar</strong> de esa fila.</li>
                <li>Aparecerá una ventana de confirmación. Selecciona <strong>Sí, eliminar</strong> para confirmar o <strong>No</strong> para cancelar.</li>
            </ol>
        </section>

        {{-- ==============================
             SECCIÓN 7: TURNOS
             ============================== --}}
        <section id="seccion-turnos" class="manual-seccion" aria-labelledby="titulo-turnos">
            <h2 id="titulo-turnos">7. Módulo de Turnos (Citas)</h2>
            <p>
                Este es uno de los módulos más importantes del sistema. Aquí se gestionan todas las citas de los clientes.
                Para acceder, selecciona <strong>Turnos</strong> en el menú lateral.
            </p>

            <h3 id="turnos-ver-lista">7.1. Ver la lista de turnos</h3>
            <p>
                Al entrar verás una tabla con todos los turnos registrados. Puedes filtrar la lista usando los filtros que aparecen en la parte superior:
            </p>
            <ul>
                <li><strong>Filtro por estado:</strong> Pendiente, Cancelado o Realizado.</li>
                <li><strong>Filtro por estado de pago:</strong> Sin anticipo, Pendiente de pago o Confirmado.</li>
                <li><strong>Filtro por fecha:</strong> Selecciona una fecha específica para ver solo los turnos de ese día.</li>
            </ul>
            <p>
                La tabla de turnos muestra estas columnas:
            </p>
            <ul>
                <li><strong>Cliente:</strong> Nombre del cliente que agendó la cita.</li>
                <li><strong>Barbero:</strong> Nombre del barbero asignado.</li>
                <li><strong>Fecha:</strong> Fecha programada del turno.</li>
                <li><strong>Hora:</strong> Hora programada del turno.</li>
                <li><strong>Estado:</strong> Si el turno está Pendiente, Realizado o Cancelado.</li>
                <li><strong>Estado de pago:</strong> Si el anticipo fue pagado, está pendiente de verificación o no se realizó.</li>
                <li><strong>Acciones:</strong> Botones para gestionar el turno.</li>
            </ul>

            <h3 id="turnos-crear">7.2. Crear un nuevo turno</h3>
            <ol>
                <li>En la página de turnos, selecciona el botón <strong>Nuevo Turno</strong> y presiona <kbd>Enter</kbd>.</li>
                <li>Se abrirá una vista con un calendario. Selecciona la fecha del turno haciendo clic en el día deseado o usando las flechas del teclado.</li>
                <li>Selecciona el servicio que desea el cliente en el campo <strong>Servicio</strong>.</li>
                <li>El sistema mostrará automáticamente los horarios disponibles para esa fecha y servicio.</li>
                <li>Selecciona el horario que prefiera el cliente.</li>
                <li>Si el cliente ya ha visitado la barbería antes, puedes buscar sus datos ingresando su número de cédula. El sistema autocompletará el nombre y teléfono.</li>
                <li>Si es un cliente nuevo, completa los campos: nombre, apellido, cédula y celular.</li>
                <li>Selecciona el botón <strong>Guardar</strong> y presiona <kbd>Enter</kbd>.</li>
                <li>El sistema confirmará que el turno fue agendado. El cliente y el barbero recibirán una notificación por correo electrónico.</li>
            </ol>

            <h3 id="turnos-realizar">7.3. Marcar un turno como realizado</h3>
            <ol>
                <li>En la lista de turnos, busca el turno que fue atendido.</li>
                <li>Selecciona el botón <strong>Realizado</strong> en la columna de acciones.</li>
                <li>El estado del turno cambiará a "Realizado" y quedará habilitada la opción de facturarlo.</li>
            </ol>
        </section>

        {{-- ==============================
             SECCIÓN 8: CANCELAR / REPROGRAMAR
             ============================== --}}
        <section id="seccion-cancelar-reprogramar" class="manual-seccion" aria-labelledby="titulo-cancelar-reprogramar">
            <h2 id="titulo-cancelar-reprogramar">8. Cancelar o reprogramar un turno</h2>

            <h3 id="cancelar-turno">8.1. Cancelar un turno</h3>
            <ol>
                <li>Ve al módulo de <strong>Turnos</strong> desde el menú lateral.</li>
                <li>Busca el turno que deseas cancelar en la lista. Puedes usar los filtros para encontrarlo más rápido.</li>
                <li>En la columna de acciones, selecciona el botón <strong>Cancelar</strong> y presiona <kbd>Enter</kbd>.</li>
                <li>Aparecerá una ventana de confirmación. Selecciona <strong>Sí, cancelar</strong> para proceder.</li>
                <li>El turno cambiará a estado "Cancelado" y se mostrará un mensaje de confirmación.</li>
            </ol>

            <h3 id="reprogramar-turno">8.2. Reprogramar un turno</h3>
            <ol>
                <li>Ve al módulo de <strong>Turnos</strong> desde el menú lateral.</li>
                <li>Busca el turno que deseas reprogramar en la lista.</li>
                <li>Selecciona el botón <strong>Reprogramar</strong> en la columna de acciones.</li>
                <li>Se abrirá un formulario donde puedes cambiar la nueva fecha y hora del turno.</li>
                <li>Selecciona la nueva fecha y hora disponibles.</li>
                <li>Selecciona el botón <strong>Guardar cambios</strong> y presiona <kbd>Enter</kbd>.</li>
                <li>El sistema actualizará el turno con los nuevos datos y mostrará un mensaje de confirmación.</li>
            </ol>
        </section>

        {{-- ==============================
             SECCIÓN 9: PAGOS Y QR
             ============================== --}}
        <section id="seccion-pagos" class="manual-seccion" aria-labelledby="titulo-pagos">
            <h2 id="titulo-pagos">9. Pagos y anticipos con QR</h2>
            <p>
                El sistema permite a los clientes pagar un anticipo de 10.000 pesos colombianos al momento de agendar su cita.
                El pago se realiza mediante códigos QR de <strong>Nequi</strong>, <strong>DaviPlata</strong> o <strong>Bancolombia</strong>.
                El cliente elige el método de su preferencia en el paso 4 del agendamiento.
            </p>

            <h3 id="pagos-confirmar">9.1. Confirmar un pago de anticipo</h3>
            <ol>
                <li>Cuando un cliente paga un anticipo, el turno aparece con estado de pago <strong>Pendiente de pago</strong> en la lista de turnos.</li>
                <li>Verifica en tu cuenta de Nequi, DaviPlata o Bancolombia que el pago se haya recibido correctamente.</li>
                <li>En la lista de turnos, busca el turno con pago pendiente.</li>
                <li>Selecciona el botón <strong>Confirmar pago</strong> y presiona <kbd>Enter</kbd>.</li>
                <li>El estado de pago cambiará a "Confirmado" y el cliente recibirá una notificación por correo.</li>
            </ol>

            <h3 id="pagos-rechazar">9.2. Rechazar un pago</h3>
            <ol>
                <li>Si el pago no se recibió o hay un error, busca el turno en la lista.</li>
                <li>Selecciona el botón <strong>Rechazar pago</strong> y presiona <kbd>Enter</kbd>.</li>
                <li>El sistema registrará que el pago fue rechazado.</li>
            </ol>

            <h3 id="pagos-configurar-qr">9.3. Configurar los códigos QR de pago</h3>
            <p>
                Para cambiar las imágenes de los códigos QR de Nequi, DaviPlata y Bancolombia:
            </p>
            <ol>
                <li>Ve al módulo de <strong>Configuración</strong> desde la parte inferior del menú lateral.</li>
                <li>Selecciona la tarjeta <strong>Implementar QR de Pagos</strong>.</li>
                <li>En la página de gestión de QR verás tres tarjetas: una para <strong>Nequi</strong>, una para <strong>DaviPlata</strong> y una para <strong>Bancolombia</strong>.</li>
                <li>En cada tarjeta, selecciona el botón <strong>Seleccionar archivo</strong> y elige la imagen del QR correspondiente desde tu computador (JPG o PNG, máximo 2 MB).</li>
                <li>Selecciona el botón <strong>Subir QR</strong> y presiona <kbd>Enter</kbd>.</li>
                <li>El sistema guardará la nueva imagen del QR y la mostrará a los clientes cuando elijan ese método de pago al agendar su cita.</li>
            </ol>
        </section>

        {{-- ==============================
             SECCIÓN 10: DISPONIBILIDAD
             ============================== --}}
        <section id="seccion-disponibilidad" class="manual-seccion" aria-labelledby="titulo-disponibilidad">
            <h2 id="titulo-disponibilidad">10. Módulo de Disponibilidad (Horarios de barberos)</h2>
            <p>
                Este módulo permite definir los días y horas en que cada barbero está disponible para atender clientes.
                Para acceder, selecciona <strong>Disponibilidad</strong> en el menú lateral.
            </p>

            <h3 id="disponibilidad-ver">10.1. Ver la disponibilidad</h3>
            <p>
                Al entrar verás la disponibilidad organizada por barbero. Para cada barbero se muestra una tabla con:
            </p>
            <ul>
                <li><strong>Fecha:</strong> El día específico de disponibilidad.</li>
                <li><strong>Día de la semana:</strong> Lunes, martes, miércoles, etc.</li>
                <li><strong>Hora de inicio:</strong> La hora en que comienza a atender.</li>
                <li><strong>Hora de fin:</strong> La hora en que termina de atender.</li>
                <li><strong>Estado:</strong> Si la disponibilidad está activa o inactiva.</li>
                <li><strong>Acciones:</strong> Botones para editar o eliminar.</li>
            </ul>

            <h3 id="disponibilidad-crear">10.2. Crear disponibilidad</h3>
            <ol>
                <li>Selecciona el botón <strong>Crear disponibilidad</strong> y presiona <kbd>Enter</kbd>.</li>
                <li>Selecciona el barbero, la fecha, la hora de inicio y la hora de fin.</li>
                <li>Selecciona el botón <strong>Guardar</strong> y presiona <kbd>Enter</kbd>.</li>
            </ol>

            <h3 id="disponibilidad-semanal">10.3. Crear disponibilidad semanal</h3>
            <p>
                Puedes crear la disponibilidad de toda una semana de forma masiva, seleccionando los días y las horas para un barbero en particular.
                Esto es más rápido que crear cada día por separado.
            </p>

            <h3 id="disponibilidad-por-fecha">10.4. Consultar disponibilidad por fecha</h3>
            <p>
                Puedes filtrar la disponibilidad por una fecha específica para ver qué barberos están disponibles ese día y en qué horarios.
            </p>
        </section>

        {{-- ==============================
             SECCIÓN 11: SERVICIOS
             ============================== --}}
        <section id="seccion-servicios" class="manual-seccion" aria-labelledby="titulo-servicios">
            <h2 id="titulo-servicios">11. Módulo de Servicios y Combos</h2>
            <p>
                Este módulo permite gestionar los servicios que ofrece la barbería, como cortes de cabello, afeitados, y combos.
                Para acceder, selecciona <strong>Servicios</strong> en el menú lateral.
            </p>

            <h3 id="servicios-ver">11.1. Ver los servicios</h3>
            <p>
                Al entrar verás una tabla con todos los servicios registrados. Las columnas son:
            </p>
            <ul>
                <li><strong>Tipo:</strong> Si es un servicio individual o un combo (paquete de varios servicios).</li>
                <li><strong>Nombre:</strong> El nombre del servicio.</li>
                <li><strong>Categoría:</strong> La categoría a la que pertenece.</li>
                <li><strong>Precio:</strong> El precio original del servicio en pesos colombianos.</li>
                <li><strong>Descuento:</strong> El porcentaje de descuento aplicado, si tiene alguno.</li>
                <li><strong>Precio final:</strong> El precio después de aplicar el descuento.</li>
                <li><strong>Duración:</strong> El tiempo estimado de duración del servicio.</li>
                <li><strong>Estado:</strong> Si el servicio está activo o inactivo.</li>
                <li><strong>Incluye:</strong> Para los combos, muestra la lista de servicios que incluye.</li>
                <li><strong>Acciones:</strong> Botones para editar o eliminar.</li>
            </ul>

            <h3 id="servicios-crear">11.2. Crear un nuevo servicio</h3>
            <ol>
                <li>Selecciona el botón <strong>Crear servicio</strong> y presiona <kbd>Enter</kbd>.</li>
                <li>Completa los campos: nombre, categoría, precio, descuento (opcional), duración y estado.</li>
                <li>Si es un combo, selecciona los servicios individuales que incluye.</li>
                <li>Selecciona el botón <strong>Guardar</strong> y presiona <kbd>Enter</kbd>.</li>
            </ol>

            <h3 id="servicios-editar">11.3. Editar un servicio</h3>
            <ol>
                <li>En la tabla, busca el servicio que deseas modificar.</li>
                <li>Selecciona el botón <strong>Editar</strong> y presiona <kbd>Enter</kbd>.</li>
                <li>Modifica los datos necesarios y selecciona <strong>Guardar cambios</strong>.</li>
            </ol>
        </section>

        {{-- ==============================
             SECCIÓN 12: PRODUCTOS
             ============================== --}}
        <section id="seccion-productos" class="manual-seccion" aria-labelledby="titulo-productos">
            <h2 id="titulo-productos">12. Módulo de Productos y Kits</h2>
            <p>
                Este módulo permite gestionar los productos que vende la barbería, como ceras, aceites para barba, shampoos, y también kits que agrupan varios productos.
                Para acceder, selecciona <strong>Productos</strong> en el menú lateral.
            </p>

            <h3 id="productos-ver">12.1. Ver los productos</h3>
            <p>
                Al entrar verás una tabla con todos los productos. Puedes filtrar la vista usando los botones de la parte superior:
            </p>
            <ul>
                <li><strong>Todos:</strong> Muestra todos los productos y kits.</li>
                <li><strong>Productos:</strong> Muestra solo los productos individuales.</li>
                <li><strong>Kits:</strong> Muestra solo los kits (paquetes de productos).</li>
            </ul>
            <p>
                La tabla muestra las siguientes columnas:
            </p>
            <ul>
                <li><strong>Tipo:</strong> Si es un Producto o un Kit.</li>
                <li><strong>Nombre:</strong> El nombre del producto.</li>
                <li><strong>Categoría:</strong> La categoría del producto.</li>
                <li><strong>Precio:</strong> El precio en pesos colombianos.</li>
                <li><strong>Stock:</strong> La cantidad disponible en inventario.</li>
                <li><strong>Estado:</strong> Si está activo o inactivo.</li>
                <li><strong>Imagen:</strong> La foto del producto.</li>
                <li><strong>Acciones:</strong> Botones para editar o eliminar.</li>
            </ul>

            <h3 id="productos-crear">12.2. Crear un nuevo producto</h3>
            <ol>
                <li>Selecciona el botón <strong>Crear producto</strong> y presiona <kbd>Enter</kbd>.</li>
                <li>Completa los campos: nombre, categoría, precio, stock, estado e imagen.</li>
                <li>Si es un kit, selecciona los productos individuales que incluye.</li>
                <li>Selecciona el botón <strong>Guardar</strong> y presiona <kbd>Enter</kbd>.</li>
            </ol>
        </section>

        {{-- ==============================
             SECCIÓN 13: CRM
             ============================== --}}
        <section id="seccion-crm" class="manual-seccion" aria-labelledby="titulo-crm">
            <h2 id="titulo-crm">13. Módulo CRM (Gestión de Clientes)</h2>
            <p>
                El CRM es un módulo que permite conocer a los clientes de la barbería.
                Muestra información sobre sus visitas, gastos y servicios favoritos.
                Para acceder, selecciona <strong>CRM</strong> en el menú lateral.
            </p>

            <h3 id="crm-lista">13.1. Ver la lista de clientes</h3>
            <p>
                Al entrar verás una tabla con todos los clientes que han visitado la barbería. La tabla muestra:
            </p>
            <ul>
                <li><strong>Cliente:</strong> Nombre completo del cliente.</li>
                <li><strong>Celular:</strong> Número de teléfono del cliente.</li>
                <li><strong>Visitas:</strong> Cantidad total de veces que ha visitado la barbería.</li>
                <li><strong>Última visita:</strong> La fecha de su visita más reciente.</li>
                <li><strong>Gasto total:</strong> El total de dinero que ha gastado en la barbería.</li>
                <li><strong>Servicio favorito:</strong> El servicio que más solicita.</li>
                <li><strong>Acción:</strong> Botón para ver el detalle completo del cliente.</li>
            </ul>
            <p>
                <strong>Nota:</strong> Los clientes que llevan más de 2 meses sin visitar la barbería aparecen resaltados en color naranja como alerta de inactividad.
            </p>
            <p>
                Puedes buscar clientes por nombre o por número de celular usando los campos de filtro en la parte superior.
            </p>

            <h3 id="crm-detalle">13.2. Ver el detalle de un cliente</h3>
            <ol>
                <li>En la lista de clientes, selecciona el botón <strong>Ver detalle</strong> del cliente que deseas consultar.</li>
                <li>Se abrirá una página con toda la información del cliente:
                    <ul>
                        <li>Total gastado en la barbería y promedio por visita.</li>
                        <li>Tabla con el historial de todos sus turnos: fecha, hora, barbero que lo atendió y estado.</li>
                        <li>Tabla con sus facturas: número de factura, total, abono y fecha.</li>
                    </ul>
                </li>
                <li>Puedes filtrar el historial por rango de fechas o por servicio.</li>
            </ol>

            <h3 id="crm-exportar">13.3. Exportar la lista de clientes a PDF</h3>
            <ol>
                <li>En la página principal del CRM, busca el botón <strong>Exportar PDF</strong>.</li>
                <li>Selecciónalo y presiona <kbd>Enter</kbd>.</li>
                <li>El sistema generará un archivo PDF con la lista de todos los clientes y sus datos.</li>
            </ol>
        </section>

        {{-- ==============================
             SECCIÓN 14: FIDELIZACIÓN
             ============================== --}}
        <section id="seccion-fidelizacion" class="manual-seccion" aria-labelledby="titulo-fidelizacion">
            <h2 id="titulo-fidelizacion">14. Módulo de Fidelización (Programa de lealtad)</h2>
            <p>
                La fidelización es un programa de lealtad que premia a los clientes frecuentes.
                Cuando un cliente acumula cierta cantidad de visitas, gana un corte de cabello gratis.
                Para acceder, selecciona <strong>Fidelización</strong> en el menú lateral.
            </p>

            <h3 id="fidelizacion-ver">14.1. Ver la lista de clientes fidelizados</h3>
            <p>
                Al entrar verás una tabla con los clientes que participan en el programa. Las columnas son:
            </p>
            <ul>
                <li><strong>Cliente:</strong> Nombre del cliente.</li>
                <li><strong>Cédula:</strong> Número de documento del cliente.</li>
                <li><strong>Teléfono:</strong> Número de celular del cliente.</li>
                <li><strong>Visitas acumuladas:</strong> Cuántas visitas lleva acumuladas.</li>
                <li><strong>Cortes gratis:</strong> Cuántos cortes gratis ha ganado.</li>
                <li><strong>Última actualización:</strong> La fecha de la última visita registrada.</li>
                <li><strong>Acciones:</strong> Botón para ver el detalle.</li>
            </ul>

            <h3 id="fidelizacion-detalle">14.2. Ver detalle de fidelización</h3>
            <ol>
                <li>Selecciona el botón <strong>Ver detalle</strong> del cliente que deseas consultar.</li>
                <li>Verás información sobre su último turno: fecha, hora, estado y el barbero que lo atendió.</li>
            </ol>

            <h3 id="fidelizacion-configurar">14.3. Configurar el programa de fidelización</h3>
            <ol>
                <li>En la página de fidelización, busca el enlace o botón <strong>Configuración</strong> y presiónalo.</li>
                <li>En la página de configuración puedes:
                    <ul>
                        <li>Definir cuántas visitas se necesitan para ganar un corte gratis. Por ejemplo: 10 visitas.</li>
                        <li>Habilitar o deshabilitar el programa de fidelización completo.</li>
                    </ul>
                </li>
                <li>Modifica los valores según necesites y selecciona el botón <strong>Guardar configuración</strong>.</li>
            </ol>
        </section>

        {{-- ==============================
             SECCIÓN 15: FACTURACIÓN
             ============================== --}}
        <section id="seccion-facturacion" class="manual-seccion" aria-labelledby="titulo-facturacion">
            <h2 id="titulo-facturacion">15. Módulo de Facturación</h2>
            <p>
                Este módulo permite crear y gestionar las facturas de los servicios prestados.
                Para acceder, selecciona <strong>Facturación</strong> en el menú lateral.
            </p>

            <h3 id="facturas-ver">15.1. Ver la lista de facturas</h3>
            <p>
                Al entrar verás una tabla con todas las facturas generadas. Puedes filtrar por fecha o buscar por nombre del cliente, sede o número de factura. Las columnas son:
            </p>
            <ul>
                <li><strong>ID:</strong> Número identificador de la factura.</li>
                <li><strong>Fecha:</strong> Fecha en que se generó la factura.</li>
                <li><strong>Sede:</strong> La sede donde se realizó el servicio.</li>
                <li><strong>Turno:</strong> El turno asociado a la factura.</li>
                <li><strong>Total:</strong> El valor total de la factura.</li>
                <li><strong>Abono:</strong> El monto del anticipo pagado.</li>
                <li><strong>Descuento:</strong> El porcentaje de descuento aplicado.</li>
                <li><strong>Total con descuento:</strong> El valor final después del descuento.</li>
                <li><strong>Acciones:</strong> Botones para ver detalle, descargar PDF o eliminar.</li>
            </ul>

            <h3 id="facturas-crear">15.2. Crear una factura</h3>
            <p>
                Las facturas se crean a partir de un turno que fue marcado como realizado.
            </p>
            <ol>
                <li>Ve al módulo de <strong>Turnos</strong> y busca un turno con estado "Realizado".</li>
                <li>En las acciones de ese turno, selecciona el botón <strong>Facturar</strong> y presiona <kbd>Enter</kbd>.</li>
                <li>Se abrirá el formulario de creación de factura con los datos del turno prellenados.</li>
                <li>Verifica que los datos sean correctos.</li>
                <li>Selecciona el botón <strong>Guardar factura</strong> y presiona <kbd>Enter</kbd>.</li>
            </ol>

            <h3 id="facturas-detalle">15.3. Ver el detalle de una factura</h3>
            <ol>
                <li>En la lista de facturas, selecciona el botón <strong>Ver</strong> de la factura que deseas consultar.</li>
                <li>Verás la información completa de la factura:
                    <ul>
                        <li>Datos del cliente: nombre y cédula.</li>
                        <li>Barbero que realizó el servicio.</li>
                        <li>Sede donde se prestó el servicio.</li>
                        <li>Tabla de servicios facturados con valor original, porcentaje de descuento y valor final.</li>
                        <li>Resumen: subtotal, descuento aplicado, valor final, abono y saldo pendiente.</li>
                    </ul>
                </li>
            </ol>

            <h3 id="facturas-agregar-extras">15.4. Agregar servicios extra a una factura</h3>
            <ol>
                <li>Dentro del detalle de una factura, busca la opción para agregar servicios adicionales.</li>
                <li>Selecciona el servicio extra que se realizó.</li>
                <li>Selecciona el botón <strong>Agregar</strong> para añadirlo a la factura.</li>
            </ol>

            <h3 id="facturas-pdf">15.5. Descargar una factura en PDF</h3>
            <ol>
                <li>En la lista de facturas o en el detalle de una factura, busca el botón <strong>Descargar PDF</strong>.</li>
                <li>Selecciónalo y presiona <kbd>Enter</kbd>. El navegador descargará el archivo PDF de la factura.</li>
            </ol>
        </section>

        {{-- ==============================
             SECCIÓN 16: REPORTES
             ============================== --}}
        <section id="seccion-reportes" class="manual-seccion" aria-labelledby="titulo-reportes">
            <h2 id="titulo-reportes">16. Módulo de Reportes</h2>
            <p>
                Este módulo muestra estadísticas y reportes del negocio.
                Para acceder, selecciona <strong>Reporte General</strong> en el menú lateral.
            </p>

            <h3 id="reportes-filtros">16.1. Filtrar por período</h3>
            <p>
                En la parte superior de la página encontrarás dos campos de fecha:
            </p>
            <ul>
                <li><strong>Fecha inicial:</strong> La fecha de inicio del período que deseas consultar.</li>
                <li><strong>Fecha final:</strong> La fecha de fin del período.</li>
            </ul>
            <p>
                Selecciona las fechas y el reporte se actualizará automáticamente.
            </p>

            <h3 id="reportes-metricas">16.2. Métricas principales</h3>
            <p>
                El reporte muestra dos métricas grandes en la parte superior:
            </p>
            <ul>
                <li><strong>Ventas totales:</strong> El monto total facturado en el período seleccionado.</li>
                <li><strong>Cortes realizados:</strong> La cantidad total de servicios completados.</li>
            </ul>

            <h3 id="reportes-tablas">16.3. Tablas del reporte</h3>
            <p>
                El reporte incluye cuatro tablas informativas:
            </p>
            <ul>
                <li><strong>Resumen por barbero:</strong> Muestra cada barbero con la cantidad de servicios realizados y el total de ventas generadas. Al final muestra los totales generales.</li>
                <li><strong>Servicios más vendidos:</strong> Muestra los servicios ordenados por cantidad de ventas.</li>
                <li><strong>Productos más vendidos:</strong> Muestra los productos del catálogo ordenados por cantidad de ventas en el período seleccionado.</li>
                <li><strong>Días con más turnos:</strong> Muestra los días de la semana que más turnos reciben.</li>
            </ul>

            <h3 id="reportes-exportar">16.4. Exportar el reporte</h3>
            <ol>
                <li>Para descargar el reporte en PDF, selecciona el botón <strong>Descargar PDF</strong>.</li>
                <li>Para descargar el reporte en Excel, selecciona el botón <strong>Descargar Excel</strong>.</li>
                <li>El archivo se descargará automáticamente en tu computador.</li>
            </ol>
        </section>

        {{-- ==============================
             SECCIÓN 17: BLOG
             ============================== --}}
        <section id="seccion-blog" class="manual-seccion" aria-labelledby="titulo-blog">
            <h2 id="titulo-blog">17. Módulo de Blog</h2>
            <p>
                El blog permite publicar artículos informativos que aparecen en el sitio web público.
                Es útil para compartir consejos de cuidado personal, novedades de la barbería, y mejorar el posicionamiento en buscadores.
                Para acceder, selecciona <strong>Blog</strong> en el menú lateral.
            </p>

            <h3 id="blog-ver">17.1. Ver los artículos</h3>
            <p>
                Al entrar verás una tabla con todos los artículos del blog. Puedes filtrar por:
            </p>
            <ul>
                <li><strong>Búsqueda:</strong> Escribe parte del título o contenido para buscar artículos.</li>
                <li><strong>Estado:</strong> Borrador, Publicado o Archivado.</li>
                <li><strong>Categoría:</strong> Filtra por la categoría del artículo.</li>
            </ul>
            <p>
                La tabla muestra: imagen, título, categoría, estado, autor, número de vistas, fecha de publicación y acciones.
            </p>

            <h3 id="blog-crear">17.2. Crear un nuevo artículo</h3>
            <ol>
                <li>Selecciona el botón <strong>Crear artículo</strong> y presiona <kbd>Enter</kbd>.</li>
                <li>Completa los campos del formulario:
                    <ol type="a">
                        <li><strong>Título:</strong> El título del artículo.</li>
                        <li><strong>Contenido:</strong> El cuerpo del artículo.</li>
                        <li><strong>Categoría:</strong> Selecciona la categoría.</li>
                        <li><strong>Imagen:</strong> Sube una imagen de portada.</li>
                        <li><strong>Estado:</strong> Guárdalo como borrador o publícalo directamente.</li>
                    </ol>
                </li>
                <li>Selecciona el botón <strong>Guardar</strong> y presiona <kbd>Enter</kbd>.</li>
            </ol>

            <h3 id="blog-publicar">17.3. Publicar o archivar un artículo</h3>
            <ol>
                <li>En la lista de artículos, busca el artículo que deseas cambiar de estado.</li>
                <li>Selecciona el botón <strong>Publicar</strong> o <strong>Archivar</strong> según lo que necesites.</li>
                <li>El artículo cambiará de estado. Los artículos publicados son visibles en el sitio web público.</li>
            </ol>

            <h3 id="blog-previsualizar">17.4. Previsualizar un artículo</h3>
            <ol>
                <li>En la lista, selecciona el botón <strong>Preview</strong> del artículo.</li>
                <li>Se abrirá una vista previa de cómo se verá el artículo en el sitio web público.</li>
            </ol>
        </section>

        {{-- ==============================
             SECCIÓN 18: COMENTARIOS
             ============================== --}}
        <section id="seccion-comentarios" class="manual-seccion" aria-labelledby="titulo-comentarios">
            <h2 id="titulo-comentarios">18. Módulo de Comentarios</h2>
            <p>
                Este módulo permite moderar los comentarios que los visitantes dejan en los artículos del blog.
                Para acceder, selecciona <strong>Comentarios</strong> en el menú lateral.
                Si hay comentarios pendientes de revisión, verás un número junto al nombre del módulo indicando cuántos hay.
            </p>

            <h3 id="comentarios-moderar">18.1. Moderar comentarios</h3>
            <p>
                Puedes filtrar los comentarios por estado:
            </p>
            <ul>
                <li><strong>Pendientes:</strong> Comentarios que aún no han sido revisados.</li>
                <li><strong>Aprobados:</strong> Comentarios que fueron aprobados y son visibles en el blog.</li>
                <li><strong>Rechazados:</strong> Comentarios que fueron rechazados y no son visibles.</li>
            </ul>
            <p>
                Para cada comentario puedes ver el nombre del autor, el contenido del comentario y el artículo al que pertenece.
            </p>

            <h3 id="comentarios-acciones">18.2. Acciones sobre comentarios</h3>
            <ul>
                <li><strong>Aprobar:</strong> Selecciona el botón <strong>Aprobar</strong> para que el comentario sea visible en el blog.</li>
                <li><strong>Rechazar:</strong> Selecciona el botón <strong>Rechazar</strong> para ocultar el comentario.</li>
                <li><strong>Eliminar:</strong> Selecciona el botón <strong>Eliminar</strong> para borrar el comentario permanentemente.</li>
            </ul>

            <h3 id="comentarios-masivos">18.3. Acciones masivas</h3>
            <ol>
                <li>Selecciona las casillas de verificación junto a los comentarios que deseas gestionar.</li>
                <li>Usa los botones de acciones masivas: <strong>Aprobar seleccionados</strong>, <strong>Rechazar seleccionados</strong> o <strong>Eliminar seleccionados</strong>.</li>
            </ol>
        </section>

        {{-- ==============================
             SECCIÓN 19: CONFIGURACIÓN
             ============================== --}}
        <section id="seccion-configuracion" class="manual-seccion" aria-labelledby="titulo-configuracion">
            <h2 id="titulo-configuracion">19. Módulo de Configuración</h2>
            <p>
                El módulo de configuración permite ajustar diferentes aspectos del sistema.
                Para acceder, selecciona <strong>Configuración</strong> en la parte inferior del menú lateral (en el pie del menú).
            </p>
            <p>
                Al entrar verás varias tarjetas, cada una llevando a un área de configuración diferente:
            </p>

            <h3 id="config-qr">19.1. Implementar QR de Pagos</h3>
            <p>
                Permite subir las imágenes de los códigos QR de Nequi y DaviPlata para que los clientes paguen el anticipo al agendar citas.
                Los pasos detallados están en la sección 9.3 de este manual.
            </p>

            <h3 id="config-redes">19.2. Redes Sociales y WhatsApp</h3>
            <ol>
                <li>Selecciona la tarjeta <strong>Redes Sociales y WhatsApp</strong> y presiona <kbd>Enter</kbd>.</li>
                <li>Verás campos para configurar los enlaces de las redes sociales:
                    <ul>
                        <li><strong>WhatsApp:</strong> Escribe el número de WhatsApp de la barbería.</li>
                        <li><strong>Instagram:</strong> Escribe la URL del perfil de Instagram.</li>
                        <li><strong>Facebook:</strong> Escribe la URL de la página de Facebook.</li>
                        <li><strong>TikTok:</strong> Escribe la URL del perfil de TikTok.</li>
                        <li><strong>YouTube:</strong> Escribe la URL del canal de YouTube.</li>
                    </ul>
                </li>
                <li>Selecciona el botón <strong>Guardar configuración</strong> y presiona <kbd>Enter</kbd>.</li>
                <li>Los enlaces se mostrarán en el sitio web público.</li>
            </ol>

            <h3 id="config-perfil">19.3. Información Personal</h3>
            <ol>
                <li>Selecciona la tarjeta <strong>Información Personal</strong> y presiona <kbd>Enter</kbd>.</li>
                <li>En esta página puedes:
                    <ul>
                        <li>Cambiar tu <strong>nombre de usuario</strong> y <strong>número de documento</strong>.</li>
                        <li>Actualizar tu <strong>nombre completo</strong>, <strong>apellidos</strong>, <strong>correo electrónico</strong> y <strong>celular</strong>.</li>
                        <li>Cambiar tu contraseña: debes ingresar la contraseña actual y la nueva (mínimo 8 caracteres, al menos una mayúscula y un número).</li>
                    </ul>
                </li>
                <li>Modifica lo necesario y selecciona el botón <strong>Guardar</strong>.</li>
            </ol>

            <h3 id="config-foto">19.4. Foto de Perfil</h3>
            <ol>
                <li>En la página de configuración busca la sección <strong>Foto de Perfil</strong>.</li>
                <li>Haz clic en el botón <strong>Cambiar foto</strong> y selecciona una imagen JPG, PNG o GIF de máximo 2 MB.</li>
                <li>Para eliminar la foto actual usa el botón <strong>Eliminar foto</strong>.</li>
                <li>La foto aparece en el menú lateral y en tu perfil de barbero.</li>
            </ol>

            <h3 id="config-qr-bancolombia">19.5. QR de Pagos (Nequi, DaviPlata y Bancolombia)</h3>
            <p>
                Ahora el sistema soporta tres métodos de pago QR. Para subirlos ve a <strong>Gestión de QR</strong> en la página de configuración.
                Al ingresar verás tres tarjetas: una para Nequi, una para DaviPlata y una para Bancolombia.
                En cada tarjeta puedes subir la imagen del QR oficial (JPG, PNG, máx. 2 MB).
                Los clientes verán el método que elijan al momento de pagar el anticipo en el paso 4 del agendamiento.
            </p>

            <h3 id="config-manual">19.6. Manual de Usuario</h3>
            <p>
                Es esta página que estás leyendo ahora. Puedes acceder a ella desde la tarjeta <strong>Manual de Usuario</strong> en la página de configuración.
            </p>
        </section>

        {{-- ==============================
             SECCIÓN 20: SITIO PÚBLICO
             ============================== --}}
        <section id="seccion-sitio-publico" class="manual-seccion" aria-labelledby="titulo-sitio-publico">
            <h2 id="titulo-sitio-publico">20. Sitio web público</h2>
            <p>
                El sitio web público es la parte del sistema que cualquier persona puede ver sin necesidad de iniciar sesión.
                A continuación se describe cada página:
            </p>

            <h3 id="publico-inicio">20.1. Página de inicio</h3>
            <p>
                La página de inicio es la primera que ven los visitantes. Contiene:
            </p>
            <ul>
                <li>Una presentación visual de la barbería con un video de fondo.</li>
                <li>Botones principales para <strong>Agendar Cita</strong> y <strong>Ver Servicios</strong>.</li>
                <li>Los 4 servicios más populares.</li>
                <li>Los 8 productos destacados.</li>
            </ul>

            <h3 id="publico-servicios">20.2. Página de Servicios</h3>
            <p>
                Muestra el catálogo completo de todos los servicios activos de la barbería, incluyendo combos. Para cada servicio se muestra el nombre, precio, descuento (si tiene) y duración.
            </p>

            <h3 id="publico-productos">20.3. Página de Productos</h3>
            <p>
                Muestra el catálogo de todos los productos activos disponibles para la venta, con nombre, precio e imagen.
            </p>

            <h3 id="publico-nosotros">20.4. Página Nosotros</h3>
            <p>
                Cuenta la historia de la barbería, su misión, visión y valores. También muestra al equipo de barberos activos con su foto y datos.
            </p>

            <h3 id="publico-contacto">20.5. Página de Contacto</h3>
            <p>
                Muestra la información de contacto de la barbería: ubicación, teléfono y horarios de atención.
                Incluye un formulario de contacto para que los visitantes envíen mensajes y un mapa de ubicación de cada sede.
            </p>

            <h3 id="publico-agendar">20.6. Agendar cita desde el sitio web</h3>
            <p>
                Los clientes pueden agendar su cita directamente desde el sitio web público siguiendo 5 pasos:
            </p>
            <ol>
                <li><strong>Paso 1 - Seleccionar barbero:</strong> El cliente elige al barbero de su preferencia o la opción "Cualquier barbero".</li>
                <li><strong>Paso 2 - Seleccionar servicio:</strong> El cliente elige el servicio que desea, como corte de cabello, afeitado o un combo.</li>
                <li><strong>Paso 3 - Seleccionar fecha y hora:</strong> El sistema muestra las fechas y horarios disponibles. El cliente selecciona los que le convengan.</li>
                <li><strong>Paso 4 - Pago de anticipo:</strong> El cliente elige su método de pago preferido (Nequi, DaviPlata o Bancolombia) y paga un anticipo de 10.000 pesos usando el código QR que se muestra en pantalla.</li>
                <li><strong>Paso 5 - Confirmar datos:</strong> El cliente ingresa su nombre, cédula y número de celular, y confirma la cita.</li>
            </ol>

            <h3 id="publico-fidelizacion">20.7. Consulta de Fidelización</h3>
            <p>
                Desde la página de fidelización, los clientes pueden consultar su estado en el programa de lealtad ingresando su número de cédula o celular.
                El sistema muestra cuántas visitas lleva acumuladas, cuántos cortes gratis ha ganado y cuántas visitas le faltan para el próximo corte gratis.
            </p>

            <h3 id="publico-blog">20.8. Blog público</h3>
            <p>
                El blog muestra los artículos publicados por la barbería. Los visitantes pueden leer artículos, buscar por texto, filtrar por categoría y dejar comentarios.
            </p>
        </section>

        {{-- ==============================
             SECCIÓN 21: PANEL DEL BARBERO
             ============================== --}}
        <section id="seccion-panel-barbero" class="manual-seccion" aria-labelledby="titulo-panel-barbero">
            <h2 id="titulo-panel-barbero">21. Panel del Barbero</h2>
            <p>
                El panel del barbero es un espacio simplificado para los empleados de la barbería.
                Para acceder, el barbero debe iniciar sesión con su cuenta. El menú lateral del barbero tiene estas opciones:
            </p>
            <ul>
                <li><strong>Inicio:</strong> Panel principal del barbero.</li>
                <li><strong>Turnos:</strong> Los turnos asignados al barbero.</li>
                <li><strong>Horario:</strong> El horario semanal del barbero.</li>
                <li><strong>Perfil:</strong> Configuración de la cuenta personal.</li>
                <li><strong>Cerrar sesión:</strong> Salir del sistema.</li>
            </ul>

            <h3 id="barbero-dashboard">21.1. Panel principal del barbero</h3>
            <p>
                Al iniciar sesión, el barbero ve un resumen de su semana actual:
            </p>
            <ul>
                <li><strong>Cortes realizados:</strong> Cantidad de cortes completados esta semana.</li>
                <li><strong>Total de servicios:</strong> Cantidad total de servicios realizados esta semana.</li>
                <li><strong>Tu ganancia (50%):</strong> El ingreso del barbero, calculado como el 50% del total facturado.</li>
                <li><strong>Desglose de servicios:</strong> Lista detallada de cada servicio realizado con su cantidad.</li>
            </ul>

            <h3 id="barbero-turnos">21.2. Turnos del barbero</h3>
            <p>
                En esta sección, el barbero ve sus turnos de la semana en curso. Para cada turno se muestra:
            </p>
            <ul>
                <li>Fecha y hora del turno.</li>
                <li>Nombre del cliente.</li>
                <li>Estado del turno: Pendiente, Realizado o Cancelado.</li>
                <li>Documento del cliente.</li>
            </ul>
            <p>
                El barbero puede cambiar el estado de un turno seleccionando el nuevo estado en el campo desplegable y confirmando.
                También puede crear nuevos turnos para sus clientes.
            </p>

            <h3 id="barbero-horario">21.3. Horario del barbero</h3>
            <p>
                En esta sección, el barbero puede consultar su horario semanal asignado. Es una vista de solo lectura.
                La tabla muestra el día, la fecha, la hora de inicio, la hora de fin y el estado de cada jornada.
                El día actual aparece resaltado para fácil identificación.
            </p>

            <h3 id="barbero-perfil">21.4. Perfil del barbero</h3>
            <p>
                El barbero puede actualizar su información personal: nombre de usuario, número de documento y contraseña.
            </p>
        </section>

        {{-- ==============================
             SECCIÓN 22: CORREOS AUTOMÁTICOS
             ============================== --}}
        <section id="seccion-correos" class="manual-seccion" aria-labelledby="titulo-correos">
            <h2 id="titulo-correos">22. Correos electrónicos automáticos</h2>
            <p>
                El sistema envía correos electrónicos de forma automática cuando ocurren ciertos eventos. No necesitas enviar estos correos manualmente, el sistema lo hace por ti. Los correos automáticos son:
            </p>
            <ul>
                <li><strong>Confirmación de turno al cliente:</strong> Cuando se agenda una cita, el cliente recibe un correo con los detalles de su turno: fecha, hora, barbero y servicio.</li>
                <li><strong>Notificación al administrador:</strong> Cuando se agenda un nuevo turno, el administrador recibe un correo informando del nuevo turno.</li>
                <li><strong>Notificación al barbero:</strong> Cuando se le asigna un turno, el barbero recibe un correo con la información de la cita.</li>
                <li><strong>Pago pendiente:</strong> Cuando un cliente realiza un pago de anticipo, se envía un correo indicando que el pago está pendiente de verificación.</li>
                <li><strong>Pago confirmado:</strong> Cuando el administrador confirma el pago del anticipo, el cliente recibe un correo confirmando que su pago fue aceptado.</li>
                <li><strong>Fidelización:</strong> Cuando un cliente alcanza el hito de visitas necesario para un corte gratis, recibe un correo de felicitación.</li>
                <li><strong>Factura:</strong> Cuando se genera una factura, se puede enviar al cliente por correo.</li>
                <li><strong>Promociones:</strong> El sistema puede enviar correos con promociones especiales a los clientes.</li>
                <li><strong>Formulario de contacto:</strong> Cuando un visitante envía un mensaje desde la página de contacto, el correo llega al administrador.</li>
                <li><strong>Recuperación de contraseña:</strong> Cuando un usuario solicita restablecer su contraseña, recibe un correo con el enlace para hacerlo.</li>
            </ul>
        </section>

        {{-- ==============================
             SECCIÓN 23: ATAJOS DE TECLADO
             ============================== --}}
        <section id="seccion-atajos" class="manual-seccion" aria-labelledby="titulo-atajos">
            <h2 id="titulo-atajos">23. Atajos de teclado</h2>
            <p>
                A continuación encontrarás los atajos de teclado más útiles para navegar por el sistema sin necesidad de usar el ratón:
            </p>
            <dl>
                <dt><kbd>Tab</kbd></dt>
                <dd>Avanza al siguiente elemento interactivo de la página, como un botón, enlace o campo de formulario.</dd>

                <dt><kbd>Shift</kbd> + <kbd>Tab</kbd></dt>
                <dd>Retrocede al elemento interactivo anterior.</dd>

                <dt><kbd>Enter</kbd></dt>
                <dd>Activa el botón o enlace que está seleccionado en ese momento. Equivale a hacer clic sobre él.</dd>

                <dt><kbd>Espacio</kbd></dt>
                <dd>Activa casillas de verificación o botones. También permite desplazarse hacia abajo en la página.</dd>

                <dt><kbd>Escape</kbd></dt>
                <dd>Cierra ventanas emergentes, cuadros de diálogo o menús desplegables.</dd>

                <dt><kbd>Flechas arriba y abajo</kbd></dt>
                <dd>Navegan entre opciones dentro de un menú desplegable, una lista de selección o los campos de un formulario.</dd>

                <dt><kbd>Flechas izquierda y derecha</kbd></dt>
                <dd>Navegan entre pestañas, días del calendario o elementos de una barra de herramientas.</dd>

                <dt><kbd>Alt</kbd> + <kbd>Flecha abajo</kbd></dt>
                <dd>Abre un menú desplegable o lista de opciones.</dd>

                <dt><kbd>Ctrl</kbd> + <kbd>Home</kbd></dt>
                <dd>Ir al inicio de la página.</dd>

                <dt><kbd>Ctrl</kbd> + <kbd>End</kbd></dt>
                <dd>Ir al final de la página.</dd>
            </dl>
        </section>

        {{-- ==============================
             SECCIÓN 24: LECTORES DE PANTALLA
             ============================== --}}
        <section id="seccion-lectores-pantalla" class="manual-seccion" aria-labelledby="titulo-lectores-pantalla">
            <h2 id="titulo-lectores-pantalla">24. Uso con lectores de pantalla</h2>
            <p>
                Este sistema es compatible con los principales lectores de pantalla. A continuación se explica brevemente cada uno:
            </p>

            <h3 id="lector-nvda">24.1. NVDA (gratuito, para Windows)</h3>
            <p>
                NVDA es un lector de pantalla gratuito y de código abierto para Windows.
                Puedes descargarlo desde su sitio oficial. Algunos atajos útiles de NVDA para navegar este sistema:
            </p>
            <ul>
                <li>Presiona <kbd>H</kbd> para saltar al siguiente encabezado.</li>
                <li>Presiona <kbd>1</kbd>, <kbd>2</kbd> o <kbd>3</kbd> para ir a encabezados de nivel 1, 2 o 3.</li>
                <li>Presiona <kbd>T</kbd> para saltar a la siguiente tabla.</li>
                <li>Presiona <kbd>F</kbd> para ir al siguiente campo de formulario.</li>
                <li>Presiona <kbd>B</kbd> para ir al siguiente botón.</li>
                <li>Presiona <kbd>K</kbd> para ir al siguiente enlace.</li>
                <li>Presiona <kbd>L</kbd> para ir a la siguiente lista.</li>
                <li>Presiona <kbd>Insert</kbd> + <kbd>Espacio</kbd> para alternar entre modo exploración y modo foco.</li>
            </ul>

            <h3 id="lector-jaws">24.2. JAWS (para Windows)</h3>
            <p>
                JAWS es un lector de pantalla profesional para Windows. Los atajos son similares a NVDA:
            </p>
            <ul>
                <li>Presiona <kbd>H</kbd> para saltar al siguiente encabezado.</li>
                <li>Presiona <kbd>T</kbd> para saltar a la siguiente tabla.</li>
                <li>Presiona <kbd>F</kbd> para ir al siguiente campo de formulario.</li>
                <li>Presiona <kbd>Insert</kbd> + <kbd>F6</kbd> para ver la lista de encabezados de la página.</li>
                <li>Presiona <kbd>Insert</kbd> + <kbd>F7</kbd> para ver la lista de enlaces de la página.</li>
            </ul>

            <h3 id="lector-voiceover">24.3. VoiceOver (para Mac y dispositivos Apple)</h3>
            <p>
                VoiceOver viene integrado en los dispositivos Apple. Se activa desde Configuración, Accesibilidad.
            </p>
            <ul>
                <li>En Mac, presiona <kbd>Command</kbd> + <kbd>F5</kbd> para activar o desactivar VoiceOver.</li>
                <li>Usa <kbd>Control</kbd> + <kbd>Option</kbd> + flechas para navegar por la página.</li>
                <li>En iPhone o iPad, desliza hacia la derecha con un dedo para ir al siguiente elemento y hacia la izquierda para retroceder.</li>
                <li>Toca dos veces para activar un elemento (equivale a presionar <kbd>Enter</kbd>).</li>
            </ul>
        </section>

        {{-- ==============================
             SECCIÓN 25: MEMBRESÍAS
             ============================== --}}
        <section id="seccion-membresias" class="manual-seccion" aria-labelledby="titulo-membresias">
            <h2 id="titulo-membresias">25. Módulo de Membresías</h2>
            <p>
                El módulo de Membresías permite crear planes de suscripción que los clientes pueden adquirir para obtener
                beneficios exclusivos: servicios gratis o descuentos en servicios seleccionados.
                Para acceder ve al menú lateral y selecciona <strong>Membresías</strong>.
            </p>

            <h3>Crear una nueva membresía</h3>
            <ol>
                <li>Selecciona el botón <strong>+ Crear membresía</strong> y presiona <kbd>Enter</kbd>.</li>
                <li>Completa el formulario:
                    <ul>
                        <li><strong>Nombre:</strong> Nombre del plan (ej. "Membresía Oro").</li>
                        <li><strong>Descripción:</strong> Texto opcional que explica los beneficios.</li>
                        <li><strong>Precio:</strong> Cuánto paga el cliente por la membresía.</li>
                        <li><strong>Duración:</strong> Elige entre 1, 3, 6 o 12 meses.</li>
                        <li><strong>Tipo de beneficio:</strong>
                            <ul>
                                <li><em>Gratis:</em> El cliente puede recibir servicios sin costo adicional.</li>
                                <li><em>Porcentaje de descuento:</em> Se aplica un % de descuento sobre el precio del servicio.</li>
                            </ul>
                        </li>
                        <li><strong>Límite de usos:</strong> Cuántas veces puede usar el beneficio. Escribe 0 para uso ilimitado.</li>
                        <li><strong>Servicios aplicables:</strong> Selecciona a cuáles servicios aplica el beneficio.</li>
                        <li><strong>Orden:</strong> Número que controla el orden de aparición en el listado público.</li>
                        <li><strong>Imagen:</strong> Foto o logo del plan (JPG, PNG, máx. 2 MB).</li>
                    </ul>
                </li>
                <li>Selecciona <strong>Crear membresía</strong> para guardar.</li>
            </ol>

            <h3>Activar o desactivar una membresía</h3>
            <p>
                En la lista de membresías cada fila muestra el estado (Activa / Inactiva).
                Usa el botón <strong>Activar</strong> o <strong>Desactivar</strong> para cambiar el estado sin eliminarla.
                Una membresía inactiva no aparece en el sitio público.
            </p>

            <h3>Editar una membresía</h3>
            <p>
                Selecciona el botón <strong>Editar</strong> de la membresía que quieres modificar.
                Cambia los campos necesarios y guarda. Si cambias la imagen, la anterior se elimina automáticamente.
            </p>

            <h3>Eliminar una membresía</h3>
            <p>
                Solo puedes eliminar una membresía si <strong>no tiene clientes con suscripción activa</strong>.
                Si lo intentas y hay clientes activos, el sistema te avisará y no permitirá la eliminación.
                Primero cancela o vence las suscripciones de esos clientes.
            </p>

            <h3>Gestión de clientes con membresías</h3>
            <ol>
                <li>Selecciona el botón <strong>👥 Clientes con membresías</strong> para ver el listado completo.</li>
                <li>Puedes filtrar por estado (activa, vencida, cancelada) y por tipo de membresía.</li>
                <li>Para asignar una membresía a un cliente:
                    <ul>
                        <li>Ingresa la <strong>cédula del cliente</strong>.</li>
                        <li>Selecciona la membresía y la fecha de inicio.</li>
                        <li>La fecha de vencimiento se calcula automáticamente según la duración del plan.</li>
                    </ul>
                </li>
                <li>Para cancelar la suscripción de un cliente usa el botón <strong>Cancelar</strong> en la fila correspondiente.</li>
            </ol>
        </section>

        {{-- ==============================
             SECCIÓN 26: GASTOS
             ============================== --}}
        <section id="seccion-gastos" class="manual-seccion" aria-labelledby="titulo-gastos">
            <h2 id="titulo-gastos">26. Módulo de Gastos</h2>
            <p>
                El módulo de Gastos permite registrar todos los egresos del negocio (arriendo, suministros, nómina, etc.)
                y generar reportes financieros comparando ingresos vs. gastos para ver la ganancia neta.
                Para acceder ve al menú lateral y selecciona <strong>Gastos</strong>.
            </p>

            <h3>Registrar un nuevo gasto</h3>
            <ol>
                <li>Selecciona el botón <strong>+ Nuevo gasto</strong> y presiona <kbd>Enter</kbd>.</li>
                <li>Completa el formulario:
                    <ul>
                        <li><strong>Categoría:</strong> Clasifica el gasto (arriendo, servicios públicos, suministros, etc.).</li>
                        <li><strong>Sede:</strong> Selecciona la sede a la que pertenece el gasto (opcional).</li>
                        <li><strong>Descripción:</strong> Escribe una descripción clara del gasto.</li>
                        <li><strong>Monto:</strong> El valor del gasto en pesos.</li>
                        <li><strong>Fecha:</strong> La fecha en que se realizó el gasto.</li>
                        <li><strong>Comprobante:</strong> Adjunta el soporte (PDF, JPG o PNG, máx. 5 MB). Este campo es opcional.</li>
                    </ul>
                </li>
                <li>Selecciona <strong>Guardar gasto</strong>.</li>
            </ol>

            <h3>Filtrar gastos</h3>
            <p>
                En la página principal del módulo puedes filtrar por:
            </p>
            <ul>
                <li><strong>Rango de fechas:</strong> Desde y hasta.</li>
                <li><strong>Categoría</strong> de gasto.</li>
                <li><strong>Sede.</strong></li>
                <li><strong>Búsqueda por descripción.</strong></li>
            </ul>
            <p>Al fondo de la lista aparece el <strong>total de gastos</strong> del período filtrado.</p>

            <h3>Editar o eliminar un gasto</h3>
            <p>
                Cada fila tiene botones de <strong>Editar</strong> y <strong>Eliminar</strong>.
                Al eliminar un gasto también se elimina el comprobante adjunto si lo tenía.
            </p>

            <h3>Exportar a Excel</h3>
            <p>
                Usa el botón <strong>Exportar Excel</strong> para descargar los gastos del período filtrado en formato XLS.
            </p>

            <h3>Reporte financiero (Ingresos vs. Gastos)</h3>
            <ol>
                <li>Selecciona el botón <strong>Reporte Financiero</strong>.</li>
                <li>El reporte muestra:
                    <ul>
                        <li><strong>Total de ingresos</strong> (suma de facturas del período).</li>
                        <li><strong>Total de gastos</strong> del período.</li>
                        <li><strong>Ganancia neta</strong> (ingresos − gastos).</li>
                        <li><strong>Desglose por categoría</strong> de gasto.</li>
                    </ul>
                </li>
                <li>Puedes exportar este reporte a Excel con el botón <strong>Exportar reporte</strong>.</li>
            </ol>
        </section>

        {{-- ==============================
             SECCIÓN 27: PERFIL Y WHATSAPP
             ============================== --}}
        <section id="seccion-perfil" class="manual-seccion" aria-labelledby="titulo-perfil">
            <h2 id="titulo-perfil">27. Módulo de Perfil y Configuración de WhatsApp</h2>
            <p>
                El módulo de Perfil agrupa la gestión de tu cuenta personal y la configuración de los botones de contacto
                por WhatsApp que aparecen en el sitio web público. Para acceder ve a <strong>Configuración</strong>
                en el menú lateral.
            </p>

            <h3>Actualizar información personal</h3>
            <ol>
                <li>Selecciona la tarjeta <strong>Información Personal</strong>.</li>
                <li>Puedes actualizar:
                    <ul>
                        <li><strong>Usuario:</strong> Tu nombre de acceso al sistema.</li>
                        <li><strong>Documento:</strong> Tu número de cédula o identificación.</li>
                        <li><strong>Nombres y apellidos.</strong></li>
                        <li><strong>Correo electrónico:</strong> Se usa para recibir notificaciones del sistema.</li>
                        <li><strong>Celular.</strong></li>
                    </ul>
                </li>
                <li>Presiona <strong>Guardar cambios</strong>.</li>
            </ol>

            <h3>Cambiar la contraseña</h3>
            <ol>
                <li>En la misma página de Información Personal, desplázate a la sección <strong>Cambiar contraseña</strong>.</li>
                <li>Ingresa tu <strong>contraseña actual</strong>.</li>
                <li>Escribe la <strong>nueva contraseña</strong> (mínimo 8 caracteres, al menos una letra mayúscula y un número).</li>
                <li>Repite la nueva contraseña en el campo <strong>Confirmar contraseña</strong>.</li>
                <li>Presiona <strong>Cambiar contraseña</strong>.</li>
            </ol>

            <h3>Cambiar la foto de perfil</h3>
            <ol>
                <li>En la página de Configuración selecciona <strong>Foto de Perfil</strong>.</li>
                <li>Haz clic en <strong>Seleccionar imagen</strong> y elige un archivo JPG, PNG o GIF de máximo 2 MB.</li>
                <li>Presiona <strong>Guardar foto</strong>. La imagen aparecerá en el menú lateral y en tu perfil.</li>
                <li>Para eliminar la foto actual presiona <strong>Eliminar foto</strong>.</li>
            </ol>

            <h3>Configurar los botones de WhatsApp del sitio público</h3>
            <p>
                El sitio web tiene botones de WhatsApp que los clientes usan para contactar la barbería directamente
                desde el sitio (inicio, servicios, contacto, etc.). El número que aparece en esos botones se configura aquí.
            </p>
            <ol>
                <li>Selecciona la tarjeta <strong>Redes Sociales y WhatsApp</strong> en la página de Configuración.</li>
                <li>En el campo <strong>WhatsApp</strong> escribe el número de la barbería
                    en formato internacional sin espacios ni guiones, por ejemplo: <code>573001234567</code>.
                    El prefijo de Colombia es <code>57</code>, seguido del número de celular de 10 dígitos.
                </li>
                <li>Opcionalmente completa los enlaces de:
                    <ul>
                        <li><strong>Instagram</strong> — URL completa del perfil.</li>
                        <li><strong>Facebook</strong> — URL completa de la página.</li>
                        <li><strong>TikTok</strong> — URL completa del perfil.</li>
                        <li><strong>YouTube</strong> — URL completa del canal.</li>
                    </ul>
                </li>
                <li>Presiona <strong>Guardar configuración</strong>.</li>
                <li>El cambio se aplica de inmediato: todos los botones de WhatsApp y los iconos de redes sociales
                    del sitio público empezarán a usar los nuevos datos.</li>
            </ol>

            <div class="manual-nota">
                <strong>Importante:</strong> El número de WhatsApp debe estar <strong>sin espacios, guiones ni paréntesis</strong>.
                Si lo ingresas mal, el botón de WhatsApp no funcionará en el sitio público.
                Ejemplo correcto: <code>573001234567</code>. Ejemplo incorrecto: <code>300 123 4567</code>.
            </div>

            <h3>¿En qué partes del sitio aparecen los botones de WhatsApp?</h3>
            <ul>
                <li><strong>Página de Inicio:</strong> Botón flotante y botón en la sección de contacto.</li>
                <li><strong>Página de Servicios:</strong> Botón para consultar un servicio por WhatsApp.</li>
                <li><strong>Página de Contacto:</strong> Enlace directo a WhatsApp.</li>
                <li><strong>Página de Fidelización:</strong> Botón <em>Consultar por WhatsApp</em>.</li>
                <li><strong>Footer del sitio:</strong> Ícono de WhatsApp con el enlace configurado.</li>
                <li><strong>Módulo CRM (panel de administración):</strong> Los clientes que llevan más de 2 meses sin visitar la barbería se resaltan en naranja. En su fila aparece un botón de WhatsApp para contactarlos directamente y recuperarlos.</li>
                <li><strong>Módulo de Turnos (panel de administración):</strong> En el detalle de cada turno o cliente hay un enlace de WhatsApp para comunicarse con el cliente de forma rápida.</li>
            </ul>
        </section>

        {{-- ==============================
             SECCIÓN 28: AYUDA
             ============================== --}}
        <section id="seccion-ayuda" class="manual-seccion" aria-labelledby="titulo-ayuda">
            <h2 id="titulo-ayuda">28. Dónde pedir ayuda</h2>
            <p>
                Si tienes alguna dificultad para usar el sistema, estas son las formas de obtener ayuda:
            </p>
            <ul>
                <li>
                    <strong>Contactar al administrador:</strong> Si eres barbero o empleado, comunícate con el administrador
                    del sistema. Él puede ayudarte con problemas de acceso, contraseñas o cualquier configuración.
                </li>
                <li>
                    <strong>WhatsApp de soporte:</strong> Si la barbería tiene configurado un número de WhatsApp,
                    puedes enviar un mensaje describiendo tu problema. El equipo de soporte te responderá lo antes posible.
                </li>
                <li>
                    <strong>Formulario de contacto:</strong> Desde la página pública de Contacto del sitio web,
                    puedes enviar un mensaje con tu consulta o problema.
                </li>
                <li>
                    <strong>Comunicación presencial:</strong> También puedes acudir a la sede de la barbería y pedir
                    asistencia directamente al personal. Estarán encantados de ayudarte.
                </li>
            </ul>
            <p>
                <strong>Recuerda:</strong> Este manual siempre está disponible desde el módulo de Configuración del sistema.
                Puedes volver a consultarlo en cualquier momento.
            </p>
        </section>

    </div>{{-- Fin de manual-contenido --}}

</div>{{-- Fin de manual-usuario-container --}}

{{-- Anuncio para lectores de pantalla --}}
<div id="sr-announcer" class="sr-only" aria-live="polite" aria-atomic="true"></div>

{{-- Script de Text-to-Speech para el botón Escuchar Manual --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    var btnEscuchar = document.getElementById('btn-escuchar-manual');
    var btnTexto = document.getElementById('btn-escuchar-texto');
    var manualContenido = document.getElementById('manual-contenido');
    var srAnnouncer = document.getElementById('sr-announcer');
    var estaHablando = false;
    var fragmentos = [];
    var fragmentoActual = 0;

    // Verificar soporte de SpeechSynthesis
    if (!('speechSynthesis' in window)) {
        btnEscuchar.disabled = true;
        btnTexto.textContent = 'Lectura en voz alta no disponible';
        btnEscuchar.setAttribute('aria-label', 'La lectura en voz alta no está disponible en este navegador');
        return;
    }

    /**
     * Obtiene el texto legible del contenido del manual,
     * excluyendo elementos decorativos y ocultos.
     */
    function obtenerTextoManual() {
        if (!manualContenido) return '';

        var clon = manualContenido.cloneNode(true);

        // Remover elementos decorativos
        var ocultos = clon.querySelectorAll('[aria-hidden="true"]');
        for (var i = 0; i < ocultos.length; i++) {
            ocultos[i].remove();
        }

        var texto = clon.textContent || clon.innerText || '';
        texto = texto.replace(/\s+/g, ' ').trim();
        return texto;
    }

    /**
     * Divide el texto en fragmentos para evitar el límite de SpeechSynthesis
     * en algunos navegadores (aproximadamente 200-300 caracteres por utterance).
     */
    function dividirEnFragmentos(texto) {
        var maxLength = 800;
        var partes = [];
        var oraciones = texto.split(/(?<=[.!?])\s+/);
        var fragmentoTemp = '';

        for (var i = 0; i < oraciones.length; i++) {
            if ((fragmentoTemp + ' ' + oraciones[i]).length > maxLength && fragmentoTemp.length > 0) {
                partes.push(fragmentoTemp.trim());
                fragmentoTemp = oraciones[i];
            } else {
                fragmentoTemp += ' ' + oraciones[i];
            }
        }
        if (fragmentoTemp.trim().length > 0) {
            partes.push(fragmentoTemp.trim());
        }

        return partes;
    }

    /**
     * Anuncia un mensaje para lectores de pantalla
     */
    function anunciar(mensaje) {
        if (srAnnouncer) {
            srAnnouncer.textContent = '';
            setTimeout(function() {
                srAnnouncer.textContent = mensaje;
            }, 100);
        }
    }

    /**
     * Lee el siguiente fragmento del manual
     */
    function leerSiguienteFragmento() {
        if (fragmentoActual >= fragmentos.length) {
            // Se terminaron todos los fragmentos
            estaHablando = false;
            btnTexto.textContent = 'Escuchar manual';
            btnEscuchar.setAttribute('aria-pressed', 'false');
            anunciar('La lectura del manual ha finalizado.');
            return;
        }

        var utterance = new SpeechSynthesisUtterance(fragmentos[fragmentoActual]);
        utterance.lang = 'es-ES';
        utterance.rate = 0.9;
        utterance.pitch = 1;
        utterance.volume = 1;

        // Buscar voz en español
        var voces = window.speechSynthesis.getVoices();
        for (var i = 0; i < voces.length; i++) {
            if (voces[i].lang.indexOf('es') === 0) {
                utterance.voice = voces[i];
                break;
            }
        }

        utterance.onend = function() {
            fragmentoActual++;
            if (estaHablando) {
                leerSiguienteFragmento();
            }
        };

        utterance.onerror = function() {
            estaHablando = false;
            btnTexto.textContent = 'Escuchar manual';
            btnEscuchar.setAttribute('aria-pressed', 'false');
            anunciar('Ocurrió un error al intentar leer el manual.');
        };

        window.speechSynthesis.speak(utterance);
    }

    /**
     * Inicia la lectura en voz alta del manual
     */
    function iniciarLectura() {
        var texto = obtenerTextoManual();

        if (!texto) {
            anunciar('No se encontró contenido para leer.');
            return;
        }

        // Dividir en fragmentos para evitar cortes del navegador
        fragmentos = dividirEnFragmentos(texto);
        fragmentoActual = 0;

        estaHablando = true;
        btnTexto.textContent = 'Detener lectura';
        btnEscuchar.setAttribute('aria-pressed', 'true');
        anunciar('Lectura del manual iniciada.');

        leerSiguienteFragmento();
    }

    /**
     * Detiene la lectura en voz alta
     */
    function detenerLectura() {
        window.speechSynthesis.cancel();
        estaHablando = false;
        fragmentoActual = 0;
        btnTexto.textContent = 'Escuchar manual';
        btnEscuchar.setAttribute('aria-pressed', 'false');
        anunciar('Lectura del manual detenida.');
    }

    // Evento del botón: alternar lectura
    btnEscuchar.addEventListener('click', function() {
        if (estaHablando) {
            detenerLectura();
        } else {
            iniciarLectura();
        }
    });

    // Cargar voces (algunos navegadores las cargan de forma asíncrona)
    if (window.speechSynthesis.onvoiceschanged !== undefined) {
        window.speechSynthesis.onvoiceschanged = function() {};
    }

    // Detener lectura si el usuario navega fuera de la página
    window.addEventListener('beforeunload', function() {
        if (estaHablando) {
            window.speechSynthesis.cancel();
        }
    });
});
</script>

@endsection
