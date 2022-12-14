import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
// import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/fonts/material-design-iconic-font/css/material-design-iconic-font.min.css',
                // 'resources/sass/app.scss',
                'node_modules/jquery/dist/jquery.js',
                'resources/js/app.js',
                'resources/js/functions.js',
            ],
            refresh: true,
        }),
        {
            name: 'blade',
            handleHotUpdate({ file, server }) {
                if (file.endsWith('.blade.php')) {
                    server.ws.send({
                        type: 'full-reload',
                        path: '*',
                    });
                }
            },
        }
    ],
    resolve: {
        alias: {
            '~jQuery': path.resolve(__dirname, 'node_modules/jquery'),
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
            // vue: 'vue/dist/vue.esm-bundler.js',
        },
    },
    build: {
        chunkSizeWarningLimit: 1600,
    },
});
