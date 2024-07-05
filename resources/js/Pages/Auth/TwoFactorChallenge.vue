<script setup>
import InputError from '@/Components/InputError.vue';
import CenteredCardLayout from '@/Layouts/CenteredCardLayout.vue';
import {Button} from '@/shadcn/ui/button';
import {Card, CardContent, CardDescription, CardHeader, CardTitle} from '@/shadcn/ui/card';
import {Input} from '@/shadcn/ui/input';
import {Label} from '@/shadcn/ui/label';
import {useForm} from '@inertiajs/vue3';
import {nextTick, ref} from 'vue';

const recovery = ref(false);

const form = useForm({
    code: '',
    recovery_code: '',
});

const recoveryCodeInput = ref(null);
const codeInput = ref(null);

const toggleRecovery = async () => {
    recovery.value ^= true;

    await nextTick();

    if (recovery.value) {
        recoveryCodeInput.value.focus();
        form.code = '';
    } else {
        codeInput.value.focus();
        form.recovery_code = '';
    }
};

const submit = () => {
    form.post(route('two-factor.login'));
};
</script>

<template>
    <CenteredCardLayout title="Two-factor Confirmation">
        <Card class="mx-auto max-w-sm">
            <CardHeader>
                <CardTitle class="text-2xl">
                    Two-factor Confirmation
                </CardTitle>
                <CardDescription>
                    <template v-if="! recovery">
                        Please confirm access to your account by entering the authentication code provided by your
                        authenticator application.
                    </template>

                    <template v-else>
                        Please confirm access to your account by entering one of your emergency recovery codes.
                    </template>
                </CardDescription>
            </CardHeader>
            <CardContent>
                <form @submit.prevent="submit">
                    <div class="grid gap-4">
                        <div v-if="! recovery"
                             class="grid gap-2">
                            <Label for="code">Code</Label>
                            <Input
                                id="code"
                                type="text"
                                v-model="form.code"
                                inputmode="numeric"
                                autofocus
                                autocomplete="one-time-code"
                            />
                            <InputError class="mt-2" :message="form.errors.code"/>
                        </div>
                        <div v-else
                             class="grid gap-2">
                            <Label for="recovery_code">Recovery Code</Label>
                            <Input
                                id="recovery_code"
                                ref="recoveryCodeInput"
                                type="text"
                                v-model="form.recovery_code"
                                inputmode="numeric"
                                autocomplete="one-time-code"
                            />
                            <InputError class="mt-2" :message="form.errors.recovery_code"/>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="button"
                                    class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 underline cursor-pointer"
                                    @click.prevent="toggleRecovery">
                                <template v-if="! recovery">
                                    Use a recovery code
                                </template>

                                <template v-else>
                                    Use an authentication code
                                </template>
                            </button>
                        </div>
                        <Button type="submit"
                                class="w-full"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing">
                            Login
                        </Button>
                    </div>
                </form>
            </CardContent>
        </Card>
    </CenteredCardLayout>
</template>
