<script setup>
import { defineProps } from 'vue'
import { router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

const props = defineProps(['origenes'])

function goToCreate() {
  router.visit(route('origenes.create'))
}
function goToEdit(id) {
  router.visit(route('origenes.edit', id))
}
function eliminar(origen) {
  if (confirm(`¿Estás seguro que deseas eliminar el origen "${origen.pais}"?`)) {
    router.delete(route('origenes.destroy', origen.origen_id))
  }
}
function goToDashboard() {
  router.visit(route('admin.dashboard'))
}
</script>

<template>
  <div>
    <div v-if="$page.props.flash && $page.props.flash.success" class="bg-green-200 text-green-900 p-2 rounded mb-4">
      {{ $page.props.flash.success }}
    </div>
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">Lista de Orígenes</h1>
      <div class="flex gap-2">
        <button @click="goToDashboard" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-3 py-2 rounded shadow border border-gray-400 transition">
          ← Dashboard
        </button>
        <button @click="goToCreate" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
          Crear Origen
        </button>
      </div>
    </div>
    <table class="min-w-full border">
      <thead>
        <tr>
          <th class="px-4 py-2 border-b">ID</th>
          <th class="px-4 py-2 border-b">País</th>
          <th class="px-4 py-2 border-b">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="origen in props.origenes" :key="origen.origen_id" class="hover:bg-gray-100">
          <td class="px-4 py-2 border-b">{{ origen.origen_id }}</td>
          <td class="px-4 py-2 border-b">{{ origen.pais }}</td>
          <td class="px-4 py-2 border-b flex gap-2">
            <button @click="goToEdit(origen.origen_id)" class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500">Editar</button>
            <button @click="eliminar(origen)" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Eliminar</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
