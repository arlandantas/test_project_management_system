<script setup lang="ts">
import { Dialog, DialogClose, DialogContent, DialogTrigger } from '@/components/ui/dialog';
import Label from '@/components/ui/label/Label.vue';
import Input from '@/components/ui/input/Input.vue';
import InputError from '@/components/InputError.vue';
import Select from '@/components/ui/select/Select.vue';
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

const deleteTask = function () {
    if (confirm('Are you sure you want to delete this task?')) {
        form.delete(route('tasks.destroy', props.task?.id));
        show.value = false;
    }
};

const save = function () {
    if (props.task?.id) {
        form.put(route('tasks.update', props.task.id));
    } else {
        form.post(route('tasks.store'));
    }
    show.value = false;
};

</script>

<template>
    <Dialog v-model:open="show">
        <DialogTrigger as-child>
            <slot />
        </DialogTrigger>
        <DialogContent>
            <div class="flex flex-col md:grid-cols-1 gap-2">
                <Label for="title">Task Title</Label>
                <Input id="title" v-model="form.title" type="text" placeholder="Enter task title" />
                <InputError :message="form.errors.title" />

                <Label for="due_date">Due Date</Label>
                <Input id="due_date" v-model="form.due_date" type="date" />
                <InputError :message="form.errors.due_date" />

                <Label for="status">Status</Label>
                <Select id="status" v-model="form.status">
                    <option value="Pending">Pending</option>
                    <option value="Inactive">Inactive</option>
                    <option value="Completed">Completed</option>
                </Select>
                <InputError :message="form.errors.status" />

                <Label>Creator</Label>
                <Input id="creator" :model-value="task?.creator.name || user.name" disabled />

                <div class="flex flex-row justify-between">
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