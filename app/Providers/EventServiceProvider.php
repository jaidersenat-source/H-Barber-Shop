<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        \App\Events\TurnoRegistrado::class => [
            \App\Listeners\EnviarCorreoTurnoCliente::class,
            \App\Listeners\NotificarAdminNuevoTurno::class,
            \App\Listeners\NotificarBarberoTurno::class,
        ],
        \App\Events\ClienteFidelizado::class => [
            \App\Listeners\EnviarCorreoFidelizacion::class,
        ],
        \App\Events\PromocionCreada::class => [
            \App\Listeners\EnviarPromocionClientes::class,
        ],
        // ...otros eventos
    ];
}