<script setup>
import { ref, computed } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import { useToast } from 'vue-toastification'

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
  return Math.ceil(list.length / pageSize)
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
  return Math.ceil(list.length / pageSize)
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
  <div class="max-w-lg mx-auto mt-10 bg-white shadow-lg rounded-xl p-6">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-gray-800">Nueva Operación</h1>
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
        <label class="block mb-1 font-semibold">Tipo de operación</label>
        <select v-model="form.tipo" required class="border rounded p-2 w-full">
          <option value="">Selecciona tipo</option>
          <option value="alta">Alta</option>
          <option value="baja">Baja</option>
          <option value="modificación">Modificación</option>
        </select>
        <div v-if="errors.tipo" class="text-red-500">{{ errors.tipo }}</div>
      </div>

      <div>
        <label class="block mb-1 font-semibold">Cantidad</label>
        <input type="number" v-model="form.cantidad" required min="1" class="border rounded p-2 w-full" />
        <div v-if="errors.cantidad" class="text-red-500">{{ errors.cantidad }}</div>
      </div>

      <div>
        <label class="block mb-1 font-semibold">Fecha y hora</label>
        <input type="datetime-local" v-model="form.fecha_hora" required class="border rounded p-2 w-full" />
        <div v-if="errors.fecha_hora" class="text-red-500">{{ errors.fecha_hora }}</div>
      </div>

      <div>
        <label class="block mb-1 font-semibold">Producto</label>
        <input v-model="productoSearch" placeholder="Buscar producto..." class="border rounded p-2 w-full mb-2" />
        <select v-model="form.producto_id" required class="border rounded p-2 w-full">
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
            class="bg-gray-300 px-2 py-1 rounded disabled:opacity-50"
          >◀️</button>
          <span>Página {{ productoPage }} de {{ totalProductosPages }}</span>
          <button
            type="button"
            @click="productoPage = Math.min(totalProductosPages, productoPage + 1)"
            :disabled="productoPage === totalProductosPages"
            class="bg-gray-300 px-2 py-1 rounded disabled:opacity-50"
          >▶️</button>
        </div>
        <div v-if="errors.producto_id" class="text-red-500">{{ errors.producto_id }}</div>
      </div>

      <div>
        <label class="block mb-1 font-semibold">Usuario</label>
        <input v-model="usuarioSearch" placeholder="Buscar usuario..." class="border rounded p-2 w-full mb-2" />
        <select v-model="form.usuario_id" required class="border rounded p-2 w-full">
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
            class="bg-gray-300 px-2 py-1 rounded disabled:opacity-50"
          >◀️</button>
          <span>Página {{ usuarioPage }} de {{ totalUsuariosPages }}</span>
          <button
            type="button"
            @click="usuarioPage = Math.min(totalUsuariosPages, usuarioPage + 1)"
            :disabled="usuarioPage === totalUsuariosPages"
            class="bg-gray-300 px-2 py-1 rounded disabled:opacity-50"
          >▶️</button>
        </div>
        <div v-if="errors.usuario_id" class="text-red-500">{{ errors.usuario_id }}</div>
      </div>

      <button
        type="submit"
        class="bg-blue-500 text-white px-4 py-2 rounded mt-4 hover:bg-blue-700 transition"
        :disabled="form.processing"
      >
        Guardar Operación
      </button>
    </form>
  </div>
</template>
