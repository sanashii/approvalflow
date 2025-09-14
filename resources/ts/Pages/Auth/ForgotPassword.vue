<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps<{
    status?: string;
}>();

const route = (window as any).route;

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <GuestLayout>
        <Head title="Forgot Password" />
            <div class="mb-4">
                <Link href="/login" class="text-blue-600 hover:underline flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Login
                </Link>
            </div>
            <h1 class="text-2xl font-bold py-3">Forgot your password?</h1>
            <div class="mb-4 text-sm text-gray-600">
                No problem. Just let us know your email
                address and we will email you a password reset link that will allow
                you to choose a new one.
            </div>

            <div
                v-if="status"
                class="mb-4 text-sm font-medium text-green-600"
            >
                {{ status }}
            </div>

            <form @submit.prevent="submit">
                <div class="mt-4">
                    <InputLabel for="email" value="Email" />

                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        required
                        autofocus
                        autocomplete="username"
                    />

                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="mt-4 flex items-center justify-end">
                    <PrimaryButton
                        :class="{ 'opacity-25': form.processing }"
                        :style="{ backgroundColor: '#007bff', color: 'white' }"
                        :disabled="form.processing"
                    >
                        Email Password Reset Link
                    </PrimaryButton>
                </div>
            </form>
           
    </GuestLayout>
</template>
