<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

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

</script>

<template>
    <Head :title="`Project - ${props.project.name || 'New'}`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="grid grid-cols-2 gap-4 min-h-[100vh] p-4 m-4 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
            <div class="col-span-2">
                <label for="name" class="block text-sm font-medium mb-1">Name</label>
                <Input
                    v-model="project.name"
                    placeholder="Project Name"
                    id="name"
                />
            </div>
            <div>
                <label for="status" class="block text-sm font-medium mb-1">Status</label>
                <Input
                    v-model="project.status"
                    placeholder="Status"
                    id="status"
                />
            </div>
            <div>
                <label for="value" class="block text-sm font-medium mb-1">Value</label>
                <Input
                    v-model="project.value"
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
                    v-model="project.start_date"
                    type="datetime"
                    id="start_date"
                />
            </div>
            <div>
                <label for="end_date" class="block text-sm font-medium mb-1">End Date</label>
                <Input
                    v-model="project.end_date"
                    type="datetime"
                    id="end_date"
                />
            </div>
            <div class="col-span-2 flex flex-row justify-end">
                <Button>
                    Save
                </Button>
            </div>
        </div>
    </AppLayout>
</template>
