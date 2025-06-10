<script setup>
import { ref } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import { useToast } from 'vue-toastification'

const props = defineProps({
  usuario: Object,
  roles: Array
})

const form = ref({
  nombre: props.usuario.nombre,
  email: props.usuario.email,
  rol_id: props.usuario.rol_id
})

const toast = useToast()
const errors = usePage().props.errors || {}

function submit() {
  router.put(route('usuarios.update', props.usuario.usuario_id), form.value, {
    onSuccess: () => toast.success('Usuario actualizado exitosamente.'),
    onError: () => toast.error('Hubo un error al actualizar el usuario.')
  })
}

function goToIndex() {
  router.visit(route('usuarios.index'))
}
</script>

<template>
  <div class="max-w-lg mx-auto mt-10 bg-white shadow-lg rounded-xl p-6">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-gray-800">Editar Usuario</h1>
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
        <label for="nombre" class="block mb-2 font-semibold">Nombre:</label>
        <input
          v-model="form.nombre"
          id="nombre"
          required
          class="border rounded p-2 w-full"
        />
        <div v-if="errors.nombre" class="text-red-500 mt-1">{{ errors.nombre }}</div>
      </div>
      <div>
        <label for="email" class="block mb-2 font-semibold">Correo electrónico:</label>
        <input
          v-model="form.email"
          id="email"
          type="email"
          required
          class="border rounded p-2 w-full"
        />
        <div v-if="errors.email" class="text-red-500 mt-1">{{ errors.email }}</div>
      </div>
      <div>
        <label for="rol_id" class="block mb-2 font-semibold">Rol:</label>
        <select
          v-model="form.rol_id"
          id="rol_id"
          required
          class="border rounded p-2 w-full"
        >
          <option value="">Seleccione un rol</option>
          <option v-for="rol in roles" :key="rol.rol_id" :value="rol.rol_id">{{ rol.nombre }}</option>
        </select>
        <div v-if="errors.rol_id" class="text-red-500 mt-1">{{ errors.rol_id }}</div>
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
