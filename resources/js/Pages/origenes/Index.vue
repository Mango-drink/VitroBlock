<script setup>
import { defineProps } from 'vue'
import { router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import { Globe, Edit, Trash2, Plus, ArrowLeft } from 'lucide-vue-next'

const props = defineProps({
  origenes: Array
})

function goToCreate() {
  router.visit(route('admin.origenes.create'))
}
function goToEdit(id) {
  router.visit(route('admin.origenes.edit', id))
}
function eliminar(origen) {
  if (confirm(`¿Estás seguro que deseas eliminar el origen "${origen.pais}"?`)) {
    router.delete(route('admin.origenes.destroy', origen.origen_id))
  }
}
function goToDashboard() {
  router.visit(route('admin.dashboard'))
}
</script>

<template>
  <div class="max-w-3xl mx-auto mt-8">
    <div v-if="$page.props.flash && $page.props.flash.success" class="bg-green-200 text-green-900 p-2 rounded mb-4 border border-green-300 shadow">
      {{ $page.props.flash.success }}
    </div>
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-3">
      <h1 class="text-2xl font-bold text-blue-800 flex items-center gap-2">
        <Globe class="w-7 h-7 text-blue-500" /> Orígenes
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
          <Plus class="w-4 h-4" /> Nuevo Origen
        </button>
      </div>
    </div>

    <div class="bg-white shadow rounded-2xl overflow-hidden border">
      <table class="min-w-full text-gray-700">
        <thead class="bg-blue-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">ID</th>
            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">País</th>
            <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="props.origenes.length === 0">
            <td colspan="3" class="text-center py-8 text-gray-400 italic">
              No hay orígenes registrados.
            </td>
          </tr>
          <tr v-for="origen in props.origenes" :key="origen.origen_id" class="hover:bg-blue-50 transition">
            <td class="px-6 py-3 border-b font-mono text-sm">{{ origen.origen_id }}</td>
            <td class="px-6 py-3 border-b font-medium">{{ origen.pais }}</td>
            <td class="px-6 py-3 border-b flex justify-center gap-2">
              <button
                @click="goToEdit(origen.origen_id)"
                class="flex items-center gap-1 bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1.5 rounded-lg shadow transition"
                title="Editar"
              >
                <Edit class="w-4 h-4" /> Editar
              </button>
              <button
                @click="eliminar(origen)"
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
