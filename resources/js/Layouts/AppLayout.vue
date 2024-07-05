<script setup lang="ts">
import Banner from '@/Components/Banner.vue';
import CollaborationLayer from '@/Layers/CollaborationLayer.vue';
import MobileNavigation from '@/Layouts/Partials/MobileNavigation.vue';
import Navigation from '@/Layouts/Partials/Navigation.vue';
import {Sheet, SheetContent, SheetTrigger} from '@/shadcn/ui/sheet';
import {Bars3Icon} from "@heroicons/vue/24/solid";
import {Button} from '@/shadcn/ui/button'
import {Head, router} from '@inertiajs/vue3';
import {route} from 'ziggy-js';
import BreadcrumbNavigation from "@/Layouts/Partials/BreadcrumbNavigation.vue";
import SearchForm from "@/Layouts/Partials/SearchForm.vue";
import UserMenu from "@/Layouts/Partials/UserMenu.vue";
import TeamMenu from "@/Layouts/Partials/TeamMenu.vue";

const props = withDefaults(defineProps<{
    title: string;
    breadcrumb?: {
        url?: string;
        label: string;
    }[];
    withSearch?: boolean;
}>(), {
    breadcrumb: () => [],
    withSearch: false,
});

const logout = () => {
    router.post(route('logout'));
};

defineEmits(['search']);
</script>

<template>
    <CollaborationLayer>
        <Head :title="props.title"/>

        <Banner/>

        <div class="flex min-h-screen w-full flex-col bg-muted/40">
            <!-- desktop: sidebar -->
            <aside class="fixed inset-y-0 left-0 z-10 hidden w-14 flex-col border-r bg-background sm:flex">
                <Navigation/>
            </aside>

            <div class="flex flex-col sm:gap-4 sm:py-4 sm:pl-14">
                <header
                    class="sticky top-0 z-30 flex h-14 items-center gap-4 border-b bg-background px-4 sm:static sm:h-auto sm:border-0 sm:bg-transparent sm:px-6">
                    <!-- mobile: hamburger menu -->
                    <Sheet>
                        <SheetTrigger as-child>
                            <Button size="icon" variant="outline" class="sm:hidden">
                                <Bars3Icon class="h-5 w-5"/>
                                <span class="sr-only">Toggle Menu</span>
                            </Button>
                        </SheetTrigger>
                        <SheetContent side="left" class="sm:max-w-xs">
                            <MobileNavigation/>
                        </SheetContent>
                    </Sheet>
                    <!-- desktop: breadcrumb -->
                    <BreadcrumbNavigation :items="props.breadcrumb"/>
                    <!-- all: search -->
                    <SearchForm v-if="props.withSearch"
                                @search="$emit('search', $event)"/>
                    <div v-else class="ml-auto flex-1 md:grow-0"></div>
                    <!-- all: user menu -->
                    <TeamMenu v-if="$page.props.jetstream.hasTeamFeatures"/>
                    <!-- all: user menu -->
                    <UserMenu/>
                </header>
                <!-- Page Content -->
                <main class="grid flex-1 items-start gap-4 p-4 sm:px-6 sm:py-0 md:gap-8">
                    <slot/>

                    <div v-if="$slots.header" class="bg-red-500 shadow">
                        Diese Seite verwendet noch den alten Slot "header"!

                        <header v-if="$slots.header" class="bg-white dark:bg-gray-800 shadow">
                            <div class="mx-auto py-6 px-4 sm:px-6 lg:px-8">
                                <slot name="header"/>
                            </div>
                        </header>
                    </div>
                </main>
            </div>
        </div>
    </CollaborationLayer>
</template>
