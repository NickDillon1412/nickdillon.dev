import {
    defineConfig
} from 'vite';
import laravel, {
    refreshPaths
} from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: [
                ...refreshPaths,
                'app/Livewire/**',
            ],
        }),
    ],
    // expose vite to the host - this allows vite to work
    // from docker containers
    server: {
        host: true
    }
});
