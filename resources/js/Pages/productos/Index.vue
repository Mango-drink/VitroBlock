<script setup>
import { usePage } from '@inertiajs/vue3'
import { watchEffect } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { useToast } from 'vue-toastification'
import { route } from 'ziggy-js' // <--- ¡Esto es importante!

const page = usePage()
const toast = useToast()

// Toast para mensajes de éxito/error
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

function destroy(id) {
  if (!confirm('¿Eliminar este producto?')) return
  Inertia.delete(route('productos.destroy', { producto: id }))
}
</script>

<template>
  <div>
    <h1 class="text-2xl font-bold mb-4">Productos</h1>

    <!-- Botón para agregar producto -->
    <a
      :href="route('productos.create')"
      class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block"
    >+ Agregar producto</a>

    <table class="min-w-full border border-gray-300">
      <thead>
        <tr>
          <th>Código</th>
          <th>Nombre</th>
          <th>Categoría</th>
          <th>Origen</th>
          <th>Precio</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="prod in productos" :key="prod.producto_id">
          <td>{{ prod.codigo }}</td>
          <td>{{ prod.nombre }}</td>
          <td>{{ prod.categoria ? prod.categoria.nombre : 'Sin categoría' }}</td>
          <td>{{ prod.origen ? prod.origen.pais : 'Sin origen' }}</td>
          <td>{{ prod.precio }}</td>
          <td>
            <a
              :href="route('productos.edit', { producto: prod.producto_id })"
              class="text-blue-600 hover:underline mr-2"
            >Editar</a>
            <button
              @click="destroy(prod.producto_id)"
              class="text-red-600 hover:underline"
            >Eliminar</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
