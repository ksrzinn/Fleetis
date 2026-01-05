import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';

import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from 'ziggy-js';
import { Ziggy } from './ziggy';


import Vue3Toasity from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

import money from 'v-money3';
import { VueMaskDirective } from 'v-mask';

const vMaskV2 = VueMaskDirective;
const vMaskV3 = {
    beforeMount: vMaskV2.bind,
    updated: vMaskV2.componentUpdated,
    unmounted: vMaskV2.unbind
};

export function createInertiaBaseApp({
    name,
    store,
    components = [],
    plugins = [],
}) {
    createInertiaApp({
        title: title => `${title} - ${name}`,
        resolve: name =>
            resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
        setup({ el, app, props, plugin }) {
            const vueApp = createApp({ render: () => h(app, props) })
                .use(plugin)
                .use(ZiggyVue, Ziggy)
                .use(Vue3Toasity)
                .use(money)
                .directive('mask', vMaskV3);

            if (store) vueApp.use(store);

            plugins.forEach(p => vueApp.use(p));
            components.forEach(c => vueApp.component(c.name, c.component));

            vueApp.mount(el);
        },
    });

    InertiaProgress.init({ color: '#4B5563' });
}
