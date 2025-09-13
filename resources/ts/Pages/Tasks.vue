<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import AutomationSuccessModal from '@/Components/AutomationSuccessModal.vue';

interface Task {
    id: number;
    title: string;
    description: string | null;
    priority: 'Low' | 'Normal' | 'High';
    status: 'Pending' | 'In Progress' | 'Completed';
    created_at: string;
    updated_at: string;
}

interface Props {
    tasks: Task[];
}

const props = defineProps<Props>();

const showCreateForm = ref(false);
const editingTask = ref<Task | null>(null);
const showAutomationModal = ref(false);
const automationStats = ref<{
    total_tasks: number;
    completed_tasks: number;
    in_progress_tasks: number;
    pending_tasks: number;
    high_priority_tasks: number;
    old_in_progress_tasks: number;
    completion_rate: number;
} | null>(null);

const createForm = useForm({
    title: '',
    description: '',
    priority: 'Normal' as 'Low' | 'Normal' | 'High',
    status: 'Pending' as 'Pending' | 'In Progress' | 'Completed',
});

const editForm = useForm({
    title: '',
    description: '',
    priority: 'Normal' as 'Low' | 'Normal' | 'High',
    status: 'Pending' as 'Pending' | 'In Progress' | 'Completed',
});

const submitCreate = () => {
    createForm.post(route('tasks.store'), {
        onSuccess: () => {
            createForm.reset();
            showCreateForm.value = false;
        },
    });
};

const submitEdit = () => {
    if (editingTask.value) {
        editForm.patch(route('tasks.update', editingTask.value.id), {
            onSuccess: () => {
                editForm.reset();
                editingTask.value = null;
            },
        });
    }
};

const startEdit = (task: Task) => {
    editingTask.value = task;
    editForm.title = task.title;
    editForm.description = task.description || '';
    editForm.priority = task.priority;
    editForm.status = task.status;
};

const cancelEdit = () => {
    editingTask.value = null;
    editForm.reset();
};

const deleteTask = (taskId: number) => {
    if (confirm('Are you sure you want to delete this task?')) {
        useForm({}).delete(route('tasks.destroy', taskId));
    }
};

const updateStatus = (taskId: number, status: 'Pending' | 'In Progress' | 'Completed') => {
    useForm({ status }).patch(route('tasks.updateStatus', taskId));
};

const getPriorityColor = (priority: string) => {
    switch (priority) {
        case 'Low':
            return 'bg-gray-100 text-gray-800';
        case 'Normal':
            return 'bg-blue-100 text-blue-800';
        case 'High':
            return 'bg-red-100 text-red-800';
        default:
            return 'bg-gray-100 text-gray-800';
    }
};

const getStatusColor = (status: string) => {
    switch (status) {
        case 'Pending':
            return 'bg-yellow-100 text-yellow-800';
        case 'In Progress':
            return 'bg-orange-100 text-orange-800';
        case 'Completed':
            return 'bg-green-100 text-green-800';
        default:
            return 'bg-gray-100 text-gray-800';
    }
};

const runAutomation = () => {
    useForm({}).post(route('tasks.automation'), {
        onSuccess: () => {
            // Simulate getting stats (in a real app, you'd get this from the response)
            automationStats.value = {
                total_tasks: props.tasks.length,
                completed_tasks: props.tasks.filter(t => t.status === 'Completed').length,
                in_progress_tasks: props.tasks.filter(t => t.status === 'In Progress').length,
                pending_tasks: props.tasks.filter(t => t.status === 'Pending').length,
                high_priority_tasks: props.tasks.filter(t => t.priority === 'High' && t.status !== 'Completed').length,
                old_in_progress_tasks: 0,
                completion_rate: Math.round((props.tasks.filter(t => t.status === 'Completed').length / props.tasks.length) * 100)
            };
            showAutomationModal.value = true;
        },
    });
};

const closeAutomationModal = () => {
    showAutomationModal.value = false;
    automationStats.value = null;
};
</script>

<template>
    <Head title="Tasks" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Tasks
                </h2>
                <div class="flex space-x-4">
                    <form @submit.prevent="runAutomation" class="inline">
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white font-semibold rounded-xl hover:from-green-700 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            Run Automation
                        </button>
                    </form>
                    <button @click="showCreateForm = !showCreateForm" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        {{ showCreateForm ? 'Cancel' : 'Create Task' }}
                    </button>
                </div>
            </div>
        </template>

        <div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 py-8">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <!-- Create Task Form -->
                <div v-if="showCreateForm" class="mb-8">
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                            <h3 class="text-xl font-bold text-white">Create New Task</h3>
                            <p class="text-blue-100 mt-1">Add a new task to your workflow</p>
                        </div>
                        <div class="p-6">
                            <form @submit.prevent="submitCreate" class="space-y-4">
                                <div>
                                    <InputLabel for="title" value="Title" />
                                    <TextInput
                                        id="title"
                                        v-model="createForm.title"
                                        type="text"
                                        class="mt-1 block w-full"
                                        required
                                        autofocus
                                    />
                                    <InputError class="mt-2" :message="createForm.errors.title" />
                                </div>

                                <div>
                                    <InputLabel for="description" value="Description" />
                                    <textarea
                                        id="description"
                                        v-model="createForm.description"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        rows="3"
                                    ></textarea>
                                    <InputError class="mt-2" :message="createForm.errors.description" />
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <InputLabel for="priority" value="Priority" />
                                        <select
                                            id="priority"
                                            v-model="createForm.priority"
                                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        >
                                            <option value="Low">Low</option>
                                            <option value="Normal">Normal</option>
                                            <option value="High">High</option>
                                        </select>
                                        <InputError class="mt-2" :message="createForm.errors.priority" />
                                    </div>

                                    <div>
                                        <InputLabel for="status" value="Status" />
                                        <select
                                            id="status"
                                            v-model="createForm.status"
                                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        >
                                            <option value="Pending">Pending</option>
                                            <option value="In Progress">In Progress</option>
                                            <option value="Completed">Completed</option>
                                        </select>
                                        <InputError class="mt-2" :message="createForm.errors.status" />
                                    </div>
                                </div>

                                <div class="flex items-center justify-end space-x-4 pt-4">
                                    <button
                                        type="button"
                                        @click="showCreateForm = false"
                                        class="px-6 py-3 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-xl hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200"
                                    >
                                        Cancel
                                    </button>
                                    <PrimaryButton :class="{ 'opacity-25': createForm.processing }" :disabled="createForm.processing" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Create Task
                                    </PrimaryButton>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Tasks List -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-xl font-bold text-gray-900">Your Tasks</h3>
                        <p class="text-gray-600 mt-1">Manage and track your workflow</p>
                    </div>
                    <div class="p-6">
                        <div v-if="tasks.length === 0" class="text-center py-12">
                            <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <h4 class="text-lg font-medium text-gray-900 mb-2">No tasks yet</h4>
                            <p class="text-gray-500 mb-4">Create your first task to get started!</p>
                        </div>
                        <div v-else class="space-y-6">
                            <div
                                v-for="task in tasks"
                                :key="task.id"
                                class="group bg-white border border-gray-200 rounded-2xl p-6 hover:border-gray-300 hover:shadow-lg transition-all duration-300"
                            >
                                <div v-if="editingTask?.id === task.id" class="space-y-4">
                                    <!-- Edit Form -->
                                    <h4 class="text-lg font-medium text-gray-900">Edit Task</h4>
                                    <form @submit.prevent="submitEdit" class="space-y-4">
                                        <div>
                                            <InputLabel for="edit-title" value="Title" />
                                            <TextInput
                                                id="edit-title"
                                                v-model="editForm.title"
                                                type="text"
                                                class="mt-1 block w-full"
                                                required
                                            />
                                            <InputError class="mt-2" :message="editForm.errors.title" />
                                        </div>

                                        <div>
                                            <InputLabel for="edit-description" value="Description" />
                                            <textarea
                                                id="edit-description"
                                                v-model="editForm.description"
                                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                                rows="3"
                                            ></textarea>
                                            <InputError class="mt-2" :message="editForm.errors.description" />
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <InputLabel for="edit-priority" value="Priority" />
                                                <select
                                                    id="edit-priority"
                                                    v-model="editForm.priority"
                                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                                >
                                                    <option value="Low">Low</option>
                                                    <option value="Normal">Normal</option>
                                                    <option value="High">High</option>
                                                </select>
                                                <InputError class="mt-2" :message="editForm.errors.priority" />
                                            </div>

                                            <div>
                                                <InputLabel for="edit-status" value="Status" />
                                                <select
                                                    id="edit-status"
                                                    v-model="editForm.status"
                                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                                >
                                                    <option value="Pending">Pending</option>
                                                    <option value="In Progress">In Progress</option>
                                                    <option value="Completed">Completed</option>
                                                </select>
                                                <InputError class="mt-2" :message="editForm.errors.status" />
                                            </div>
                                        </div>

                                        <div class="flex items-center justify-end space-x-4">
                                            <button
                                                type="button"
                                                @click="cancelEdit"
                                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                            >
                                                Cancel
                                            </button>
                                            <PrimaryButton :class="{ 'opacity-25': editForm.processing }" :disabled="editForm.processing">
                                                Update Task
                                            </PrimaryButton>
                                        </div>
                                    </form>
                                </div>
                                <div v-else>
                                    <!-- Task Display -->
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors mb-2">{{ task.title }}</h4>
                                            <p v-if="task.description" class="text-gray-600 mb-4 line-clamp-2">{{ task.description }}</p>
                                            <div class="flex items-center space-x-4">
                                                <span
                                                    :class="getStatusColor(task.status)"
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium border"
                                                >
                                                    {{ task.status }}
                                                </span>
                                                <span
                                                    :class="getPriorityColor(task.priority)"
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium border"
                                                >
                                                    {{ task.priority }}
                                                </span>
                                                <span class="text-sm text-gray-500">
                                                    {{ new Date(task.created_at).toLocaleDateString() }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-3 ml-6">
                                            <!-- Quick Status Update -->
                                            <select
                                                :value="task.status"
                                                @change="updateStatus(task.id, ($event.target as HTMLSelectElement).value as 'Pending' | 'In Progress' | 'Completed')"
                                                class="text-sm border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm px-3 py-2"
                                            >
                                                <option value="Pending">Pending</option>
                                                <option value="In Progress">In Progress</option>
                                                <option value="Completed">Completed</option>
                                            </select>
                                            
                                            <button
                                                @click="startEdit(task)"
                                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 hover:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200"
                                            >
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                Edit
                                            </button>
                                            
                                            <button
                                                @click="deleteTask(task.id)"
                                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-red-600 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 hover:border-red-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-200"
                                            >
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Automation Success Modal -->
        <AutomationSuccessModal 
            :show="showAutomationModal" 
            :stats="automationStats"
            @close="closeAutomationModal"
        />
    </AuthenticatedLayout>
</template>
