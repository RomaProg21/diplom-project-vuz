import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/js/students.js',
                'resources/css/app.css',
                'resources/js/ocenka.js',
                'resources/js/sheduleExam.js',
                'resources/js/statments.js',
                'resources/js/predmets.js',
                'resources/js/online.js',
                'resources/js/progress.js',
                'resources/js/recordBook.js',
                'resources/js/info.js',
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
        },
    },
});
