<script setup>
import { useForm } from '@inertiajs/vue3'
import { watchEffect } from 'vue'

import { route }from 'ziggy-js'

// Declarar el formulario con el campo 'pais'
const form = useForm({
  pais: ''
})

// Función para enviar el formulario
const submit = () => {
  form.post(route('origenes.store'))
}
</script>

<template>
  <div>
    <h1>Ingresa Nuevo País</h1>

    <form @submit.prevent="submit">
      <label for="pais">País de Origen:</label>
      <input
        type="text"
        id="pais"
        name="pais"
        placeholder="Ej. México, España, Italia"
        v-model="form.pais"
        class="border rounded p-2"
      />

      <!-- Mostrar errores de validación (si existen) -->
      <div v-if="form.errors.pais" class="text-red-500">{{ form.errors.pais }}</div>

      <button
        type="submit"
        :disabled="form.processing"
        class="bg-blue-500 text-white px-4 py-2 rounded mt-2"
      >
        Guardar Origen
      </button>
    </form>
  </div>
</template>
