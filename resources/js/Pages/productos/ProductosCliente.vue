<script setup>
defineProps(['productos']);
import { router } from '@inertiajs/vue3'

function logout() {
  router.post(route('logout'))
}
</script>





<template>
  <div class="max-w-3xl mx-auto mt-8 bg-white shadow-lg rounded-xl p-6">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Catálogo de Productos</h1>
    <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
      <thead>
        <tr class="bg-gray-100">
          <th class="px-4 py-2 text-left">Imagen</th> <!-- Nueva columna -->
          <th class="px-4 py-2 text-left">ID</th>
          <th class="px-4 py-2 text-left">Nombre</th>
          <th class="px-4 py-2 text-left">Precio</th>
          <th class="px-4 py-2 text-left">Categoría</th>
          <th class="px-4 py-2 text-left">Origen</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="producto in productos" :key="producto.producto_id" class="hover:bg-gray-50 transition">
          <td class="px-4 py-2">
            <!-- Aquí la imagen -->
            <img
              v-if="producto.imagen_url"
              :src="`/storage/${producto.imagen_url}`"
              class="h-16 w-16 object-cover rounded"
              alt="Imagen del producto"
            />
            <span v-else class="text-gray-400">Sin imagen</span>
          </td>
          <td class="px-4 py-2">{{ producto.producto_id }}</td>
          <td class="px-4 py-2">{{ producto.nombre }}</td>
          <td class="px-4 py-2">{{ producto.precio }}</td>
          <td class="px-4 py-2">{{ producto.categoria?.nombre || 'Sin categoría' }}</td>
          <td class="px-4 py-2">{{ producto.origen?.pais || 'Sin origen' }}</td>
        </tr>
      </tbody>
    </table>
  </div>
  <div>
    <button
      @click="logout"
      class="mt-6 px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition"
    >
      Cerrar sesión
    </button>
  </div>
</template>


