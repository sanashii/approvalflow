<script setup lang="ts">
import { ref, onMounted } from 'vue';

interface Props {
    show: boolean;
    stats?: {
        total_tasks: number;
        completed_tasks: number;
        in_progress_tasks: number;
        pending_tasks: number;
        high_priority_tasks: number;
        old_in_progress_tasks: number;
        completion_rate: number;
    } | null;
}

const props = defineProps<Props>();
const emit = defineEmits<{
    close: [];
}>();

const isVisible = ref(false);

onMounted(() => {
    if (props.show) {
        setTimeout(() => {
            isVisible.value = true;
        }, 100);
    }
});

const closeModal = () => {
    isVisible.value = false;
    setTimeout(() => {
        emit('close');
    }, 300);
};
</script>

<style>
.dropdown-enter-active, .dropdown-leave-active {
    transition: all 0.5s cubic-bezier(0.22, 1, 0.36, 1);
}
.dropdown-enter-from, .dropdown-leave-to {
    opacity: 0;
    transform: translateY(-2rem);
}
.dropdown-enter-to, .dropdown-leave-from {
    opacity: 1;
    transform: translateY(0);
}
</style>

<template>
    <Transition
        name="dropdown"
        mode="out-in"
        appear
    >
        <div v-if="show" class="w-full">
            <div
                class="relative overflow-hidden rounded-2xl bg-white text-left shadow-xl w-full transition-all duration-500 ease-out transform"
                :class="isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 -translate-y-8'"
            >
            <!-- Header -->
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                <div class="flex items-center">
                    <div>
                        <h3 class="text-lg font-bold text-white">Automation Complete!</h3>
                        <p class="text-green-100 text-sm">Workflow automation has been successfully executed</p>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="px-6 py-6">
                <!-- Statistics -->
                <div v-if="stats" class="bg-gray-50 rounded-xl p-4 mb-6">
                    <h5 class="text-sm font-semibold text-gray-900 mb-3 text-center">Updated Statistics</h5>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Tasks:</span>
                            <span class="font-semibold text-gray-900">{{ stats.total_tasks }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Completed:</span>
                            <span class="font-semibold text-green-600">{{ stats.completed_tasks }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">In Progress:</span>
                            <span class="font-semibold text-orange-600">{{ stats.in_progress_tasks }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Pending:</span>
                            <span class="font-semibold text-yellow-600">{{ stats.pending_tasks }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">High Priority:</span>
                            <span class="font-semibold text-red-600">{{ stats.high_priority_tasks }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Completion Rate:</span>
                            <span class="font-semibold text-blue-600">{{ stats.completion_rate }}%</span>
                        </div>
                    </div>
                </div>

                <!-- What happened -->
                <div class="bg-blue-50 rounded-xl p-4 mb-6">
                    <h5 class="text-sm font-semibold text-blue-900 mb-2">What happened:</h5>
                    <ul class="text-sm text-blue-800 space-y-1">
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Old "In Progress" tasks were auto-completed
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Overdue high priority tasks were flagged
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Task statistics were updated
                        </li>
                    </ul>
                </div>

                <!-- Actions -->
                <div class="flex justify-end">
                    <button
                        @click="closeModal"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white font-semibold rounded-xl hover:from-green-700 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Got it!
                    </button>
                </div>
            </div>
            </div>
        </div>
    </Transition>
</template>
