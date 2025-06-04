<template>
  <table>
    <tr v-for="item in categorias" :key="item.categoria_id">
      <td>{{ item.nombre }}</td>
      <td>
        <button
          @click="destroy(item.categoria_id)"
          class="text-red-600 hover:underline"
        >
          Eliminar
        </button>
      </td>
    </tr>
  </table>
</template>

<script setup>
import { Inertia } from '@inertiajs/inertia'
import { usePage } from '@inertiajs/vue3'
import { watchEffect } from 'vue'

import { defineProps } from 'vue'

const props = defineProps({
  categorias: Array
})

function destroy(id) {
  if (!confirm('¿Eliminar esta categoría?')) return
  Inertia.delete(route('categorias.destroy', { categoria: id }))
}
</script>
