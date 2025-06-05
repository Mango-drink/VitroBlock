<script setup>
import { ref } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import { useToast } from 'vue-toastification'

// Formulario reactivo
const form = ref({
  nombre: ''
})

// Toast
const toast = useToast()

// Mensaje de error de validación
const errors = usePage().props.errors || {}

// Función para enviar el formulario
function submit() {
  router.post(route('roles.store'), form.value, {
    onSuccess: () => toast.success('Rol creado exitosamente.'),
    onError: () => toast.error('Hubo un error al crear el rol.')
  })
}
</script>

<template>
  <div>
    <h1>Crear Rol</h1>
    <form @submit.prevent="submit">
      <input v-model="form.nombre" placeholder="Nombre del rol" required />
      <div v-if="errors.nombre" style="color: red;">{{ errors.nombre }}</div>
      <button type="submit">Guardar</button>
    </form>
  </div>
</template>
