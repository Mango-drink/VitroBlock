<script setup>
import { router, usePage } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import { useToast } from 'vue-toastification'

const props = defineProps({
  operaciones: Array
})

const toast = useToast()
const page = usePage()

if (page.props.flash && page.props.flash.success) {
  toast.success(page.props.flash.success)
}

function destroy(id) {
  if (confirm('¿Eliminar esta operación?')) {
    router.delete(route('operacion.destroy', { operacion: id }), {
      onSuccess: () => toast.success('Operación eliminada correctamente.'),
      onError: () => toast.error('No se pudo eliminar la operación.')
    })
  }
}

function goToDashboard() {
  router.visit(route('admin.dashboard'))
}

function goToCreate() {
  router.visit(route('operacion.create'))
}

function goToEdit(id) {
  router.visit(route('operacion.edit', { operacion: id }))
}
</script>

<template>
  <div>
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">Operaciones</h1>
      <div class="flex gap-2">
        <button
          @click="goToDashboard"
          class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-3 py-2 rounded shadow border border-gray-400 transition"
        >← Dashboard</button>
        <button
          @click="goToCreate"
          class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition"
        >Nueva operación</button>
      </div>
    </div>
    <table class="min-w-full border border-gray-300">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-4 py-2 border-b">ID</th>
          <th class="px-4 py-2 border-b">Tipo</th>
          <th class="px-4 py-2 border-b">Cantidad</th>
          <th class="px-4 py-2 border-b">Fecha y hora</th>
          <th class="px-4 py-2 border-b">Producto</th>
          <th class="px-4 py-2 border-b">Usuario</th>
          <th class="px-4 py-2 border-b">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="operacion in operaciones" :key="operacion.operacion_id" class="hover:bg-gray-50">
          <td class="px-4 py-2 border-b">{{ operacion.operacion_id }}</td>
          <td class="px-4 py-2 border-b">{{ operacion.tipo }}</td>
          <td class="px-4 py-2 border-b">{{ operacion.cantidad }}</td>
          <td class="px-4 py-2 border-b">{{ operacion.fecha_hora }}</td>
          <td class="px-4 py-2 border-b">
            {{ operacion.producto?.nombre ?? operacion.producto_id }}
          </td>
          <td class="px-4 py-2 border-b">
            {{ operacion.usuario?.nombre ?? operacion.usuario_id }}
          </td>
          <td class="px-4 py-2 border-b flex gap-2">
            <button
              @click="goToEdit(operacion.operacion_id)"
              class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500 transition"
            >Editar</button>
            <button
              @click="destroy(operacion.operacion_id)"
              class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition"
            >Eliminar</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
