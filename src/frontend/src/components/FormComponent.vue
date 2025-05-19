<template>
 <div class="border rounded mt-4 p-3 row">
    <div class="col align-items-center">
        <div class="row mb-3">
            <label for="title" class="form-label text-start">Title</label>
            <input type="text" class="form-control" id="title" :value="task.formTask.title" @input="event => taskData.title = event.target.value">
        </div>
        <div class="row">
            <label for="status" class="form-label text-start">Status</label>

            <select class="form-select" id="status" @change="event => taskData.status = event.target.value">
                <option :model="taskData.status" v-for="(label, value) in statusValues" :key="value" :value="value">
                    {{ label }}
                </option>
            </select>
        </div>
    </div>
    <div class="col">
        <label class="form-label text-start" for="description">Description</label>
        <textarea :model="taskData.description" class="form-control" id="description" rows="4" :value="task.formTask.description" @input="event =>  taskData.description = event.target.value" />
    </div>
    <div class="d-flex justify-content-end mt-4">
        <button @click="submitData" class="btn btn-primary mb-3">Save</button>
    </div>
 </div>
</template>

<script setup>
import { defineEmits, onMounted, ref } from 'vue'
import { statusValues } from '@/consts/consts.ts';
import { useTaskStore } from '@/store/task.ts'


const task = useTaskStore()
const taskData = ref(task.formTask)

const emit = defineEmits(['dataSubmited'])

const submitData = async () => {
    const newTask = await task.storeTask(taskData.value)
    task.appendOrUpdateTask(newTask)

    emit('dataSubmited')
}

onMounted (() => {
    taskData.value = task.formTask
})
</script>

<style>
    .selectbox{
        width: 100%
    }

    #description {
        max-height: 127px;
        height: 127px;
        resize: none;
    }
</style>
