<script setup>
import { usePage } from '@inertiajs/vue3'
import { watchEffect } from 'vue'

import { route } from 'ziggy-js'

// Recibimos la categoría completa como prop
const props = defineProps({
  categoria: Object
})

// Inicializamos el formulario con el valor actual
const form = useForm({
  nombre: props.categoria.nombre
  // …otros campos si hubiera
})

const submit = () => {
  // Aquí pasamos el ID correcto: props.categoria.categoria_id
  form.put(route('categorias.update', { categoria: props.categoria.categoria_id }))
}
</script>

<template>
  <div>
    <h1>Editar Categoría</h1>
    <form @submit.prevent="submit">
      <label for="nombre">Nombre de Categoría:</label>
      <input
        type="text"
        id="nombre"
        v-model="form.nombre"
        class="border rounded p-2"
      />
      <div v-if="form.errors.nombre" class="text-red-500">{{ form.errors.nombre }}</div>
      <button
        type="submit"
        :disabled="form.processing"
        class="bg-blue-500 text-white px-4 py-2 rounded mt-2"
      >
        Actualizar
      </button>
    </form>
  </div>
</template>
