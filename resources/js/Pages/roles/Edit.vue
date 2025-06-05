<script setup>
import { ref } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import { useToast } from 'vue-toastification'

const props = defineProps({
  rol: Object
})

const form = ref({
  nombre: props.rol.nombre
})

const toast = useToast()
const errors = usePage().props.errors || {}



// AQUÍ va la línea corregida:
function submit() {
    console.log('props.rol:', props.rol)
    console.log('props.rol.rol_id:', props.rol.rol_id)
    console.log('route:', route('roles.update', { role: props.rol.rol_id }))
    router.put(route('roles.update', { role: props.rol.rol_id }), form.value, {
        onSuccess: () => toast.success('Rol actualizado exitosamente.'),
        onError: () => toast.error('Hubo un error al actualizar el rol.')
  })
}
</script>

<template>
  <div>
    <h1>Editar Rol</h1>
    <form @submit.prevent="submit">
      <input v-model="form.nombre" required />
      <div v-if="errors.nombre" style="color: red;">{{ errors.nombre }}</div>
      <button type="submit">Actualizar</button>
    </form>
  </div>
</template>
