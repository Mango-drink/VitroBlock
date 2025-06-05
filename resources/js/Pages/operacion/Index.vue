<script setup>
import { router, usePage } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import { useToast } from 'vue-toastification'

// Props de Inertia
const props = defineProps({
  operaciones: Array
})

const toast = useToast()
const page = usePage()

// Mostrar notificación si hay flash message de éxito
if (page.props.flash && page.props.flash.success) {
  toast.success(page.props.flash.success)
}

// Eliminar operación
function destroy(id) {
  if (confirm('¿Eliminar esta operación?')) {
    router.delete(route('operacion.destroy', { operacion: id }), {
      onSuccess: () => toast.success('Operación eliminada correctamente.'),
      onError: () => toast.error('No se pudo eliminar la operación.')
    })
  }
}
</script>

<template>
  <div>
    <h1>Operaciones</h1>
    <a :href="route('operacion.create')">Nueva operación</a>
    <table border="1" cellpadding="4">
      <thead>
        <tr>
          <th>ID</th>
          <th>Tipo</th>
          <th>Cantidad</th>
          <th>Fecha y hora</th>
          <th>Producto</th>
          <th>Usuario</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="operacion in operaciones" :key="operacion.operacion_id">
          <td>{{ operacion.operacion_id }}</td>
          <td>{{ operacion.tipo }}</td>
          <td>{{ operacion.cantidad }}</td>
          <td>{{ operacion.fecha_hora }}</td>
          <td>
            <!-- Asumiendo que mandas producto relacionado -->
            {{ operacion.producto?.nombre ?? operacion.producto_id }}
          </td>
          <td>
            <!-- Asumiendo que mandas usuario relacionado -->
            {{ operacion.usuario?.nombre ?? operacion.usuario_id }}
          </td>
          <td>
            <a :href="route('operacion.edit', { operacion: operacion.operacion_id })">Editar</a>
            <button @click="destroy(operacion.operacion_id)">Eliminar</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
