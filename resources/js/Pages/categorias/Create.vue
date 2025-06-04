<script setup>
import { useForm } from '@inertiajs/vue3'
import { watchEffect } from 'vue'

import { route } from 'ziggy-js'

// Declarar el formulario con el campo 'nombre'
const form = useForm({
  nombre: ''
})

// Función para enviar el formulario
const submit = () => {
  form.post(route('categorias.store'))
}
</script>

<template>
  <div>
    <h1>Ingresa Nueva Categoría</h1>

    <form @submit.prevent="submit">
      <label for="nombre">Nombre de la Categoría:</label>
      <input
        type="text"
        id="nombre"
        name="nombre"
        v-model="form.nombre"
        placeholder="Ej. Cerámica, Porcelanato"
        class="border rounded p-2"
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
