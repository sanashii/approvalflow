<script setup lang="ts">
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div
        class="grid grid-cols-6 gap-4 min-h-screen items-center pt-6 sm:justify-center sm:pt-0 h-full"
    >
        <!-- <div>
            <Link href="/">
                <ApplicationLogo class="h-20 w-20 fill-current text-gray-500" />
            </Link>
        </div> -->

        <div
            class="overflow-hidden bg-white px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg h-full"
            style="height: 100%; margin-top: 10%;"
        >
            <slot />
        </div>
    </div>
</template>
