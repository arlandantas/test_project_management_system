<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import OrderableTh from '@/components/ui/table/OrderableTh.vue';
import SearchInput from '@/components/ui/input/SearchInput.vue';
import Pagination from '@/components/ui/table/Pagination.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Projects',
        href: '/projects',
    },
];

const currencyFormatter = new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD',
    minimumFractionDigits: 2,
});

defineProps<{
    projects: {
        data: Array<{
            id: number;
            name: string;
            status: string;
            start_date: string;
            end_date: string;
            value: number;
        }>;
        links: Array<{
            url: string;
            active: boolean;
            label: string;
        }>;
    }
}>();

</script>

<template>
    <Head title="Projects" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            <div class="relative flex flex-row rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-4">
                <div class="flex flex-row flex-1">
                    <SearchInput />
                </div>
                <div class="flex flex-row ml-2">
                    <div class="flex flex-row border py-2 px-4 rounded-l-md cursor-pointer items-center">
                        Active
                    </div>
                    <div class="flex flex-row border border-l-0 py-2 px-4 rounded-r-md cursor-pointer items-center">
                        Inactive
                    </div>
                </div>
            </div>
            <div class="relative min-h-[100vh] p-4 flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <table class="w-full">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <OrderableTh field="name" is-default-order>Name</OrderableTh>
                            <th>Status</th>
                            <OrderableTh field="start_date">Start Date</OrderableTh>
                            <OrderableTh field="end_date">End Date</OrderableTh>
                            <OrderableTh field="value">Value</OrderableTh>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="project in projects.data" :key="project.id">
                            <td class="text-right">{{ project.id }}</td>
                            <td>{{ project.name }}</td>
                            <td>{{ project.status }}</td>
                            <td class="text-center">{{ project.start_date }}</td>
                            <td class="text-center">{{ project.end_date }}</td>
                            <td class="text-right">{{ currencyFormatter.format(project.value) }}</td>
                        </tr>
                    </tbody>
                </table>
                <Pagination :paginator="projects" />
            </div>
        </div>
    </AppLayout>
</template>
