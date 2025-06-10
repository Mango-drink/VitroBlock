<script setup>
import { useForm } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import { Inertia } from '@inertiajs/inertia'

// Declarar el formulario con el campo 'nombre'
const form = useForm({
  nombre: ''
})

// Función para enviar el formulario
const submit = () => {
  form.post(route('categorias.store'))
}

// Función para regresar al index de categorías
function goToIndex() {
  Inertia.visit(route('categorias.index'))
}
</script>

<template>
  <div class="max-w-md mx-auto mt-10 bg-white shadow-lg rounded-xl p-6">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-gray-800">Ingresa Nueva Categoría</h1>
      <button
        @click="goToIndex"
        type="button"
        class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-3 py-1 rounded shadow border border-gray-400 ml-4 transition"
      >
        ← Regresar
      </button>
    </div>
    <form @submit.prevent="submit">
      <label for="nombre" class="block mb-2 font-semibold">Nombre de la Categoría:</label>
      <input
        type="text"
        id="nombre"
        name="nombre"
        v-model="form.nombre"
        placeholder="Ej. Cerámica, Porcelanato"
        class="border rounded p-2 w-full"
      />

      <!-- Mostrar error de validación si existe -->
      <div v-if="form.errors.nombre" class="text-red-500 mt-1">
        {{ form.errors.nombre }}
      </div>

      <button
        type="submit"
        :disabled="form.processing"
        class="bg-blue-500 text-white px-4 py-2 rounded mt-4"
      >
        Guardar Categoría
      </button>
    </form>
  </div>
</template>
