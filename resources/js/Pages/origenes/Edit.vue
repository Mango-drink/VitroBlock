<script setup>
import { useForm } from '@inertiajs/vue3'
import { defineProps } from 'vue'
import { router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

const props = defineProps({
  origen: Object
})

const form = useForm({
  pais: props.origen.pais
})

function submit() {
  form.put(route('origenes.update', props.origen.origen_id), {
    onSuccess: () => {
      window.location.href = route('origenes.index');
    }
  })
}

function goToDashboard() {
  router.visit(route('admin.dashboard'))
}
</script>

<template>
  <div class="max-w-lg mx-auto mt-10 bg-white shadow-lg rounded-xl p-6">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-gray-800">Editar Origen</h1>
      <button
        @click="goToDashboard"
        type="button"
        class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-3 py-1 rounded shadow border border-gray-400 ml-4 transition"
      >
        ← Dashboard
      </button>
    </div>
    <form @submit.prevent="submit">
      <div class="mb-4">
        <label for="pais" class="block font-semibold mb-1">País:</label>
        <input v-model="form.pais" id="pais" type="text" required class="border rounded px-3 py-2 w-full" />
        <div v-if="form.errors.pais" class="text-red-600 mt-1">{{ form.errors.pais }}</div>
      </div>
      <button
        type="submit"
        :disabled="form.processing"
        class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-4 py-2 rounded shadow mt-4 transition"
      >
        Actualizar
      </button>
    </form>
  </div>
</template>
