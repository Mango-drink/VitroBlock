<script setup>
import { Inertia } from '@inertiajs/inertia'
import { route } from 'ziggy-js'
import { defineProps } from 'vue'

const props = defineProps({
  categorias: Array
})

function destroy(id) {
  if (!confirm('¿Eliminar esta categoría?')) return
  Inertia.delete(route('categorias.destroy', { categoria: id }))
}

function goToCreate() {
  Inertia.visit(route('categorias.create'))
}

function goToEdit(id) {
  Inertia.visit(route('categorias.edit', { categoria: id }))
}

function goToDashboard() {
  Inertia.visit(route('admin.dashboard'))
}
</script>

<template>
  <div>
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-xl font-bold">Categorías</h1>
      <div class="flex gap-2">
        <button
          @click="goToDashboard"
          class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-3 py-2 rounded shadow border border-gray-400 transition"
        >← Dashboard</button>
        <button
          @click="goToCreate"
          class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition"
        >Agregar categoría</button>
      </div>
    </div>
    <table class="min-w-full border">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-4 py-2 border-b">Nombre</th>
          <th class="px-4 py-2 border-b">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in categorias" :key="item.categoria_id" class="hover:bg-gray-50">
          <td class="px-4 py-2 border-b">{{ item.nombre }}</td>
          <td class="px-4 py-2 border-b flex gap-2">
            <button
              @click="goToEdit(item.categoria_id)"
              class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500 transition"
            >Editar</button>
            <button
              @click="destroy(item.categoria_id)"
              class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition"
            >Eliminar</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
