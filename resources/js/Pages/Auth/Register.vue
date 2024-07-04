<script setup lang="ts">
import {Link, useForm} from '@inertiajs/vue3';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import {route} from 'ziggy-js';
import CenteredCardLayout from "@/Layouts/CenteredCardLayout.vue";
import {Card, CardContent, CardDescription, CardHeader, CardTitle} from "@/shadcn/ui/card";
import {Button} from "@/shadcn/ui/button";
import {Label} from "@/shadcn/ui/label";
import {Input} from "@/shadcn/ui/input";

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <CenteredCardLayout title="Register">
        <Card class="mx-auto max-w-sm">
            <CardHeader>
                <CardTitle class="text-2xl">
                    Register
                </CardTitle>
                <CardDescription>
                    Enter your credentials below to setup your account
                </CardDescription>
            </CardHeader>
            <CardContent>
                <form @submit.prevent="submit">
                    <div class="grid gap-4">
                        <div class="grid gap-2">
                            <Label for="name">Name</Label>
                            <Input
                                id="name"
                                type="text"
                                v-model="form.name"
                                required
                                autofocus
                                autocomplete="name"
                            />
                            <InputError class="mt-2" :message="form.errors.name"/>
                        </div>
                        <div class="grid gap-2">
                            <Label for="email">Email</Label>
                            <Input
                                id="email"
                                type="email"
                                v-model="form.email"
                                placeholder="my@email.com"
                                required
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
                        <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature"
                             class="grid gap-2">
                            <div class="items-top flex space-x-2">
                                <Checkbox
                                    id="remember"
                                    v-model:checked="form.terms"
                                    name="terms"
                                    required/>
                                <Label class="font-normal self-center" for="remember">
                                    I agree to the <a target="_blank" :href="route('terms.show')"
                                                      class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">Terms
                                    of Service</a> and <a target="_blank" :href="route('policy.show')"
                                                          class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">Privacy
                                    Policy</a>
                                </Label>
                                <InputError class="mt-2" :message="form.errors.terms"/>
                            </div>
                        </div>
                        <Button type="submit"
                                class="w-full"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing">
                            Register
                        </Button>
                    </div>
                    <div v-if="route().has('login')" class="mt-4 text-center text-sm">
                        Already registered?
                        <Link
                            :href="route('login')" class="underline">
                            Sign in
                        </Link>
                    </div>
                </form>
            </CardContent>
        </Card>
    </CenteredCardLayout>
</template>
