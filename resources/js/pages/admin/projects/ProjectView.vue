<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Calendar, Edit } from 'lucide-vue-next'

const props = defineProps<{
    project: {
        id: number;
        name: string;
        status: string;
        start_date: string;
        end_date: string;
        value: number;
    };
    canEdit: boolean;
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
        <div class="grid grid-cols-[1fr_auto] min-h-[100vh] p-4 m-4 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
            <div class="text-2xl flex flex-row items-center font-bold gap-2">
                {{ props.project.name }}
                <span class="text-sm text-gray-500">({{ props.project.value }})</span>
                <span
                    :class="{
                        'text-sm border rounded-sm px-2 py-1': true,
                        'text-green-500 background-green-300 border-green-500': props.project.status == 'Active',
                        'text-red-500 background-red-300 border-red-500': props.project.status == 'Inactive'
                    }"
                >
                    {{ props.project.status }}
                </span>
            </div>
            <div class="row-span-2">
                <div class="flex flex-row justify-end mt-2 items-center" v-if="canEdit">
                    <a :href="`/projects/${props.project.id}/edit`">
                        <Button>
                            <Edit class="size-5" />
                        </Button>
                    </a>
                </div>
            </div>
            <div class="text-sm text-gray-500">
                <Calendar class="inline size-4" />
                {{ new Date(props.project.start_date).toLocaleDateString() }} - {{ new Date(props.project.end_date).toLocaleDateString() }} 
            </div>
        </div>
    </AppLayout>
</template>
