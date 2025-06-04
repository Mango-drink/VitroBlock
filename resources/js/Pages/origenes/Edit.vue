<template>
  <div>
    <h1>Editar Origen</h1>
    <form @submit.prevent="submit">
      <div>
        <label for="pais">País:</label>
        <input v-model="form.pais" id="pais" type="text" required>
        <div v-if="form.errors.pais" style="color:red;">{{ form.errors.pais }}</div>
      </div>
      <button type="submit">Actualizar</button>
    </form>
  </div>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3'
import { watchEffect } from 'vue'

import { defineProps } from 'vue'

const props = defineProps({
  origen: Object
})

const form = useForm({
  pais: props.origen.pais
})

function submit() {
  form.put(route('origenes.update', props.origen.id))
}
</script>