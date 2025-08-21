<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';
import OrderableTh from '@/components/ui/table/OrderableTh.vue';
import SearchInput from '@/components/ui/input/SearchInput.vue';
import Pagination from '@/components/ui/table/Pagination.vue';
import useUrl from '@/composables/useUrl';
import { formatCurrency, formatDate, formatDateTime } from '@/lib/utils';
import Button from '@/components/ui/button/Button.vue';
import { Project } from '@/types/models';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Projects',
        href: '/projects',
    },
];

defineProps<{
    projects: {
        data: Array<Project>;
        links: Array<{
            url: string;
            active: boolean;
            label: string;
        }>;
    }
}>();

const { currentUrl, navigate } = useUrl();
const currentStatusFilter = currentUrl.searchParams.get('status');

const updateStatusFilter = (status:string) => {
    const currentStatus = currentUrl.searchParams.get('status');
    if (currentStatus === status) {
        currentUrl.searchParams.delete('status');
    } else {
        currentUrl.searchParams.set('status', status);
    }
    currentUrl.searchParams.delete('page');
    navigate();
}

</script>

<template>
    <Head title="Projects" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            <div class="relative flex flex-row gap-2 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-4">
                <div class="flex flex-row flex-1">
                    <SearchInput />
                </div>
                <div class="flex flex-row">
                    <div :class="{
                        'flex flex-row border py-2 px-4 rounded-l-md cursor-pointer items-center': true,
                        'font-bold border-white': currentStatusFilter === 'Active',
                        'border-r-0': currentStatusFilter === 'Inactive',
                    }" @click="updateStatusFilter('Active')">
                        Active
                    </div>
                    <div :class="{
                        'flex flex-row border py-2 px-4 rounded-r-md cursor-pointer items-center': true,
                        'font-bold border-white border-l-1': currentStatusFilter === 'Inactive',
                        'border-l-0': currentStatusFilter != 'Inactive',
                    }" @click="updateStatusFilter('Inactive')">
                        Inactive
                    </div>
                </div>
                <Link :href="route('projects.create')">
                    <Button>
                        New
                    </Button>
                </Link>
            </div>
            <div class="relative min-h-[100vh] p-4 flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <table class="w-full table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <OrderableTh field="name" is-default-order>Name</OrderableTh>
                            <th>Status</th>
                            <th>Creator</th>
                            <OrderableTh field="start_date">Start Date</OrderableTh>
                            <OrderableTh field="end_date">End Date</OrderableTh>
                            <OrderableTh field="value">Value</OrderableTh>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="project in projects.data"
                            :key="project.id"
                            class="cursor-pointer"
                            @click="router.visit(route('projects.show', project.id))"
                        >
                            <td class="text-right">{{ project.id }}</td>
                            <td>{{ project.name }}</td>
                            <td>{{ project.status }}</td>
                            <td>{{ project.creator.name }}</td>
                            <td class="text-center">{{ formatDateTime(project.start_date) }}</td>
                            <td class="text-center">{{ formatDateTime(project.end_date) }}</td>
                            <td class="text-right">{{ formatCurrency(project.value) }}</td>
                        </tr>
                    </tbody>
                </table>
                <Pagination :paginator="projects" />
            </div>
        </div>
    </AppLayout>
</template>
