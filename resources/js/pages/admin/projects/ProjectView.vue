<script setup lang="ts">
import ProjectAbstract from '@/components/ProjectAbstract.vue';
import TaskEditDialog from '@/components/TaskEditDialog.vue';
import Button from '@/components/ui/button/Button.vue';
import SearchInput from '@/components/ui/input/SearchInput.vue';
import OrderableTh from '@/components/ui/table/OrderableTh.vue';
import Pagination from '@/components/ui/table/Pagination.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { formatDate } from '@/lib/utils';
import { User, type BreadcrumbItem } from '@/types';
import { Project, Task } from '@/types/models';
import { Head, usePage } from '@inertiajs/vue3';
import { Edit } from 'lucide-vue-next';

const page = usePage();
const user = page.props.auth.user as User;

const props = defineProps<{
    project: Project;
    canEdit: boolean;
    tasks: {
        data: Array<Task>;
        links: Array<{
            url: string;
            active: boolean;
            label: string;
        }>;
    };
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Projects',
        href: '/projects',
    },
    {
        title: `${props.project.id || 'New'}`,
        href: '/projects/create',
    },
];

</script>

<template>
    <Head :title="`Project - ${project.name || 'New'}`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col gap-4 m-4">
            <ProjectAbstract :project="project" :canEdit="canEdit" />
            <div class="flex flex-col border rounded-lg p-4">
                <div class="flex flex-row justify-between items-center mx-4 gap-4">
                    <span class="font-bold text-lg">Tasks</span>
                    <TaskEditDialog :project-id="project.id">
                        <Button>New</Button>
                    </TaskEditDialog>
                </div>
                <div class="flex flex-row m-4">
                    <SearchInput />
                </div>
                <table class="w-full table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <OrderableTh field="title" is-default-order>
                                Title
                            </OrderableTh>
                            <OrderableTh field="status">Status</OrderableTh>
                            <OrderableTh field="due_date">Due Date</OrderableTh>
                            <th>Creator</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="tasks.data.length === 0">
                            <td colspan="5" class="text-center text-gray-500">No tasks found.</td>
                        </tr>
                        <tr v-for="task in tasks.data" :key="task.id">
                            <td class="text-right">{{ task.id }}</td>
                            <td>{{ task.title }}</td>
                            <td class="text-center">
                                <span
                                    :class="{
                                        'text-sm border rounded-sm px-2 py-1': true,
                                        'text-green-500 background-green-300 border-green-500': task.status == 'Active',
                                        'text-red-500 background-red-300 border-red-500': task.status == 'Inactive',
                                        'text-blue-500 background-blue-300 border-blue-500': task.status == 'Completed'
                                    }"
                                >
                                    {{ task.status }}
                                </span>
                            </td>
                            <td class="text-center">{{ formatDate(task.due_date) }}</td>
                            <td>{{ task.creator.name }}</td>
                            <td class="text-center">
                                <TaskEditDialog :task="task" v-if="canEdit || task.creator_id == user.id">
                                    <Button><Edit /></Button>
                                </TaskEditDialog>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <Pagination :paginator="tasks" />
            </div>
        </div>
    </AppLayout>
</template>
