<script setup lang="ts">
import {Input} from '@/shadcn/ui/input';
import {MagnifyingGlassIcon} from "@heroicons/vue/24/outline";
import {useKeyupEvent} from "@/lib/composables";

defineEmits<{
    (e: 'search', text: string): void
}>();

useKeyupEvent((event: KeyboardEvent) => {
    // console.log('keyup', event);
})
</script>

<template>
    <div class="relative ml-auto flex-1 md:grow-0">
        <MagnifyingGlassIcon class="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground"/>
        <Input
            type="search"
            placeholder="Search..."
            class="w-full rounded-lg bg-background pl-8 md:w-[200px] lg:w-[320px]"
            @keyup.enter="$emit('search', $event.target.value)"
        />
    </div>
</template>
