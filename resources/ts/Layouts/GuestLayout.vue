<script setup lang="ts">
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="flex min-h-screen items-center justify-center bg-gray-100">
        <div class="overflow-hidden bg-white px-6 py-4 sm:max-w-md sm:rounded-lg w-full">
            <slot />
        </div>
    </div>
</template>
