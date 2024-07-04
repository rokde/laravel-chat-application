<script setup lang="ts">
import {Avatar, AvatarFallback, AvatarImage} from '@/shadcn/ui/avatar'
import {computed} from 'vue';
import {cva, type VariantProps} from 'class-variance-authority';
import {cn} from '@/lib/utils';

const statusVariant = cva(
    'w-3 h-3 rounded-full absolute bottom-0.5 right-0.5 border-2',
    {
        variants: {
            status: {
                online: 'bg-emerald-600 border-emerald-200',
                offline: 'bg-gray-300 border-gray-50',
                away: 'bg-amber-500 border-amber-200',
                busy: 'bg-red-600 border-red-200',
            },
        },
    },
)

type AvatarStatusVariants = VariantProps<typeof statusVariant>

const props = defineProps<{
    name: string
    imageUrl?: string
    status?: AvatarStatusVariants['status']
}>()

const initials = computed(() => {
    return (props.name ?? '').split(' ').map(c => c[0]).join('');
})
</script>

<template>
    <div v-if="props.status" class="relative inline-block">
        <Avatar>
            <AvatarImage v-if="props.imageUrl" :src="props.imageUrl" :alt="props.name"/>
            <AvatarFallback>{{ initials }}</AvatarFallback>
        </Avatar>
        <span :class="cn(statusVariant({status}))"></span>
    </div>
    <Avatar v-else>
        <AvatarImage v-if="props.imageUrl" :src="props.imageUrl" :alt="props.name"/>
        <AvatarFallback>{{ initials }}</AvatarFallback>
    </Avatar>
</template>
