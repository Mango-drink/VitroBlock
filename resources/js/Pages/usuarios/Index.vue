<script setup>
import { router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import { useToast } from 'vue-toastification'
import { usePage } from '@inertiajs/vue3'

const props = defineProps({
  usuarios: Array
})

const toast = useToast()
const page = usePage()

// Notificación de éxito (flash desde el backend)
if (page.props.flash && page.props.flash.success) {
  toast.success(page.props.flash.success)
}

// Función para eliminar un usuario
function destroy(id) {
  if (confirm('¿Eliminar este usuario?')) {
    router.delete(route('usuarios.destroy', id), {
      onSuccess: () => toast.success('Usuario eliminado exitosamente.')
    })
  }
}
</script>

<template>
  <div>
    <h1>Usuarios</h1>
    <a :href="route('usuarios.create')">Nuevo Usuario</a>
    <ul>
      <li v-for="usuario in usuarios" :key="usuario.usuario_id">
        {{ usuario.nombre }} | {{ usuario.email }} | Rol: {{ usuario.rol?.nombre || 'Sin rol' }}
        <a :href="route('usuarios.edit', usuario.usuario_id)">Editar</a>
        <button @click="destroy(usuario.usuario_id)">Eliminar</button>
      </li>
    </ul>
  </div>
</template>
