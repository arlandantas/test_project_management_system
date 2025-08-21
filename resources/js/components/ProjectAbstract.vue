<script setup lang="ts">
import { Project } from '@/types/models';
import { Link } from '@inertiajs/vue3';
import { Calendar, Edit, User } from 'lucide-vue-next';
import { defineProps } from 'vue';
import Button from '@/components/ui/button/Button.vue';
import { formatCurrency } from '@/lib/utils';

const props = defineProps<{
    project: Project;
    canEdit: boolean;
}>();
</script>

<template>
    <div class="grid grid-cols-[1fr_auto] p-4 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
        <div class="text-2xl flex flex-row items-center font-bold gap-2">
            {{ project.name }}
            <span class="text-sm text-gray-500">({{ formatCurrency(project.value) }})</span>
            <span
                :class="{
                    'text-sm border rounded-sm px-2 py-1': true,
                    'text-green-500 background-green-300 border-green-500': project.status == 'Active',
                    'text-red-500 background-red-300 border-red-500': project.status == 'Inactive'
                }"
            >
                {{ project.status }}
            </span>
        </div>
        <div class="row-span-2">
            <div class="flex flex-row justify-end mt-2 items-center" v-if="canEdit">
                <Link :href="route('projects.edit', project.id)">
                    <Button>
                        <Edit class="size-5" />
                    </Button>
                </Link>
            </div>
        </div>
        <div class="flex flex-row justify-start gap-4">
            <div class="text-sm text-gray-500">
                <Calendar class="inline size-4" />
                {{ new Date(project.start_date).toLocaleDateString() }} - {{ new Date(project.end_date).toLocaleDateString() }} 
            </div>
            <div class="text-sm text-gray-500">
                <User class="inline size-4" />
                {{ project.creator.name }}
            </div>
        </div>
    </div>
</template>