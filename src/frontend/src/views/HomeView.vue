<template>
    <div v-if="!showForm" class="my-5 d-flex flex-wrap justify-content-start" >
      <div v-for="taskItem in task.taskList" :key="taskItem.uuid" class="d-flex my-3 mx-3">
        <TaskCard 
          :task="taskItem" 
          @edit-task="openTaskForm" 
          @delete-task="deleteTask" 
          @attach-file="attachFile" 
        />
      </div>     
      <div class="d-flex align-items-center ms-4">
        <AddButton @add-task="openTaskForm"/>
      </div>
    </div>
    <div v-else>
      <FormView :task="task.formTask" @close-form="openTaskForm"/>
    </div>
</template>

<script setup>
import { onMounted, ref, watchEffect } from 'vue';
import { useTaskStore } from '@/store/task.ts'

import AddButton from '@/components/AddButton.vue'
import TaskCard from '@/components/TaskCard.vue';
import FormView from '@/views/FormView.vue';

const task = useTaskStore()
const showForm = ref(false);

const openTaskForm = async (uuid) => {
    if (uuid) 
      await task.getTask(uuid)
    
    showForm.value = !showForm.value
}

const deleteTask = async (uuid) => {
  await task.deleteTask(uuid)

  task.deleteFromStore(uuid)
}

const attachFile = async () => {
  console.log('aqui')
}

onMounted(async () => {
  await task.getAllTask()
})

watchEffect(() => {
  if (!showForm.value) {
     task.clearFormCache()
  }
})
</script>

<style>
.card-text {
  color: black;
}


</style>