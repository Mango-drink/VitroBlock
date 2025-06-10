<script setup>
import { useForm } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

const props = defineProps({
  categoria: Object
})

const form = useForm({
  nombre: props.categoria.nombre
})

function submit() {
  form.put(route('categorias.update', { categoria: props.categoria.categoria_id }))
}

function goToIndex() {
  router.visit(route('categorias.index'))
}
</script>

<template>
  <div class="max-w-md mx-auto mt-10 bg-white shadow-lg rounded-xl p-6">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-gray-800">Editar Categoría</h1>
      <button
        @click="goToIndex"
        type="button"
        class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-3 py-1 rounded shadow border border-gray-400 ml-4 transition"
      >
        ← Regresar
      </button>
    </div>
    <form @submit.prevent="submit" class="space-y-4">
      <div>
        <label for="nombre" class="block mb-2 font-semibold">Nombre de Categoría:</label>
        <input
          type="text"
          id="nombre"
          v-model="form.nombre"
          class="border rounded p-2 w-full"
        />
        <div v-if="form.errors.nombre" class="text-red-500 mt-1">{{ form.errors.nombre }}</div>
      </div>
      <button
        type="submit"
        :disabled="form.processing"
        class="bg-blue-500 text-white px-4 py-2 rounded mt-2 hover:bg-blue-700 transition"
      >
        Actualizar
      </button>
    </form>
  </div>
</template>
