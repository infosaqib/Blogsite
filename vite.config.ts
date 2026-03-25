import { wayfinder } from '@laravel/vite-plugin-wayfinder';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import { defineConfig, type Plugin } from 'vite';

function apiDocsPlugin(): Plugin {
    return {
        name: 'api-docs',
        configureServer(server) {
            server.httpServer?.once('listening', () => {
                setTimeout(() => {
                    server.config.logger.info(
                        `  \x1b[32m➜\x1b[0m  API Docs: \x1b[36mhttp://localhost:8000/api/documentation\x1b[0m`,
                        { clear: false }
                    );
                }, 100);
            });
        },
    };
}

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.ts'],
            ssr: 'resources/js/ssr.ts',
            refresh: true,
        }),
        tailwindcss(),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        wayfinder({
            formVariants: true,
        }),
        apiDocsPlugin(),
    ],
});
