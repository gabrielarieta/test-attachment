<template>
    <div class="content d-flex flex-column align-items-start mx-3 my-2">
        <div> 
            <ReturnButton @return-view="returnHome"/>
        </div>
        <div class="align-self-center">
            <FormComponent @data-submited="returnHome"/>
        </div>
    </div>
</template>

<script setup>
import { defineEmits } from 'vue'
import FormComponent from '@/components/FormComponent.vue'
import ReturnButton from '@/components/ReturnButton.vue'

const emit = defineEmits(['closeForm'])

const returnHome = () => {
    emit('closeForm')
}

</script>
