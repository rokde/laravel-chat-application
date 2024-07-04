<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import CenteredCardLayout from '@/Layouts/CenteredCardLayout.vue';
import {Card, CardContent, CardDescription, CardHeader, CardTitle} from '@/shadcn/ui/card/index.js';
import {useForm} from '@inertiajs/vue3';
import {route} from 'ziggy-js';
import {Label} from "@/shadcn/ui/label";
import {Input} from "@/shadcn/ui/input";
import {Button} from "@/shadcn/ui/button";

defineProps<{
    status: string
}>();

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <CenteredCardLayout title="Forgot Password">
        <Card class="mx-auto max-w-sm">
            <CardHeader>
                <CardTitle class="text-2xl">
                    Forgot Password?
                </CardTitle>
                <CardDescription>
                    Forgot your password? No problem. Just let us know your email address and we will email you a
                    password reset link that will allow you to choose a new one.

                    <div v-if="status" class="mt-4 font-medium text-sm text-green-600 dark:text-green-400">
                        {{ status }}
                    </div>
                </CardDescription>
            </CardHeader>
            <CardContent>
                <form @submit.prevent="submit">
                    <div class="grid gap-4">
                        <div class="grid gap-2">
                            <Label for="email">Email</Label>
                            <Input
                                id="email"
                                type="email"
                                v-model="form.email"
                                placeholder="my@email.com"
                                required
                                autofocus
                                autocomplete="username"
                            />
                            <InputError class="mt-2" :message="form.errors.email"/>
                        </div>
                        <Button type="submit"
                                class="w-full"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing">
                            Email Password Reset Link
                        </Button>
                    </div>
                </form>
            </CardContent>
        </Card>
    </CenteredCardLayout>
</template>
