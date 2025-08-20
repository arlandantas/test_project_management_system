<script setup lang="ts">
import { defineProps } from 'vue';

defineProps<{
    paginator: {
        links: Array<any>;
    };
}>();
</script>

<template>
    <div class="flex flex-row justify-center">
        <div class="flex items-center">
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
    </div>
</template>
