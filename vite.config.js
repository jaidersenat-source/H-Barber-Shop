import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/Barberos/layout.css',
                'resources/css/Barberos/dashboard.css',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
