<script lang="ts" setup>

import { ArrowDown, ArrowUpDown, ArrowUp } from 'lucide-vue-next';

const props = defineProps<{
    field: string;
    isDefaultOrder?: boolean;
}>();

const currentUrl = new URL(window.location.href);
const currentOrderField = currentUrl.searchParams.get('orderBy');
const currentOrderDirection = currentUrl.searchParams.get('orderDirection') || 'asc';
const isOrdering = currentOrderField === props.field || (!currentOrderField && props.isDefaultOrder);

const reordenate = () => {
    const url = new URL(window.location.href);

    if (props.isDefaultOrder) {
        url.searchParams.delete('orderBy');
    }
    url.searchParams.delete('page');

    if (isOrdering) {
        if (currentOrderDirection === 'desc') {
            url.searchParams.delete('orderDirection');
        } else {
            url.searchParams.set('orderDirection', 'desc');
            url.searchParams.set('orderBy', props.field);
        }
    } else {
        if (!props.isDefaultOrder) {
            url.searchParams.set('orderBy', props.field);
        }
        url.searchParams.delete('orderDirection');
    }

    window.location.href = url.toString();
}

</script>

<template>
    <th class="cursor-pointer" @click="reordenate()">
        <slot />
        <ArrowUpDown v-if="!isOrdering" class="ml-1 inline h-4 w-4 align-middle" />
        <ArrowDown v-else-if="currentOrderDirection === 'desc'" class="ml-1 inline h-4 w-4 align-middle" />
        <ArrowUp v-else class="ml-1 inline h-4 w-4 align-middle" />
    </th>
</template>
