<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Home',
        href: '/',
    },
];

defineProps<{
    user: {
        name: string;
    };
}>();

</script>

<template>
    <Head title="Home" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col justify-center items-center gap-4 rounded-xl p-4 overflow-x-auto">
            <div class="text-2xl font-bold">Welcome, {{ user.name }}!</div>
        </div>
    </AppLayout>
</template>
