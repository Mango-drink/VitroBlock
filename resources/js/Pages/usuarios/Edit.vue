<script setup>
import { ref } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import { useToast } from 'vue-toastification'

const props = defineProps({
  usuario: Object,
  roles: Array
})

// Formulario reactivo con datos iniciales del usuario
const form = ref({
  nombre: props.usuario.nombre,
  email: props.usuario.email,
  rol_id: props.usuario.rol_id
})

// Toast y errores de validación
const toast = useToast()
const errors = usePage().props.errors || {}

// Función para actualizar usuario
function submit() {
  router.put(route('usuarios.update', props.usuario.usuario_id), form.value, {
    onSuccess: () => toast.success('Usuario actualizado exitosamente.'),
    onError: () => toast.error('Hubo un error al actualizar el usuario.')
  })
}
</script>

<template>
  <div>
    <h1>Editar Usuario</h1>
    <form @submit.prevent="submit">
      <div>
        <input v-model="form.nombre" required />
        <div v-if="errors.nombre" style="color: red;">{{ errors.nombre }}</div>
      </div>
      <div>
        <input v-model="form.email" type="email" required />
        <div v-if="errors.email" style="color: red;">{{ errors.email }}</div>
      </div>
      <div>
        <select v-model="form.rol_id" required>
          <option v-for="rol in roles" :key="rol.rol_id" :value="rol.rol_id">{{ rol.nombre }}</option>
        </select>
        <div v-if="errors.rol_id" style="color: red;">{{ errors.rol_id }}</div>
      </div>
      <button type="submit">Actualizar</button>
    </form>
  </div>
</template>
