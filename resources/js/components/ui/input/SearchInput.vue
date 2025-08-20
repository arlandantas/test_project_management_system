<script setup lang="ts">
import { ref } from 'vue';
import { Delete, Search } from 'lucide-vue-next';

const currentUrl = new URL(window.location.href);
const initialSearch = currentUrl.searchParams.get('search') || '';
const searchQuery = ref<string>(initialSearch);

const doSearch = () => {
    const searchValue = searchQuery.value.trim();
    if (searchValue != initialSearch) {
        if (searchValue === '') {
            currentUrl.searchParams.delete('search');
        } else {
            currentUrl.searchParams.set('search', searchValue);
        }
        window.location.href = currentUrl.toString();
    }
};

function clear() {
    searchQuery.value = '';
    doSearch();
}

</script>

<template>
    <div class="flex flex-row flex-1">
        <input v-model="searchQuery" @keyup.enter="doSearch" type="search" placeholder="Search..." class="w-full p-2 border border-gray-300 rounded-l-md border-r-0" />
        <button v-if="initialSearch != ''" class="p-2 border border-gray-300 border-x-0 text-white" @click="clear">
            <Delete class="size-5" />
        </button>
        <button class="p-2 border border-gray-300 text-white rounded-r-md" @click="doSearch">
            <Search class="size-5" />
        </button>
    </div>
</template>