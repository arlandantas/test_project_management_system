<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps<{
    project: {
        id: number;
        name: string;
        status: string;
        start_date: string;
        end_date: string;
        value: number;
    }
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

const form = useForm({
    id: props.project.id || null,
    name: props.project.name || '',
    status: props.project.status || '',
    start_date: props.project.start_date || '',
    end_date: props.project.end_date || '',
    value: props.project.value || 0,
});

function submit() {
    if (props.project.id) {
        if (props.project.status != form.status && form.status === 'Inactive') {
            if (!confirm('Changing status to Inactive will inactivate all associated tasks. Are you sure?')) {
                return;
            }
        }

        form.put(`/projects/${props.project.id}`);
    } else {
        form.post('/projects');
    }
}

function deleteProject() {
    if (confirm('Are you sure you want to delete this project?')) {
        form.delete(`/projects/${props.project.id}`);
    }
}

</script>

<template>
    <Head :title="`Project - ${props.project.name || 'New'}`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <form @submit.prevent="submit">
            <input type="hidden" name="_method" :value="props.project.id ? 'patch' : 'post'">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 p-4 m-4 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                <div class="lg:col-span-2">
                    <label for="name" class="block text-sm font-medium mb-1">Name</label>
                    <Input
                        v-model="form.name"
                        placeholder="Project Name"
                        id="name"
                    />
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium mb-1">Status</label>
                    <Input
                        v-model="form.status"
                        placeholder="Status"
                        id="status"
                    />
                </div>
                <div>
                    <label for="value" class="block text-sm font-medium mb-1">Value</label>
                    <Input
                        v-model="form.value"
                        type="number"
                        step="0.01"
                        min="0"
                        placeholder="Project Value"
                        id="value"
                    />
                </div>
                <div>
                    <label for="start_date" class="block text-sm font-medium mb-1">Start Date</label>
                    <Input
                        v-model="form.start_date"
                        type="datetime-local"
                        id="start_date"
                    />
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium mb-1">End Date</label>
                    <Input
                        v-model="form.end_date"
                        type="datetime-local"
                        id="end_date"
                    />
                </div>
                <div class="lg:col-span-2 flex flex-row justify-end gap-2">
                    <Button type="button" class="text-red-500" @click="deleteProject" v-if="props.project.id">
                        Delete
                    </Button>
                    <Button type="submit">
                        Save
                    </Button>
                </div>
            </div>
        </form>
    </AppLayout>
</template>
