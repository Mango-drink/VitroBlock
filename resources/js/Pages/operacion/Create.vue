<script setup>
import { ref, computed } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import { useToast } from 'vue-toastification'
import { ListChecks, PlusCircle, ArrowLeft } from 'lucide-vue-next'

const props = defineProps({
  productos: Array,
  usuarios: Array
})

const toast = useToast()
const errors = usePage().props.errors || {}

const form = ref({
  tipo: '',
  cantidad: '',
  fecha_hora: '',
  producto_id: '',
  usuario_id: ''
})

const productoSearch = ref('')
const usuarioSearch = ref('')

const pageSize = 10
const productoPage = ref(1)
const usuarioPage = ref(1)

const filteredProductos = computed(() => {
  let list = props.productos
  if (productoSearch.value.trim() !== '') {
    list = list.filter(p =>
      p.nombre.toLowerCase().includes(productoSearch.value.trim().toLowerCase())
    )
  }
  const start = (productoPage.value - 1) * pageSize
  return list.slice(start, start + pageSize)
})

const totalProductosPages = computed(() => {
  let list = props.productos
  if (productoSearch.value.trim() !== '') {
    list = list.filter(p =>
      p.nombre.toLowerCase().includes(productoSearch.value.trim().toLowerCase())
    )
  }
  return Math.max(1, Math.ceil(list.length / pageSize))
})

const filteredUsuarios = computed(() => {
  let list = props.usuarios
  if (usuarioSearch.value.trim() !== '') {
    list = list.filter(u =>
      u.nombre.toLowerCase().includes(usuarioSearch.value.trim().toLowerCase())
    )
  }
  const start = (usuarioPage.value - 1) * pageSize
  return list.slice(start, start + pageSize)
})

const totalUsuariosPages = computed(() => {
  let list = props.usuarios
  if (usuarioSearch.value.trim() !== '') {
    list = list.filter(u =>
      u.nombre.toLowerCase().includes(usuarioSearch.value.trim().toLowerCase())
    )
  }
  return Math.max(1, Math.ceil(list.length / pageSize))
})

function submit() {
  router.post(route('operacion.store'), form.value, {
    onSuccess: () => toast.success('Operación creada correctamente.'),
    onError: () => toast.error('No se pudo crear la operación.')
  })
}

function goToIndex() {
  router.visit(route('operacion.index'))
}
</script>

<template>
  <div class="max-w-lg mx-auto mt-12 bg-white shadow-xl rounded-2xl px-8 py-8">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-3">
      <h1 class="text-2xl font-bold text-blue-800 flex items-center gap-2">
        <ListChecks class="w-6 h-6 text-blue-500" /> Nueva Operación
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
          :class="{ 'border-red-400': errors.tipo }"
        >
          <option value="">Selecciona tipo</option>
          <option value="alta">Alta</option>
          <option value="baja">Baja</option>
          <option value="modificación">Modificación</option>
        </select>
        <transition name="fade">
          <div v-if="errors.tipo" class="text-red-600 text-sm pl-1 font-semibold animate-pulse">
            {{ errors.tipo }}
          </div>
        </transition>
      </div>

      <div>
        <label class="font-semibold text-gray-700">Cantidad</label>
        <input
          type="number"
          v-model="form.cantidad"
          required
          min="1"
          class="border-2 border-blue-200 focus:border-blue-500 rounded-xl p-3 w-full text-gray-700 transition shadow-sm outline-none"
          :class="{ 'border-red-400': errors.cantidad }"
        />
        <transition name="fade">
          <div v-if="errors.cantidad" class="text-red-600 text-sm pl-1 font-semibold animate-pulse">
            {{ errors.cantidad }}
          </div>
        </transition>
      </div>

      <div>
        <label class="font-semibold text-gray-700">Fecha y hora</label>
        <input
          type="datetime-local"
          v-model="form.fecha_hora"
          required
          class="border-2 border-blue-200 focus:border-blue-500 rounded-xl p-3 w-full text-gray-700 transition shadow-sm outline-none"
          :class="{ 'border-red-400': errors.fecha_hora }"
        />
        <transition name="fade">
          <div v-if="errors.fecha_hora" class="text-red-600 text-sm pl-1 font-semibold animate-pulse">
            {{ errors.fecha_hora }}
          </div>
        </transition>
      </div>

      <div>
        <label class="font-semibold text-gray-700">Producto</label>
        <input
          v-model="productoSearch"
          placeholder="Buscar producto..."
          class="border-2 border-blue-100 rounded-xl p-2 w-full mb-2 text-gray-700 transition placeholder-gray-400 shadow-sm outline-none"
        />
        <select
          v-model="form.producto_id"
          required
          class="border-2 border-blue-200 focus:border-blue-500 rounded-xl p-3 w-full text-gray-700 transition shadow-sm outline-none"
          :class="{ 'border-red-400': errors.producto_id }"
        >
          <option value="">Selecciona producto</option>
          <option v-for="p in filteredProductos" :key="p.producto_id" :value="p.producto_id">
            {{ p.nombre }}
          </option>
        </select>
        <div class="flex items-center gap-2 mt-1">
          <button
            type="button"
            @click="productoPage = Math.max(1, productoPage - 1)"
            :disabled="productoPage === 1"
            class="bg-gray-200 hover:bg-blue-200 text-gray-700 px-2 py-1 rounded disabled:opacity-50 transition"
          >◀️</button>
          <span>Página {{ productoPage }} de {{ totalProductosPages }}</span>
          <button
            type="button"
            @click="productoPage = Math.min(totalProductosPages, productoPage + 1)"
            :disabled="productoPage === totalProductosPages"
            class="bg-gray-200 hover:bg-blue-200 text-gray-700 px-2 py-1 rounded disabled:opacity-50 transition"
          >▶️</button>
        </div>
        <transition name="fade">
          <div v-if="errors.producto_id" class="text-red-600 text-sm pl-1 font-semibold animate-pulse">
            {{ errors.producto_id }}
          </div>
        </transition>
      </div>

      <div>
        <label class="font-semibold text-gray-700">Usuario</label>
        <input
          v-model="usuarioSearch"
          placeholder="Buscar usuario..."
          class="border-2 border-blue-100 rounded-xl p-2 w-full mb-2 text-gray-700 transition placeholder-gray-400 shadow-sm outline-none"
        />
        <select
          v-model="form.usuario_id"
          required
          class="border-2 border-blue-200 focus:border-blue-500 rounded-xl p-3 w-full text-gray-700 transition shadow-sm outline-none"
          :class="{ 'border-red-400': errors.usuario_id }"
        >
          <option value="">Selecciona usuario</option>
          <option v-for="u in filteredUsuarios" :key="u.usuario_id" :value="u.usuario_id">
            {{ u.nombre }}
          </option>
        </select>
        <div class="flex items-center gap-2 mt-1">
          <button
            type="button"
            @click="usuarioPage = Math.max(1, usuarioPage - 1)"
            :disabled="usuarioPage === 1"
            class="bg-gray-200 hover:bg-blue-200 text-gray-700 px-2 py-1 rounded disabled:opacity-50 transition"
          >◀️</button>
          <span>Página {{ usuarioPage }} de {{ totalUsuariosPages }}</span>
          <button
            type="button"
            @click="usuarioPage = Math.min(totalUsuariosPages, usuarioPage + 1)"
            :disabled="usuarioPage === totalUsuariosPages"
            class="bg-gray-200 hover:bg-blue-200 text-gray-700 px-2 py-1 rounded disabled:opacity-50 transition"
          >▶️</button>
        </div>
        <transition name="fade">
          <div v-if="errors.usuario_id" class="text-red-600 text-sm pl-1 font-semibold animate-pulse">
            {{ errors.usuario_id }}
          </div>
        </transition>
      </div>

      <button
        type="submit"
        class="mt-4 bg-blue-600 hover:bg-blue-700 transition text-white font-bold px-6 py-3 rounded-xl shadow-lg flex items-center justify-center gap-2 disabled:opacity-60"
        :disabled="form.processing"
      >
        <PlusCircle class="w-5 h-5" /> Guardar Operación
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
