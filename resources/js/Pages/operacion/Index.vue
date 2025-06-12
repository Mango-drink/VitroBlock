<script setup>
import { router, usePage } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import { useToast } from 'vue-toastification'
import { ListChecks, Edit, Trash2, Plus, ArrowLeft } from 'lucide-vue-next'

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
  <div class="max-w-6xl mx-auto mt-8">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-3">
      <h1 class="text-2xl font-bold text-blue-800 flex items-center gap-2">
        <ListChecks class="w-7 h-7 text-blue-500" /> Operaciones
      </h1>
      <div class="flex gap-2">
        <button
          @click="goToDashboard"
          class="flex items-center gap-1 bg-gray-100 hover:bg-gray-200 text-gray-800 px-3 py-2 rounded-lg shadow border border-gray-300 transition font-semibold"
        >
          <ArrowLeft class="w-4 h-4" /> Dashboard
        </button>
        <button
          @click="goToCreate"
          class="flex items-center gap-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow font-semibold transition"
        >
          <Plus class="w-4 h-4" /> Nueva operación
        </button>
      </div>
    </div>
    <div class="bg-white shadow rounded-2xl overflow-x-auto border">
      <table class="min-w-full text-gray-700">
        <thead class="bg-blue-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">ID</th>
            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Tipo</th>
            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Cantidad</th>
            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Fecha y hora</th>
            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Producto</th>
            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Usuario</th>
            <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="props.operaciones.length === 0">
            <td colspan="7" class="text-center py-8 text-gray-400 italic">
              No hay operaciones registradas.
            </td>
          </tr>
          <tr v-for="operacion in props.operaciones" :key="operacion.operacion_id" class="hover:bg-blue-50 transition">
            <td class="px-6 py-3 border-b font-mono text-sm">{{ operacion.operacion_id }}</td>
            <td class="px-6 py-3 border-b font-medium">{{ operacion.tipo }}</td>
            <td class="px-6 py-3 border-b">{{ operacion.cantidad }}</td>
            <td class="px-6 py-3 border-b">{{ operacion.fecha_hora }}</td>
            <td class="px-6 py-3 border-b">
              {{ operacion.producto?.nombre ?? operacion.producto_id }}
            </td>
            <td class="px-6 py-3 border-b">
              {{ operacion.usuario?.nombre ?? operacion.usuario_id }}
            </td>
            <td class="px-6 py-3 border-b flex justify-center gap-2">
              <button
                @click="goToEdit(operacion.operacion_id)"
                class="flex items-center gap-1 bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1.5 rounded-lg shadow transition"
                title="Editar"
              >
                <Edit class="w-4 h-4" /> Editar
              </button>
              <button
                @click="destroy(operacion.operacion_id)"
                class="flex items-center gap-1 bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg shadow transition"
                title="Eliminar"
              >
                <Trash2 class="w-4 h-4" /> Eliminar
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
