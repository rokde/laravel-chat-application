<script setup>
import Banner from '@/Components/Banner.vue';
import FadeTransition from '@/Components/UI/Transitions/FadeTransition.vue';
import CollaborationLayer from '@/Layers/CollaborationLayer.vue';
import Navigation from '@/Navigation/Navigation.vue';
import {Head} from '@inertiajs/vue3';

// @see https://avian-demo.netlify.app/chat/1/

const props = defineProps({
    title: {
        type: String,
        require: true,
    },
});
</script>

<template>
    <CollaborationLayer>
        <Head :title="props.title"/>

        <div
            class="bg-white dark:bg-gray-900 transition-colors duration-500 w-screen h-screen text-black dark:text-white">

            <FadeTransition>

                <div class="relative md:static h-full flex flex-col md:flex-row overflow-hidden">
                    <Navigation class="order-1 md:-order-none"/>

                    <aside
                        class="w-full md:w-96 h-full px-5 md:p-0 flex flex-col overflow-visible transition-all duration-500 grow-1 md:grow-0 overflow-y-scroll md:overflow-visible scrollbar-hidden bg-gray-50 dark:bg-gray-800">
                        <div class="h-full flex flex-col">
                            <div v-if="$slots.sidebarHeader"
                                 class="w-full min-h-[5rem] max-h-fit px-5 py-6 flex justify-between items-center">
                                <slot name="sidebarHeader"/>
                            </div>
                            <div v-if="$slots.sidebarTop"
                                 class="px-5 pb-6 md:pb-5">
                                <slot name="sidebarTop"/>
                            </div>
                            <div v-if="$slots.sidebarContent"
                                 role="list"
                                 aria-label="conversations"
                                 class="w-full h-full scroll-smooth scrollbar-hidden"
                                 style="overflow: visible scroll;">
                                <slot name="sidebarContent"/>
                            </div>
                        </div>
                    </aside>
                    <main
                        class="absolute z-10 md:static grow h-full w-full md:w-fit scrollbar-hidden transition-all duration-500 left-[0rem]"
                        role="main">
                        <div class="h-full flex flex-col scrollbar-hidden">
                            <div v-if="$slots.fixedHeader"
                                 class="w-full">
                                <slot name="fixedHeader"/>
                            </div>

                            <div class="grow px-5 py-5 flex flex-col overflow-y-scroll scrollbar-hidden">
                                <slot/>
                            </div>

                            <div v-if="$slots.fixedFooter"
                                 class="w-full">
                                <slot name="fixedFooter"/>
                            </div>
                        </div>
                    </main>
                    <Banner/>
                </div>

            </FadeTransition>
        </div>
    </CollaborationLayer>
</template>
