<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import CenteredCardLayout from '@/Layouts/CenteredCardLayout.vue';
import {route} from 'ziggy-js';

import {Button} from '@/shadcn/ui/button'
import {Card, CardContent, CardDescription, CardHeader, CardTitle} from '@/shadcn/ui/card'
import {Checkbox} from '@/shadcn/ui/checkbox'
import {Input} from '@/shadcn/ui/input'
import {Label} from '@/shadcn/ui/label'
import {Link, useForm} from '@inertiajs/vue3';

defineProps<{
    canResetPassword: boolean;
    status?: string;
}>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <CenteredCardLayout title="Log in">
        <Card class="mx-auto max-w-sm">
            <CardHeader>
                <CardTitle class="text-2xl">
                    Login
                </CardTitle>
                <CardDescription>
                    Enter your email below to login to your account

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
                        <div class="grid gap-2">
                            <div class="flex items-center">
                                <Label for="password">Password</Label>
                                <Link v-if="canResetPassword"
                                      :href="route('password.request')"
                                      class="ml-auto inline-block text-sm underline">
                                    Forgot your password?
                                </Link>
                            </div>
                            <Input
                                id="password"
                                type="password"
                                v-model="form.password"
                                required
                                autocomplete="current-password"
                            />
                            <InputError class="mt-2" :message="form.errors.password"/>
                        </div>
                        <div class="grid gap-2">
                            <div class="items-top flex space-x-2">
                                <Checkbox id="remember" v-model:checked="form.remember" name="remember"/>
                                <Label class="font-normal self-center" for="remember">Remember me</Label>
                            </div>
                        </div>
                        <Button type="submit"
                                class="w-full"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing">
                            Login
                        </Button>
                        <!-- Button variant="outline" class="w-full">
                            Login with Google
                        </Button -->
                    </div>
                    <div v-if="route().has('register')" class="mt-4 text-center text-sm">
                        Don't have an account?
                        <Link
                            :href="route('register')" class="underline">
                            Sign up
                        </Link>
                    </div>
                </form>
            </CardContent>
        </Card>
    </CenteredCardLayout>
</template>
