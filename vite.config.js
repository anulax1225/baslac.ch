import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { readFileSync } from "fs"

export default defineConfig(({ command, mode, isSsrBuild, isPreview }) => {
    if (command === 'serve') {
        // dev specific config
        return {
            server: {
                hmr: { host: 'baslac.lndo.site', protocol: 'wss' },
                host: true,
                https: {
                    cert: readFileSync('/lando/certs/appserver_nginx.baslac.crt'),
                    key: readFileSync('/lando/certs/appserver_nginx.baslac.key'),
                },
                // If you have multiple active apps, you might want to change the port number
                // to avoid conflicts
                port: 5173,
            },
            plugins: [
                laravel({
                    input: 'resources/js/app.js',
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
        }
    } else {
        // command === 'build'
        return {
            plugins: [
                laravel({
                    input: 'resources/js/app.js',
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
        }
    }

});
