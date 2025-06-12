<script setup>
import { Inertia } from '@inertiajs/inertia'
import { route } from 'ziggy-js'
import { defineProps } from 'vue'
import { Plus, ArrowLeft, Edit, Trash2 } from 'lucide-vue-next'

const props = defineProps({
  categorias: Array
})

function destroy(id) {
  if (!confirm('¿Eliminar esta categoría?')) return
  Inertia.delete(route('admin.categorias.destroy', { categoria: id }))
}

function goToCreate() {
  Inertia.visit(route('admin.categorias.create'))
}

function goToEdit(id) {
  Inertia.visit(route('admin.categorias.edit', { categoria: id }))
}

function goToDashboard() {
  Inertia.visit(route('admin.dashboard'))
}
</script>

<template>
  <div class="max-w-3xl mx-auto mt-8">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-3">
      <h1 class="text-2xl font-bold text-blue-800 flex items-center gap-2">
        <svg class="w-7 h-7 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v4a4 4 0 004 4h10a4 4 0 004-4V7M16 7V5a4 4 0 00-8 0v2" />
        </svg>
        Categorías
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
          <Plus class="w-4 h-4" /> Nueva categoría
        </button>
      </div>
    </div>

    <div class="bg-white shadow rounded-2xl overflow-hidden border">
      <table class="min-w-full text-gray-700">
        <thead class="bg-blue-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Nombre</th>
            <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="props.categorias.length === 0">
            <td colspan="2" class="text-center py-8 text-gray-400 italic">
              No hay categorías registradas.
            </td>
          </tr>
          <tr v-for="item in props.categorias" :key="item.categoria_id" class="hover:bg-blue-50 transition">
            <td class="px-6 py-3 border-b font-medium">{{ item.nombre }}</td>
            <td class="px-6 py-3 border-b flex justify-center gap-2">
              <button
                @click="goToEdit(item.categoria_id)"
                class="flex items-center gap-1 bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1.5 rounded-lg shadow transition"
                title="Editar"
              >
                <Edit class="w-4 h-4" /> Editar
              </button>
              <button
                @click="destroy(item.categoria_id)"
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
