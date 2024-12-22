import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/custom.css', 'resources/js/custom.js'], // Replace Tailwind with custom.css
            refresh: true,
        }),
    ],
});
