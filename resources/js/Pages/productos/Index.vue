<script setup>
import { usePage, router } from '@inertiajs/vue3'
import { watchEffect } from 'vue'
import { useToast } from 'vue-toastification'
import { route } from 'ziggy-js'

const page = usePage()
const toast = useToast()
const user = usePage().props.auth.user

watchEffect(() => {
  if (page.props.flash && page.props.flash.success) {
    toast.success(page.props.flash.success)
  }
  if (page.props.flash && page.props.flash.danger) {
    toast.error(page.props.flash.danger)
  }
})

const props = defineProps({
  productos: Array
})

function goToCreate() {
  router.visit(route('productos.create'))
}
function goToEdit(id) {
  router.visit(route('productos.edit', { producto: id }))
}
function destroy(id) {
  if (!confirm('¿Eliminar este producto?')) return
  router.delete(route('productos.destroy', { producto: id }))
}
function goToDashboard() {
  router.visit(route('admin.dashboard'))
}
</script>

<template>
  <div class="min-h-screen bg-gradient-to-tr from-gray-50 to-blue-50 py-10 px-4">
    <div class="max-w-6xl mx-auto bg-white shadow-xl rounded-2xl p-8">
      <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 gap-4">
        <div>
          <h1 class="text-3xl font-extrabold text-blue-800 tracking-tight mb-1">Gestión de Productos</h1>
          <p class="text-gray-600 text-base">Administra aquí los productos del sistema.</p>
        </div>
        <div class="flex gap-2">
          <button
            @click="goToDashboard"
            class="bg-gray-100 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg shadow border border-gray-300 transition font-semibold"
          >
            ← Dashboard
          </button>
          <button
            v-if="user && user.rol_id === 1"
            @click="goToCreate"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition font-semibold"
          >+ Agregar producto
          </button>
        </div>
      </div>

      <div class="overflow-x-auto rounded-xl border border-gray-200 bg-white">
        <table class="min-w-full text-base">
          <thead class="bg-blue-100">
            <tr>
              <th class="px-4 py-2 border-b text-left font-bold text-blue-700">Código</th>
              <th class="px-4 py-2 border-b text-left font-bold text-blue-700">Nombre</th>
              <th class="px-4 py-2 border-b text-left font-bold text-blue-700">Categoría</th>
              <th class="px-4 py-2 border-b text-left font-bold text-blue-700">Origen</th>
              <th class="px-4 py-2 border-b text-left font-bold text-blue-700">Precio</th>
              <th class="px-4 py-2 border-b text-left font-bold text-blue-700">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="prod in props.productos"
              :key="prod.producto_id"
              class="hover:bg-blue-50 transition"
            >
              <td class="px-4 py-2 border-b">{{ prod.codigo }}</td>
              <td class="px-4 py-2 border-b">{{ prod.nombre }}</td>
              <td class="px-4 py-2 border-b">{{ prod.categoria ? prod.categoria.nombre : 'Sin categoría' }}</td>
              <td class="px-4 py-2 border-b">{{ prod.origen ? prod.origen.pais : 'Sin origen' }}</td>
              <td class="px-4 py-2 border-b">${{ Number(prod.precio).toFixed(2) }}</td>
              <td class="px-4 py-2 border-b flex gap-2">
                <button
                  @click="goToEdit(prod.producto_id)"
                  class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500 transition font-semibold shadow"
                >Editar</button>
                <button
                  @click="destroy(prod.producto_id)"
                  class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition font-semibold shadow"
                >Eliminar</button>
              </td>
            </tr>
            <tr v-if="!props.productos.length">
              <td colspan="6" class="py-6 text-center text-gray-500">No hay productos registrados.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>
