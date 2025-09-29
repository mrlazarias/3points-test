import tailwindcss from '@tailwindcss/vite';
import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/filament/admin/theme.css', 'resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    define: {
        'process.env.MIX_PUSHER_APP_KEY': JSON.stringify('local'),
        'process.env.MIX_PUSHER_HOST': JSON.stringify('localhost'),
        'process.env.MIX_PUSHER_PORT': JSON.stringify('8080'),
        'process.env.MIX_PUSHER_SCHEME': JSON.stringify('http'),
        'process.env.MIX_PUSHER_APP_CLUSTER': JSON.stringify(''),
    },
});
