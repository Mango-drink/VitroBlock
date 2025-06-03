<template>
  <div>
    <h1>Crear Origen</h1>
    <form @submit.prevent="submit">
      <input v-model="form.pais" type="text" placeholder="País de origen" />
      <button type="submit">Guardar</button>
    </form>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/inertia-vue3'

const form = useForm({
  pais: ''
})

function submit() {
  form.post('/origenes')
}
</script>
