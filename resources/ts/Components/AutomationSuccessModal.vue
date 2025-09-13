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

<template>
    <div v-if="show" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="closeModal"></div>

        <!-- Modal panel -->
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div 
                :class="[
                    'relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all duration-300 sm:my-8 sm:w-full sm:max-w-lg',
                    isVisible ? 'translate-y-0 opacity-100 scale-100' : 'translate-y-4 opacity-0 scale-95'
                ]"
            >
                <!-- Header -->
                <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-bold text-white">Automation Complete!</h3>
                            <p class="text-green-100 text-sm">Workflow automation has been successfully executed</p>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="px-6 py-6">
                    <div class="mb-6">
                        <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-green-100 rounded-full">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 text-center mb-2">Automation Workflows Executed</h4>
                        <p class="text-gray-600 text-center">Your task automation rules have been applied successfully!</p>
                    </div>

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
    </div>
</template>
