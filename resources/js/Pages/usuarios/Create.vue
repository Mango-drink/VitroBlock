<script setup>
import { ref } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import { useToast } from 'vue-toastification'

const props = defineProps({
  roles: Array
})

// Formulario reactivo
const form = ref({
  nombre: '',
  email: '',
  password_hash: '',
  rol_id: ''
})

// Toast y errores de validación
const toast = useToast()
const errors = usePage().props.errors || {}

// Función para crear usuario
function submit() {
  router.post(route('usuarios.store'), form.value, {
    onSuccess: () => toast.success('Usuario creado exitosamente.'),
    onError: () => toast.error('Hubo un error al crear el usuario.')
  })
}
</script>

<template>
  <div>
    <h1>Crear Usuario</h1>
    <form @submit.prevent="submit">
      <div>
        <input v-model="form.nombre" placeholder="Nombre" required />
        <div v-if="errors.nombre" style="color: red;">{{ errors.nombre }}</div>
      </div>
      <div>
        <input v-model="form.email" type="email" placeholder="Correo" required />
        <div v-if="errors.email" style="color: red;">{{ errors.email }}</div>
      </div>
      <div>
        <input v-model="form.password_hash" type="password" placeholder="Contraseña" required />
        <div v-if="errors.password_hash" style="color: red;">{{ errors.password_hash }}</div>
      </div>
      <div>
        <select v-model="form.rol_id" required>
          <option value="">Seleccione un rol</option>
          <option v-for="rol in roles" :key="rol.rol_id" :value="rol.rol_id">{{ rol.nombre }}</option>
        </select>
        <div v-if="errors.rol_id" style="color: red;">{{ errors.rol_id }}</div>
      </div>
      <button type="submit">Guardar</button>
    </form>
  </div>
</template>
