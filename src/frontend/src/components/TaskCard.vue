<template>
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <h5 class="card-title font-weight-bold mb-2">{{ props.task.title }}</h5>
            </div>
            <div class="d-flex flex-wrap overflow-auto">
                <p>{{ props.task.description }}</p>
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div class="d-flex">{{ statusValues[props.task.status] }}</div>
                    <div class="d-flex flex-row mx-2">
                    <div class="mx-1">
                        <svg v-if="props.task.attachment_url" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="30" height="20" viewBox="0 0 16 16" @click="showFile">
                            <path d="M 4.5 2 C 3.675781 2 3 2.675781 3 3.5 L 3 12.5 C 3 13.324219 3.675781 14 4.5 14 L 11.5 14 C 12.324219 14 13 13.324219 13 12.5 L 13 5.292969 L 9.707031 2 Z M 4.5 3 L 9 3 L 9 6 L 12 6 L 12 12.5 C 12 12.78125 11.78125 13 11.5 13 L 4.5 13 C 4.21875 13 4 12.78125 4 12.5 L 4 3.5 C 4 3.21875 4.21875 3 4.5 3 Z M 10 3.707031 L 11.292969 5 L 10 5 Z"></path>
                        </svg>
                        <svg v-else class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" @click="attachFile(props.task.uuid)">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11v5m0 0 2-2m-2 2-2-2M3 6v1a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1Zm2 2v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V8H5Z"/>
                        </svg>
                    </div>
                    <div class="mx-1"> 
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 0 50 50" @click="editTask(props.task.uuid)">
                            <path d="M 43.125 2 C 41.878906 2 40.636719 2.488281 39.6875 3.4375 L 38.875 4.25 L 45.75 11.125 C 45.746094 11.128906 46.5625 10.3125 46.5625 10.3125 C 48.464844 8.410156 48.460938 5.335938 46.5625 3.4375 C 45.609375 2.488281 44.371094 2 43.125 2 Z M 37.34375 6.03125 C 37.117188 6.0625 36.90625 6.175781 36.75 6.34375 L 4.3125 38.8125 C 4.183594 38.929688 4.085938 39.082031 4.03125 39.25 L 2.03125 46.75 C 1.941406 47.09375 2.042969 47.457031 2.292969 47.707031 C 2.542969 47.957031 2.90625 48.058594 3.25 47.96875 L 10.75 45.96875 C 10.917969 45.914063 11.070313 45.816406 11.1875 45.6875 L 43.65625 13.25 C 44.054688 12.863281 44.058594 12.226563 43.671875 11.828125 C 43.285156 11.429688 42.648438 11.425781 42.25 11.8125 L 9.96875 44.09375 L 5.90625 40.03125 L 38.1875 7.75 C 38.488281 7.460938 38.578125 7.011719 38.410156 6.628906 C 38.242188 6.246094 37.855469 6.007813 37.4375 6.03125 C 37.40625 6.03125 37.375 6.03125 37.34375 6.03125 Z"></path>
                        </svg>
                    </div>
                    <div class="mx-1">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 0 48 48" @click="deleteTask(props.task.uuid)">
                            <path d="M 24 4 C 20.491685 4 17.570396 6.6214322 17.080078 10 L 10.238281 10 A 1.50015 1.50015 0 0 0 9.9804688 9.9785156 A 1.50015 1.50015 0 0 0 9.7578125 10 L 6.5 10 A 1.50015 1.50015 0 1 0 6.5 13 L 8.6386719 13 L 11.15625 39.029297 C 11.427329 41.835926 13.811782 44 16.630859 44 L 31.367188 44 C 34.186411 44 36.570826 41.836168 36.841797 39.029297 L 39.361328 13 L 41.5 13 A 1.50015 1.50015 0 1 0 41.5 10 L 38.244141 10 A 1.50015 1.50015 0 0 0 37.763672 10 L 30.919922 10 C 30.429604 6.6214322 27.508315 4 24 4 z M 24 7 C 25.879156 7 27.420767 8.2681608 27.861328 10 L 20.138672 10 C 20.579233 8.2681608 22.120844 7 24 7 z M 11.650391 13 L 36.347656 13 L 33.855469 38.740234 C 33.730439 40.035363 32.667963 41 31.367188 41 L 16.630859 41 C 15.331937 41 14.267499 40.033606 14.142578 38.740234 L 11.650391 13 z M 20.476562 17.978516 A 1.50015 1.50015 0 0 0 19 19.5 L 19 34.5 A 1.50015 1.50015 0 1 0 22 34.5 L 22 19.5 A 1.50015 1.50015 0 0 0 20.476562 17.978516 z M 27.476562 17.978516 A 1.50015 1.50015 0 0 0 26 19.5 L 26 34.5 A 1.50015 1.50015 0 1 0 29 34.5 L 29 19.5 A 1.50015 1.50015 0 0 0 27.476562 17.978516 z"></path>
                        </svg>
                    </div>
              </div>
            </div>
          </div>
        </div>
        <input id="fileUpload" type="file" hidden>
</template>

<script setup>
import { defineEmits, defineProps } from 'vue'
import { statusValues } from '@/consts/consts.ts';

const props = defineProps(['task'])

const emits = defineEmits(['attachFiles', 'editTask', 'deleteTask'])

const attachFile = (uuid) => {
    emits('attachFiles', uuid)
}

const editTask = (uuid) => {
    emits('editTask', uuid)
}

const deleteTask = (uuid) => {
    emits('deleteTask', uuid)
}

const showFile = () => {
    console.log('clike')
}

</script>

<style>
 .card {
    width: 15rem;
 }

 svg {
    cursor: pointer;
 }
</style>