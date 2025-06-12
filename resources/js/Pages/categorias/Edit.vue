<script setup>
import { useForm, router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import { ArrowLeft, Save } from 'lucide-vue-next'

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
  <div class="max-w-lg mx-auto mt-12 bg-white shadow-xl rounded-2xl px-8 py-8">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-3">
      <h1 class="text-2xl font-bold text-blue-800 flex items-center gap-2">
        <Save class="w-6 h-6 text-blue-500" /> Editar Categoría
      </h1>
      <button
        @click="goToIndex"
        type="button"
        class="flex items-center gap-1 bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-lg shadow border border-gray-300 transition font-semibold"
      >
        <ArrowLeft class="w-4 h-4" /> Categorías
      </button>
    </div>
    <form @submit.prevent="submit" class="flex flex-col gap-3">
      <label for="nombre" class="font-semibold text-gray-700">Nombre de la Categoría</label>
      <input
        type="text"
        id="nombre"
        v-model="form.nombre"
        class="border-2 border-blue-200 focus:border-blue-500 rounded-xl p-3 w-full text-gray-700 transition placeholder-gray-400 shadow-sm outline-none"
        :class="{ 'border-red-400': form.errors.nombre }"
        autocomplete="off"
      />

      <transition name="fade">
        <div v-if="form.errors.nombre" class="text-red-600 text-sm pl-1 font-semibold animate-pulse">
          {{ form.errors.nombre }}
        </div>
      </transition>

      <button
        type="submit"
        :disabled="form.processing"
        class="mt-4 bg-blue-600 hover:bg-blue-700 transition text-white font-bold px-6 py-3 rounded-xl shadow-lg flex items-center justify-center gap-2 disabled:opacity-60"
      >
        <Save class="w-5 h-5" /> Actualizar Categoría
      </button>
    </form>
  </div>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity .3s;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
