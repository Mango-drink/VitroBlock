<script setup>
import { router, usePage } from '@inertiajs/vue3'
import { ref, watch } from 'vue'
import { route } from 'ziggy-js'
import { useToast } from 'vue-toastification'
import { ListChecks, Trash2, ArrowLeft } from 'lucide-vue-next'

const props = defineProps({
  operaciones: Object,   // paginadas
  filtros: Object,
  tipos: Array,
  entidades: Array,
  usuarios: Array
})

const toast = useToast()
const page = usePage()

const search = ref(props.filtros.search || '')
const tipo = ref(props.filtros.tipo || '')
const entidad = ref(props.filtros.entidad || '')
const usuario_id = ref(props.filtros.usuario_id || '')

// Cuando se cambia un filtro, recarga la tabla
function filtrar() {
  router.get(route('admin.operaciones.index'), {
    search: search.value,
    tipo: tipo.value,
    entidad: entidad.value,
    usuario_id: usuario_id.value,
  }, { preserveState: true, replace: true })
}

function destroy(id) {
  if (confirm('¿Eliminar este registro del historial?')) {
    router.delete(route('admin.operaciones.destroy', { operacion: id }), {
      onSuccess: () => toast.success('Operación eliminada correctamente.'),
      onError: () => toast.error('No se pudo eliminar la operación.')
    })
  }
}

function goToDashboard() {
  router.visit(route('admin.dashboard'))
}

// Para paginación
function cambiarPagina(url) {
  if (url) {
    router.visit(url, { preserveState: true, replace: true })
  }
}
</script>

<template>
  <div class="max-w-7xl mx-auto mt-8">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-3">
      <h1 class="text-2xl font-bold text-blue-800 flex items-center gap-2">
        <ListChecks class="w-7 h-7 text-blue-500" /> Bitácora de Operaciones
      </h1>
      <div>
        <button
          @click="goToDashboard"
          class="flex items-center gap-1 bg-gray-100 hover:bg-gray-200 text-gray-800 px-3 py-2 rounded-lg shadow border border-gray-300 transition font-semibold"
        >
          <ArrowLeft class="w-4 h-4" /> Dashboard
        </button>
      </div>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-2xl shadow p-4 mb-4 flex flex-col md:flex-row gap-4">
      <input
        v-model="search"
        @keyup.enter="filtrar"
        type="text"
        placeholder="Buscar en descripción..."
        class="border px-3 py-2 rounded-lg w-full md:w-1/4"
      />
      <select v-model="tipo" @change="filtrar" class="border px-3 py-2 rounded-lg w-full md:w-1/6">
        <option value="">Todos los tipos</option>
        <option v-for="t in props.tipos" :key="t" :value="t">{{ t }}</option>
      </select>
      <select v-model="entidad" @change="filtrar" class="border px-3 py-2 rounded-lg w-full md:w-1/6">
        <option value="">Todas las entidades</option>
        <option v-for="e in props.entidades" :key="e" :value="e">{{ e }}</option>
      </select>
      <select v-model="usuario_id" @change="filtrar" class="border px-3 py-2 rounded-lg w-full md:w-1/6">
        <option value="">Todos los usuarios</option>
        <option v-for="u in props.usuarios" :key="u.usuario_id" :value="u.usuario_id">{{ u.nombre }}</option>
      </select>
      <button
        @click="filtrar"
        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition"
      >Filtrar</button>
    </div>

    <!-- Tabla -->
    <div class="bg-white shadow rounded-2xl overflow-x-auto border">
      <table class="min-w-full text-gray-700">
        <thead class="bg-blue-50">
          <tr>
            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">ID</th>
            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Tipo</th>
            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Entidad</th>
            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">ID Entidad</th>
            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Descripción</th>
            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Cantidad</th>
            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Fecha y hora</th>
            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Usuario</th>
            <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="props.operaciones.data.length === 0">
            <td colspan="9" class="text-center py-8 text-gray-400 italic">
              No hay operaciones registradas.
            </td>
          </tr>
          <tr v-for="operacion in props.operaciones.data" :key="operacion.operacion_id" class="hover:bg-blue-50 transition">
            <td class="px-4 py-3 border-b font-mono text-sm">{{ operacion.operacion_id }}</td>
            <td class="px-4 py-3 border-b font-medium">{{ operacion.tipo }}</td>
            <td class="px-4 py-3 border-b">{{ operacion.entidad }}</td>
            <td class="px-4 py-3 border-b">{{ operacion.entidad_id }}</td>
            <td class="px-4 py-3 border-b">{{ operacion.descripcion }}</td>
            <td class="px-4 py-3 border-b">{{ operacion.cantidad ?? '-' }}</td>
            <td class="px-4 py-3 border-b">{{ operacion.fecha_hora }}</td>
            <td class="px-4 py-3 border-b">{{ operacion.usuario?.nombre ?? operacion.usuario_id }}</td>
            <td class="px-4 py-3 border-b flex justify-center gap-2">
              <button
                @click="destroy(operacion.operacion_id)"
                class="flex items-center gap-1 bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg shadow transition"
                title="Eliminar"
              >
                <Trash2 class="w-4 h-4" /> Eliminar
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Paginación -->
    <div class="flex justify-center mt-6 gap-2" v-if="props.operaciones.links">
      <button
        v-for="(link, i) in props.operaciones.links"
        :key="i"
        :disabled="!link.url"
        @click="cambiarPagina(link.url)"
        v-html="link.label"
        :class="[
          'px-3 py-2 rounded-lg',
          link.active ? 'bg-blue-600 text-white font-bold' : 'bg-gray-100 hover:bg-blue-100 text-gray-800'
        ]"
      />
    </div>
  </div>
</template>
