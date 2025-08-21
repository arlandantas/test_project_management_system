<script setup lang="ts">
import ProjectAbstract from '@/components/ProjectAbstract.vue';
import Button from '@/components/ui/button/Button.vue';
import OrderableTh from '@/components/ui/table/OrderableTh.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Project, Task } from '@/types/models';
import { Head, Link } from '@inertiajs/vue3';

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
                <div class="flex flex-row justify-between items-center mb-4">
                    <span class="font-bold text-lg mx-4">Tasks</span>
                    <Link class="btn btn-primary border bg-gray-900 px-4 py-2 rounded-md" :href="`/tasks/create?project_id=${project.id}`">New</Link>
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
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="task in tasks.data" :key="task.id">
                            <td class="text-right">{{ task.id }}</td>
                            <td>{{ task.title }}</td>
                            <td>
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
                            <td class="text-center">{{ new Date(task.due_date).toLocaleDateString() }}</td>
                            <td>{{ task.creator.name }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
