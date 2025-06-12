<script setup>
import { useForm } from '@inertiajs/vue3'
import { Inertia } from '@inertiajs/inertia'
import { route } from 'ziggy-js'
import { ArrowLeft, Globe, PlusCircle } from 'lucide-vue-next'

const form = useForm({
  pais: ''
})

function goToIndex() {
  Inertia.visit(route('admin.origenes.index'))
}

const submit = () => {
  form.post(route('admin.origenes.store'))
}
</script>

<template>
  <div class="max-w-lg mx-auto mt-12 bg-white shadow-xl rounded-2xl px-8 py-8">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-3">
      <h1 class="text-2xl font-bold text-blue-800 flex items-center gap-2">
        <Globe class="w-7 h-7 text-blue-500" /> Nuevo Origen
      </h1>
      <button
        @click="goToIndex"
        type="button"
        class="flex items-center gap-1 bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-lg shadow border border-gray-300 transition font-semibold"
      >
        <ArrowLeft class="w-4 h-4" /> Orígenes
      </button>
    </div>
    <form @submit.prevent="submit" class="flex flex-col gap-3">
      <label for="pais" class="font-semibold text-gray-700">País de Origen</label>
      <input
        type="text"
        id="pais"
        name="pais"
        v-model="form.pais"
        placeholder="Ej. México, España, Italia"
        class="border-2 border-blue-200 focus:border-blue-500 rounded-xl p-3 w-full text-gray-700 transition placeholder-gray-400 shadow-sm outline-none"
        :class="{ 'border-red-400': form.errors.pais }"
        autocomplete="off"
      />

      <transition name="fade">
        <div v-if="form.errors.pais" class="text-red-600 text-sm pl-1 font-semibold animate-pulse">
          {{ form.errors.pais }}
        </div>
      </transition>

      <button
        type="submit"
        :disabled="form.processing"
        class="mt-4 bg-blue-600 hover:bg-blue-700 transition text-white font-bold px-6 py-3 rounded-xl shadow-lg flex items-center justify-center gap-2 disabled:opacity-60"
      >
        <PlusCircle class="w-5 h-5" /> Guardar Origen
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
