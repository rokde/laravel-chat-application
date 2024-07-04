<script setup>
import InputError from '@/Components/InputError.vue';
import CenteredCardLayout from '@/Layouts/CenteredCardLayout.vue';
import {Button} from '@/shadcn/ui/button/index.js';
import {Card, CardContent, CardDescription, CardHeader, CardTitle} from '@/shadcn/ui/card/index.js';
import {Input} from '@/shadcn/ui/input/index.js';
import {Label} from '@/shadcn/ui/label/index.js';
import {useForm} from '@inertiajs/vue3';
import {ref} from 'vue';

const form = useForm({
    password: '',
});

const passwordInput = ref(null);

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => {
            form.reset();

            passwordInput.value.focus();
        },
    });
};
</script>

<template>
    <CenteredCardLayout title="Secure Area">
        <Card class="mx-auto max-w-sm">
            <CardHeader>
                <CardTitle class="text-2xl">
                    Secure Area
                </CardTitle>
                <CardDescription>
                    This is a secure area of the application. Please confirm your password before continuing.
                </CardDescription>
            </CardHeader>
            <CardContent>
                <form @submit.prevent="submit">
                    <div class="grid gap-4">
                        <div class="grid gap-2">
                            <Label for="password">Password</Label>
                            <Input
                                id="password"
                                ref="passwordInput"
                                type="password"
                                v-model="form.password"
                                placeholder="my@email.com"
                                required
                                autofocus
                                autocomplete="current-password"
                            />
                            <InputError class="mt-2" :message="form.errors.password"/>
                        </div>
                        <Button type="submit"
                                class="w-full"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing">
                            Confirm
                        </Button>
                    </div>
                </form>
            </CardContent>
        </Card>
    </CenteredCardLayout>
</template>
