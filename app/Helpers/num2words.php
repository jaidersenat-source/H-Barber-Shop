<?php

if (!function_exists('num2words')) {
    function num2words($number) {
        // Solo para números positivos
        $number = intval($number);
        if ($number === 0) return 'cero';
        if ($number === 1000000) return 'un millón';
        if ($number === 10000000) return 'diez millones';
        if ($number === 100000000) return 'cien millones';
        if ($number === 1000000000) return 'mil millones';

        $formatter = new \NumberFormatter('es', \NumberFormatter::SPELLOUT);
        $words = $formatter->format($number);
        // Quitar decimales
        $words = preg_replace('/\s+coma.*$/', '', $words);
        // Mejorar algunos casos
        $words = str_replace('uno', 'un', $words);
        return $words;
    }
}
