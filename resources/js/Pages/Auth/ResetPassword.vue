<script setup lang="ts">
import {useForm} from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import {route} from 'ziggy-js';
import CenteredCardLayout from "@/Layouts/CenteredCardLayout.vue";
import {Card, CardContent, CardDescription, CardHeader, CardTitle} from "@/shadcn/ui/card";
import {Label} from "@/shadcn/ui/label";
import {Input} from "@/shadcn/ui/input";
import {Button} from "@/shadcn/ui/button";

const props = defineProps<{
    email: string;
    token: string;
}>();

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.update'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <CenteredCardLayout title="Reset Password">
        <Card class="mx-auto max-w-sm">
            <CardHeader>
                <CardTitle class="text-2xl">
                    Reset Password
                </CardTitle>
                <CardDescription>
                    Enter a new password to re-activate your account
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
                            <Label for="password">Password</Label>
                            <Input
                                id="password"
                                type="password"
                                v-model="form.password"
                                required
                                autocomplete="new-password"
                            />
                            <InputError class="mt-2" :message="form.errors.password"/>
                        </div>
                        <div class="grid gap-2">
                            <Label for="password_confirmation">Confirm Password</Label>
                            <Input
                                id="password_confirmation"
                                type="password"
                                v-model="form.password_confirmation"
                                required
                                autocomplete="new-password"
                            />
                            <InputError class="mt-2" :message="form.errors.password_confirmation"/>
                        </div>
                        <Button type="submit"
                                class="w-full"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing">
                            Reset Password
                        </Button>
                    </div>
                </form>
            </CardContent>
        </Card>
    </CenteredCardLayout>
</template>
