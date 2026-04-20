<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // View Composer: compartir conteo de comentarios pendientes con layout admin
        View::composer('admin.layout', function ($view) {
            $pendingComments = Cache::remember('comments.pending_count', 60, function () {
                return \App\Models\Comment::pending()->count();
            });
            $view->with('pendingComments', $pendingComments);
        });

        // Limitar creación de citas públicas: máx 5 por minuto por IP
        RateLimiter::for('agendar', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        // Limitar consultas de horarios: máx 20 por minuto por IP
        RateLimiter::for('consulta-horarios', function (Request $request) {
            return Limit::perMinute(20)->by($request->ip());
        });

        // Limitar formulario de contacto: máx 3 por minuto por IP
        RateLimiter::for('contacto', function (Request $request) {
            return Limit::perMinute(3)->by($request->ip());
        });

        // Limitar comentarios del blog: máx 5 por minuto por IP
        RateLimiter::for('comentarios', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });
    }
}
