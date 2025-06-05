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

// Formulario reactivo
const form = ref({
  tipo: '',
  cantidad: '',
  fecha_hora: '',
  producto_id: '',
  usuario_id: ''
})

// Buscadores reactivos
const productoSearch = ref('')
const usuarioSearch = ref('')

// Paginación básica
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
</script>

<template>
  <div>
    <h1>Nueva Operación</h1>
    <form @submit.prevent="submit">
      <div>
        <label>Tipo de operación</label>
        <select v-model="form.tipo" required>
          <option value="">Selecciona tipo</option>
          <option value="alta">Alta</option>
          <option value="baja">Baja</option>
          <option value="modificación">Modificación</option>
        </select>
        <div v-if="errors.tipo" style="color: red;">{{ errors.tipo }}</div>
      </div>

      <div>
        <label>Cantidad</label>
        <input type="number" v-model="form.cantidad" required min="1" />
        <div v-if="errors.cantidad" style="color: red;">{{ errors.cantidad }}</div>
      </div>

      <div>
        <label>Fecha y hora</label>
        <input type="datetime-local" v-model="form.fecha_hora" required />
        <div v-if="errors.fecha_hora" style="color: red;">{{ errors.fecha_hora }}</div>
      </div>

      <div>
        <label>Producto</label>
        <input v-model="productoSearch" placeholder="Buscar producto..." />
        <select v-model="form.producto_id" required>
          <option value="">Selecciona producto</option>
          <option v-for="p in filteredProductos" :key="p.producto_id" :value="p.producto_id">
            {{ p.nombre }}
          </option>
        </select>
        <div>
          <button type="button" @click="productoPage = Math.max(1, productoPage - 1)" :disabled="productoPage === 1">◀️</button>
          Página {{ productoPage }} de {{ totalProductosPages }}
          <button type="button" @click="productoPage = Math.min(totalProductosPages, productoPage + 1)" :disabled="productoPage === totalProductosPages">▶️</button>
        </div>
        <div v-if="errors.producto_id" style="color: red;">{{ errors.producto_id }}</div>
      </div>

      <div>
        <label>Usuario</label>
        <input v-model="usuarioSearch" placeholder="Buscar usuario..." />
        <select v-model="form.usuario_id" required>
          <option value="">Selecciona usuario</option>
          <option v-for="u in filteredUsuarios" :key="u.usuario_id" :value="u.usuario_id">
            {{ u.nombre }}
          </option>
        </select>
        <div>
          <button type="button" @click="usuarioPage = Math.max(1, usuarioPage - 1)" :disabled="usuarioPage === 1">◀️</button>
          Página {{ usuarioPage }} de {{ totalUsuariosPages }}
          <button type="button" @click="usuarioPage = Math.min(totalUsuariosPages, usuarioPage + 1)" :disabled="usuarioPage === totalUsuariosPages">▶️</button>
        </div>
        <div v-if="errors.usuario_id" style="color: red;">{{ errors.usuario_id }}</div>
      </div>

      <button type="submit">Guardar</button>
    </form>
  </div>
</template>
