<script setup>
import { ref } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import { useToast } from 'vue-toastification'

// Props de Inertia
const props = defineProps({
  roles: Array
})

// Toast para notificaciones
const toast = useToast()

// Obtener mensajes de éxito desde la sesión (flash messages)
const page = usePage()
if (page.props.flash && page.props.flash.success) {
  toast.success(page.props.flash.success)
}

// Función para eliminar un rol
function destroy(id) {
  if (confirm('¿Eliminar este rol?')) {
    router.delete(route('roles.destroy', { role: id }), {
      onSuccess: () => toast.success('Rol eliminado exitosamente.'),
      onError: () => toast.error('No se pudo eliminar el rol.')
    })
  }
}

</script>

<template>
  <div>
    <h1>Roles</h1>
    <a :href="route('roles.create')">Nuevo Rol</a>
    <ul>
      <li v-for="rol in roles" :key="rol.rol_id">
        {{ rol.nombre }}
        <a :href="route('roles.edit', rol.rol_id)">Editar</a>
        <button @click="destroy(rol.rol_id)">Eliminar</button>
      </li>
    </ul>
  </div>
</template>
