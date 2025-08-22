<script setup lang="ts">
import { Dialog, DialogClose, DialogContent, DialogDescription, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import Label from '@/components/ui/label/Label.vue';
import Input from '@/components/ui/input/Input.vue';
import InputError from '@/components/InputError.vue';
import Select from '@/components/ui/select/Select.vue';
import Option from '@/components/ui/select/Option.vue';
import { Task } from '@/types/models';
import { useForm, Form, usePage } from '@inertiajs/vue3';
import Button from '@/components/ui/button/Button.vue';
import { User } from '@/types';
import { ref } from 'vue';

const page = usePage();
const user = page.props.auth.user as User;
const show = ref(false);

const props = defineProps<{
    task?: Task | null;
    projectId?: number;
}>();

const form = useForm({
    id: props.task?.id || null,
    title: props.task?.title || '',
    due_date: props.task?.due_date || '',
    status: props.task?.status || '',
    project_id: props.task?.project_id || props.projectId,
});

const hideDialog = function () {
    if (form.hasErrors) {
        return;
    }
    show.value = false;
};

const deleteTask = function () {
    if (confirm('Are you sure you want to delete this task?')) {
        form.delete(route('tasks.destroy', props.task?.id), {
            onSuccess: hideDialog,
        });
    }
};

const save = function () {
    if (props.task?.id) {
        form.put(route('tasks.update', props.task.id), {
            onSuccess: hideDialog,
        });
    } else {
        form.post(route('tasks.store'), {
            onSuccess: function () {
                hideDialog();
                form.reset();
            },
        });
    }
};

</script>

<template>
    <Dialog v-model:open="show">
        <DialogTrigger as-child>
            <slot />
        </DialogTrigger>
        <DialogContent>
            <DialogTitle>{{ task?.id ? 'Edit Task' : 'Create Task' }}</DialogTitle>
            <DialogDescription v-show="false">{{ task?.id ? ('Edit the details of the task: ' + task?.title) : 'Fill in the details to create a new task.' }}</DialogDescription>
            <div class="flex flex-col md:grid-cols-1 gap-2">
                <Label for="title">Task Title</Label>
                <Input id="title" v-model="form.title" type="text" placeholder="Enter task title" />
                <InputError :message="form.errors.title" />

                <Label for="due_date">Due Date</Label>
                <Input id="due_date" v-model="form.due_date" type="datetime-local" />
                <InputError :message="form.errors.due_date" />

                <Label for="status">Status</Label>
                <Select id="status" v-model="form.status">
                    <Option value="Pending">Pending</Option>
                    <Option value="Inactive">Inactive</Option>
                    <Option value="Completed">Completed</Option>
                </Select>
                <InputError :message="form.errors.status" />

                <Label>Creator</Label>
                <Input id="creator" :model-value="task?.creator.name || user.name" disabled />

                <div class="flex flex-row justify-between mt-2">
                    <DialogClose>
                        <Button variant="secondary">Cancel</Button>
                    </DialogClose>
                    <Button v-if="task?.id" variant="destructive" @click="deleteTask" :disabled="form.processing">Delete</Button>
                    <Button
                        @click="save"
                        :disabled="form.processing"
                    >Save</Button>
                </div>
            </div>
        </DialogContent>
    </Dialog>
</template>