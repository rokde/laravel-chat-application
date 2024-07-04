<script setup lang="ts">
import {Breadcrumb, BreadcrumbItem, BreadcrumbLink, BreadcrumbList, BreadcrumbSeparator} from "@/shadcn/ui/breadcrumb";
import {HomeIcon} from "@heroicons/vue/24/outline/index";
import {route} from 'ziggy-js';

const props = withDefaults(defineProps<{
    items: {
        url?: string;
        label: string;
    }[]
}>(), {
    items: () => []
});
</script>

<template>
    <Breadcrumb class="hidden md:flex">
        <BreadcrumbList v-if="props.items.length">
            <BreadcrumbItem>
                <BreadcrumbLink as-child>
                    <a :href="route('dashboard')">
                        <HomeIcon class="w-4 h-4"/>
                    </a>
                </BreadcrumbLink>
            </BreadcrumbItem>
            <template v-for="(item, index) of props.items"
                      :key="index">
                <BreadcrumbSeparator/>
                <BreadcrumbItem>
                    <BreadcrumbLink as-child>
                        <a v-if="item.url" :href="item.url">
                            {{ item.label }}
                        </a>
                        <template v-else>
                            {{ item.label }}
                        </template>
                    </BreadcrumbLink>
                </BreadcrumbItem>
            </template>
        </BreadcrumbList>
    </Breadcrumb>
</template>
