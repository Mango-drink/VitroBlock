<script setup>
import { useForm } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import { ArrowLeft, Save, ListChecks } from 'lucide-vue-next'

const props = defineProps({
  operacion: Object,
  productos: Array,
  usuarios: Array,
})

const form = useForm({
  tipo: props.operacion.tipo,
  cantidad: props.operacion.cantidad,
  fecha_hora: props.operacion.fecha_hora,
  producto_id: props.operacion.producto_id,
  usuario_id: props.operacion.usuario_id,
})

function submit() {
  form.put(route('operacion.update', props.operacion.operacion_id))
}

function goToIndex() {
  router.visit(route('operacion.index'))
}
</script>

<template>
  <div class="max-w-lg mx-auto mt-12 bg-white shadow-xl rounded-2xl px-8 py-8">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-3">
      <h1 class="text-2xl font-bold text-blue-800 flex items-center gap-2">
        <ListChecks class="w-6 h-6 text-blue-500" /> Editar Operación
      </h1>
      <button
        @click="goToIndex"
        type="button"
        class="flex items-center gap-1 bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-lg shadow border border-gray-300 transition font-semibold"
      >
        <ArrowLeft class="w-4 h-4" /> Operaciones
      </button>
    </div>
    <form @submit.prevent="submit" class="flex flex-col gap-4">
      <div>
        <label class="font-semibold text-gray-700">Tipo de operación</label>
        <select
          v-model="form.tipo"
          required
          class="border-2 border-blue-200 focus:border-blue-500 rounded-xl p-3 w-full text-gray-700 transition shadow-sm outline-none"
          :class="{ 'border-red-400': form.errors.tipo }"
        >
          <option value="">Seleccione</option>
          <option value="alta">Alta</option>
          <option value="baja">Baja</option>
          <option value="modificación">Modificación</option>
        </select>
        <transition name="fade">
          <div v-if="form.errors.tipo" class="text-red-600 text-sm pl-1 font-semibold animate-pulse">
            {{ form.errors.tipo }}
          </div>
        </transition>
      </div>
      <div>
        <label class="font-semibold text-gray-700">Cantidad</label>
        <input
          v-model="form.cantidad"
          type="number"
          min="1"
          required
          class="border-2 border-blue-200 focus:border-blue-500 rounded-xl p-3 w-full text-gray-700 transition shadow-sm outline-none"
          :class="{ 'border-red-400': form.errors.cantidad }"
        />
        <transition name="fade">
          <div v-if="form.errors.cantidad" class="text-red-600 text-sm pl-1 font-semibold animate-pulse">
            {{ form.errors.cantidad }}
          </div>
        </transition>
      </div>
      <div>
        <label class="font-semibold text-gray-700">Fecha y hora</label>
        <input
          v-model="form.fecha_hora"
          type="datetime-local"
          required
          class="border-2 border-blue-200 focus:border-blue-500 rounded-xl p-3 w-full text-gray-700 transition shadow-sm outline-none"
          :class="{ 'border-red-400': form.errors.fecha_hora }"
        />
        <transition name="fade">
          <div v-if="form.errors.fecha_hora" class="text-red-600 text-sm pl-1 font-semibold animate-pulse">
            {{ form.errors.fecha_hora }}
          </div>
        </transition>
      </div>
      <div>
        <label class="font-semibold text-gray-700">Producto</label>
        <select
          v-model="form.producto_id"
          required
          class="border-2 border-blue-200 focus:border-blue-500 rounded-xl p-3 w-full text-gray-700 transition shadow-sm outline-none"
          :class="{ 'border-red-400': form.errors.producto_id }"
        >
          <option value="">Seleccione</option>
          <option v-for="prod in props.productos" :key="prod.producto_id" :value="prod.producto_id">{{ prod.nombre }}</option>
        </select>
        <transition name="fade">
          <div v-if="form.errors.producto_id" class="text-red-600 text-sm pl-1 font-semibold animate-pulse">
            {{ form.errors.producto_id }}
          </div>
        </transition>
      </div>
      <div>
        <label class="font-semibold text-gray-700">Usuario</label>
        <select
          v-model="form.usuario_id"
          required
          class="border-2 border-blue-200 focus:border-blue-500 rounded-xl p-3 w-full text-gray-700 transition shadow-sm outline-none"
          :class="{ 'border-red-400': form.errors.usuario_id }"
        >
          <option value="">Seleccione</option>
          <option v-for="user in props.usuarios" :key="user.usuario_id" :value="user.usuario_id">{{ user.nombre }}</option>
        </select>
        <transition name="fade">
          <div v-if="form.errors.usuario_id" class="text-red-600 text-sm pl-1 font-semibold animate-pulse">
            {{ form.errors.usuario_id }}
          </div>
        </transition>
      </div>
      <button
        type="submit"
        class="mt-4 bg-blue-600 hover:bg-blue-700 transition text-white font-bold px-6 py-3 rounded-xl shadow-lg flex items-center justify-center gap-2 disabled:opacity-60"
        :disabled="form.processing"
      >
        <Save class="w-5 h-5" /> Guardar Cambios
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
