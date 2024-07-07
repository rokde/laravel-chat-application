import type {Page} from '@inertiajs/core';
import {AxiosInstance} from 'axios';
import ziggyRoute, {Config as ZiggyConfig} from 'ziggy-js';
import Echo from "laravel-echo";

declare global {
    interface Window {
        axios: AxiosInstance;
        Echo: Echo;
    }

    var route: typeof ziggyRoute;
    var Ziggy: ZiggyConfig;
}

declare module 'vue' {
    interface ComponentCustomProperties {
        route: typeof ziggyRoute;
    }
}


declare module '@inertiajs/core' {
    interface PageProps extends Page<PageProps> {
        auth: inertia.Auth
        jetstream: inertia.Jetstream
        errors: inertia.Errors
        errorBags: inertia.ErrorBags
        flash: inertia.Flash
    }
}

declare module '@inertiajs/vue3' {
    export function usePage<T>(): Page<T>
}

declare module 'vue3-emoji-picker'
