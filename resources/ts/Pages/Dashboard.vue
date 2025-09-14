<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

// Make route function available in template
const route = (window as any).route;

interface Task {
    id: number;
    title: string;
    description: string | null;
    priority: 'Low' | 'Normal' | 'High';
    status: 'Pending' | 'In Progress' | 'Completed';
    created_at: string;
    updated_at: string;
}

interface TaskStats {
    total: number;
    pending: number;
    in_progress: number;
    completed: number;
}

interface Props {
    taskStats: TaskStats;
    recentTasks: Task[];
}

defineProps<Props>();
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Welcome back!
            </h2>
        </template>

        <div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 py-8">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <!-- Welcome Section -->
                <div class="mb-8">
                    <p class="text-gray-600">Here's what's happening with your tasks today.</p>
                </div>

                <!-- Task Statistics -->
                <div class="mb-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <!-- Total Tasks Card -->
                    <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 mb-1">Total Tasks</p>
                                <p class="text-3xl font-bold text-gray-900">{{ taskStats.total }}</p>
                            </div>
                            <div class="h-12 w-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Tasks Card -->
                    <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 mb-1">Pending</p>
                                <p class="text-3xl font-bold text-yellow-600">{{ taskStats.pending }}</p>
                            </div>
                            <div class="h-12 w-12 bg-gradient-to-r from-yellow-400 to-yellow-500 rounded-xl flex items-center justify-center">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- In Progress Tasks Card -->
                    <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 mb-1">In Progress</p>
                                <p class="text-3xl font-bold text-orange-600">{{ taskStats.in_progress }}</p>
                            </div>
                            <div class="h-12 w-12 bg-gradient-to-r from-orange-400 to-orange-500 rounded-xl flex items-center justify-center">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Completed Tasks Card -->
                    <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 mb-1">Completed</p>
                                <p class="text-3xl font-bold text-green-600">{{ taskStats.completed }}</p>
                            </div>
                            <div class="h-12 w-12 bg-gradient-to-r from-green-400 to-green-500 rounded-xl flex items-center justify-center">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Tasks -->
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">Recent Tasks</h3>
                            <p class="text-gray-600 mt-1">Your latest task updates</p>
                        </div>
                        <Link
                            :href="route('tasks.index')"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl"
                        >
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            View All Tasks
                        </Link>
                    </div>
                    
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="p-6">
                            <div v-if="recentTasks.length === 0" class="text-center py-12">
                                <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-medium text-gray-900 mb-2">No tasks yet</h4>
                                <p class="text-gray-500 mb-4">Get started by creating your first task</p>
                                <Link :href="route('tasks.index')" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                    Create Task
                                </Link>
                            </div>
                            <div v-else class="space-y-4">
                                <div
                                    v-for="task in recentTasks"
                                    :key="task.id"
                                    class="group p-4 border border-gray-200 rounded-xl hover:border-gray-300 hover:shadow-md transition-all duration-200 bg-gray-50/50 hover:bg-white"
                                >
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-lg font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">{{ task.title }}</h4>
                                            <p v-if="task.description" class="text-sm text-gray-600 mt-1 line-clamp-2">{{ task.description }}</p>
                                            <div class="flex items-center mt-3 space-x-3">
                                                <span
                                                    :class="{
                                                        'bg-yellow-100 text-yellow-800 border-yellow-200': task.status === 'Pending',
                                                        'bg-orange-100 text-orange-800 border-orange-200': task.status === 'In Progress',
                                                        'bg-green-100 text-green-800 border-green-200': task.status === 'Completed'
                                                    }"
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium border"
                                                >
                                                    {{ task.status }}
                                                </span>
                                                <span
                                                    :class="{
                                                        'bg-gray-100 text-gray-800 border-gray-200': task.priority === 'Low',
                                                        'bg-blue-100 text-blue-800 border-blue-200': task.priority === 'Normal',
                                                        'bg-red-100 text-red-800 border-red-200': task.priority === 'High'
                                                    }"
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium border"
                                                >
                                                    {{ task.priority }}
                                                </span>
                                                <span class="text-xs text-gray-500">
                                                    {{ new Date(task.created_at).toLocaleDateString() }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-4 flex-shrink-0">
                                            <div class="w-2 h-2 rounded-full bg-gray-300 group-hover:bg-blue-400 transition-colors"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
