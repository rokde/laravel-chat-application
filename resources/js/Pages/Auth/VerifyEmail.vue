<script setup lang="ts">
import {computed} from 'vue';
import {Link, useForm} from '@inertiajs/vue3';
import {route} from 'ziggy-js';
import CenteredCardLayout from "@/Layouts/CenteredCardLayout.vue";
import {Card, CardContent, CardDescription, CardHeader, CardTitle} from "@/shadcn/ui/card";
import {Button} from "@/shadcn/ui/button";

const props = defineProps<{
    status: string;
}>();

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
    <CenteredCardLayout title="Email Verification">
        <Card class="mx-auto max-w-sm">
            <CardHeader>
                <CardTitle class="text-2xl">
                    Email Verification
                </CardTitle>
                <CardDescription>
                    Before continuing, could you verify your email address by clicking on the link we just emailed to
                    you? If you didn't receive the email, we will gladly send you another.

                    <div v-if="verificationLinkSent"
                         class="mt-4 font-medium text-sm text-green-600 dark:text-green-400">
                        A new verification link has been sent to the email address you provided in your profile
                        settings.
                    </div>
                </CardDescription>
            </CardHeader>
            <CardContent>
                <form @submit.prevent="submit">
                    <div class="grid gap-4">
                        <Button type="submit"
                                class="w-full"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing">
                            Resend Verification Email
                        </Button>

                        <div class="grid gap-2">
                            <Link
                                :href="route('profile.show')"
                                class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                            >
                                Edit Profile
                            </Link>
                        </div>
                        <div class="grid gap-2">
                            <Link
                                :href="route('logout')"
                                method="post"
                                as="button"
                                class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 ms-2"
                            >
                                Log Out
                            </Link>
                        </div>
                    </div>
                </form>
            </CardContent>
        </Card>
    </CenteredCardLayout>
</template>
