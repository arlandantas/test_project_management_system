<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import { Label } from '@/components/ui/label';
import Option from '@/components/ui/select/Option.vue';
import Select from '@/components/ui/select/Select.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Project } from '@/types/models';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps<{
    project: Project
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

        form.put(route('projects.update', props.project.id));
    } else {
        form.post(route('projects.store'));
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
                    <Label for="name">Name</Label>
                    <Input
                        v-model="form.name"
                        placeholder="Project Name"
                        id="name"
                    />
                    <div v-if="form.errors.name" class="text-sm text-red-500">{{ form.errors.name }}</div>
                </div>
                <div>
                    <Label for="status">Status</Label>
                    <Select v-model="form.status" placeholder="Status">
                        <Option value="Active">Active</Option>
                        <Option value="Inactive">Inactive</Option>
                    </Select>
                    <InputError :message="form.errors.status" />
                </div>
                <div>
                    <Label for="value">Value</Label>
                    <Input
                        v-model="form.value"
                        type="number"
                        step="0.01"
                        min="0"
                        placeholder="Project Value"
                        id="value"
                    />
                    <InputError :message="form.errors.value" />
                </div>
                <div>
                    <Label for="start_date">Start Date</Label>
                    <Input
                        v-model="form.start_date"
                        type="datetime-local"
                        id="start_date"
                    />
                    <InputError :message="form.errors.start_date" />
                </div>
                <div>
                    <Label for="end_date">End Date</Label>
                    <Input
                        v-model="form.end_date"
                        type="datetime-local"
                        id="end_date"
                    />
                    <InputError :message="form.errors.end_date" />
                </div>
                <div class="lg:col-span-2 flex flex-row justify-between gap-2">
                    <Button type="button" variant="destructive" @click="deleteProject" v-if="props.project.id">
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
