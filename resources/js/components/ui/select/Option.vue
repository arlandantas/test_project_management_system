<script setup lang="ts">

defineProps<{
  value?: any
}>();

</script>

<template>
    <option
        :value="value"
        class="bg-white dark:bg-gray-800 text-black dark:text-white px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700"
    >
        <slot />
    </option>
</template>
