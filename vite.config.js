import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        host: true,           // Allow external access
        cors: true,           // Enable CORS
        hmr: {
            host: 'localhost',
            port: 5173,
        },
    },
});