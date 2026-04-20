<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class TerminosController extends Controller
{
    /**
     * Descargar PDF de términos y condiciones
     */
    public function download()
    {
        try {
            // Intentar generar PDF usando DomPDF
            $pdf = Pdf::loadView('terms.terms');
            return $pdf->download('terminos_h_barber_shop.pdf');
        } catch (\Exception $e) {
            // Fallback: devolver un archivo de texto con el contenido de la vista
            $html = view('terms.terms')->render();
            // Limpiar etiquetas HTML básicas para texto plano
            $text = strip_tags($html);
            $filename = 'terminos_h_barber_shop.txt';
            return response()->streamDownload(function () use ($text) {
                echo $text;
            }, $filename, [
                'Content-Type' => 'text/plain; charset=utf-8'
            ]);
        }
    }
}
