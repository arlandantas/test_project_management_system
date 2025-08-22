<script setup lang="ts">
import { onBeforeUnmount, reactive, ref } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import { ToastAction, ToastDescription, ToastProvider, ToastRoot, ToastTitle, ToastViewport } from 'reka-ui';
import { X } from 'lucide-vue-next';
import Button from './ui/button/Button.vue';

const page = usePage();

const currentToast = reactive({
    open: false,
    title: '',
    description: '',
    type: 'success' as 'success' | 'error',
    closeTimer: null as ReturnType<typeof setTimeout> | null,
});

function displayToast(type: 'success' | 'error', message: string) {
    currentToast.title = type === 'success' ? 'Success' : 'Error';
    currentToast.description = message;
    currentToast.open = true;
    currentToast.type = type;
    currentToast.closeTimer = setTimeout(() => {
        currentToast.open = false;
        currentToast.title = '';
        currentToast.description = '';
        console.log(`Closed ${type} toast after 5 seconds`);
        if (currentToast.closeTimer) {
            clearTimeout(currentToast.closeTimer);
            currentToast.closeTimer = null;
        }
    }, 5000);
}

function getToastFromPage() {
    if (page.props.toast) {
        const toast = page.props.toast as { success: string; error: string; };
        if (toast.success) {
            displayToast('success', toast.success);
        } else if (toast.error) {
            displayToast('error', toast.error);
        }
    }
}

getToastFromPage();

const removeRouterListener = router.on('success', (event) => {
    getToastFromPage();
});

onBeforeUnmount(() => {
    removeRouterListener();
});

</script>

<template>
    <ToastProvider>
        <slot />

        <ToastRoot
            v-model:open="currentToast.open"
            :class="[
                'rounded-lg shadow-sm border p-4 grid grid-cols-[auto_max-content] grid-rows-[auto_auto] gap-x-[15px] items-center data-[state=open]:animate-slideIn data-[state=closed]:animate-hide data-[swipe=move]:translate-x-[var(--reka-toast-swipe-move-x)] data-[swipe=cancel]:translate-x-0 data-[swipe=cancel]:transition-[transform_200ms_ease-out] data-[swipe=end]:animate-swipeOut',
                {
                    'bg-red-700': currentToast.type === 'error',
                    'bg-green-700': currentToast.type === 'success',
                }
            ]"
        >
            <ToastTitle class="mb-[5px] font-bold text-slate12 text-sm">
                {{ currentToast.title }}
            </ToastTitle>
            <ToastAction class="row-span-2 my-auto" as-child alt-text="Ignore message">
                <Button variant="link" @click="currentToast.open = false" class="cursor-pointer opacity-70 hover:opacity-100 transition-opacity">
                    <X class="w-4 h-4" />
                </Button>
            </ToastAction>
            <ToastDescription as-child>
                {{ currentToast.description }}
            </ToastDescription>
        </ToastRoot>
        <ToastViewport class="[--viewport-padding:_25px] fixed bottom-0 right-0 flex flex-col p-[var(--viewport-padding)] gap-[10px] w-[390px] max-w-[100vw] m-0 list-none z-[2147483647] outline-none" />
    </ToastProvider>
</template>