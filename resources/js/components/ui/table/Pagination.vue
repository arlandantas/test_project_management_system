<script setup lang="ts">
import { defineProps, ref } from 'vue';
import Select from '../select/Select.vue';
import Option from '../select/Option.vue';

const itemsPerPageOptions = [5, 10, 25, 50, 100];
const url = new URL(window.location.href);
const currentItemsPerPage = ref(url.searchParams.get('pageSize') || '10');

const updateItemsPerPage = (value: string) => {
    url.searchParams.set('pageSize', currentItemsPerPage.value);
    window.location.href = url.href;
};

defineProps<{
    paginator: {
        links: Array<any>;
    };
}>();
</script>

<template>
    <div class="flex flex-row justify-center">
        <div class="flex items-center" v-if="paginator.links.length > 3">
            <a
                v-for="(link, index) in paginator.links"
                :href="link.url"
                v-html="index == 0 ? '&lt;' : index === paginator.links.length -1 ? '&gt;' : link.label"
                :class="{
                    'p-2': true,
                    'font-bold': link.active,
                    'border': link.active,
                }"
            ></a>
        </div>
        <div class="flex flex-center items-center">
            Items per page:
            <Select class="ml-2 w-16" v-model="currentItemsPerPage" @change="updateItemsPerPage">
                <Option v-for="option in itemsPerPageOptions" :key="option" :value="option">{{ option }}</Option>
            </Select>
        </div>
    </div>
</template>
