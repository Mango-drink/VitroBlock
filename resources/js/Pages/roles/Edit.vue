<script setup>
import { ref } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import { useToast } from 'vue-toastification'

const props = defineProps({
  rol: Object
})

const form = ref({
  nombre: props.rol.nombre
})

const toast = useToast()
const errors = usePage().props.errors || {}

function submit() {
    const rol_id = props.rol.rol_id ?? props.rol.id
    router.put(route('roles.update', { rol: rol_id }), form.value, {
        onSuccess: () => toast.success('Rol actualizado exitosamente.'),
        onError: () => toast.error('Hubo un error al actualizar el rol.')
    })
}

function goToIndex() {
  router.visit(route('roles.index'))
}
</script>

<template>
  <div class="max-w-md mx-auto mt-10 bg-white shadow-lg rounded-xl p-6">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-gray-800">Editar Rol</h1>
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
        <label for="nombre" class="block mb-2 font-semibold">Nombre del rol:</label>
        <input
          id="nombre"
          v-model="form.nombre"
          required
          class="border rounded p-2 w-full"
        />
        <div v-if="errors.nombre" class="text-red-500 mt-1">{{ errors.nombre }}</div>
      </div>
      <button
        type="submit"
        :disabled="form.processing"
        class="bg-blue-500 text-white px-4 py-2 rounded mt-4 hover:bg-blue-700 transition"
      >
        Actualizar
      </button>
    </form>
  </div>
</template>
