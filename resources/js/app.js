import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import PrimeVue from 'primevue/config';
import Aura from '@primevue/themes/aura';
import { definePreset } from '@primevue/themes';
import 'primeicons/primeicons.css'
import { ToastService } from 'primevue';

const appName = import.meta.env.VITE_APP_NAME || 'Direktorat Akademik dan Administrasi';
const daaPreset = definePreset(Aura, {
    semantic: {
        primary: {
            50: '#fff1f1',
            100: '#ffdfdf',
            200: '#ffc5c5',
            300: '#ff9d9d',
            400: '#ff6464',
            500: '#ff2d2d',
            600: '#ed1515',
            700: '#c80d0d',
            800: '#a50f0f',
            900: '#881414',
            950: '#4b0404'
        }
    }
})

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(PrimeVue, {
                theme: {
                    preset: daaPreset,
                    options: {
                        cssLayer: {
                            name: 'primevue',
                            order: 'tailwind-base, primevue, tailwind-utilities'
                        },
                        darkModeSelector: '.dark'
                    },
                }
            })
            .use(ToastService)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
