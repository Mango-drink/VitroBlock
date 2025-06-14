<script setup>
import { ref, computed } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import { useToast } from 'vue-toastification'
import { Users, Edit, Trash2, Plus, ArrowLeft, User } from 'lucide-vue-next'

const props = defineProps({
  usuarios: Array,
  roles: Array
})

const toast = useToast()
const page = usePage()

if (page.props.flash && page.props.flash.success) {
  toast.success(page.props.flash.success)
}

// === FILTRO POR INICIAL ===
const selectedLetter = ref('') // '' para ver todos
const busquedaNombre = ref('')
const filtroRol = ref('')

/*const letras = computed(() => {
  // Genera el conjunto de letras únicas con las que inicia el nombre de algún usuario
  return [...new Set(props.usuarios.map(u => u.nombre[0]?.toUpperCase()))].sort()
})*/
const rolesUnicos = computed(() => {
  const mapa = {}
  props.usuarios.forEach(u => {
    if (u.rol) {
      mapa[u.rol.rol_id] = u.rol.nombre
    }
  })
  // Retorna array de objetos {rol_id, nombre}
  return Object.entries(mapa).map(([rol_id, nombre]) => ({ rol_id, nombre }))
})

const usuariosFiltrados = computed(() => {
  return props.usuarios
    .filter(u => !busquedaNombre.value || u.nombre.toLowerCase().includes(busquedaNombre.value.toLowerCase()))
    .filter(u => !filtroRol.value || (u.rol && u.rol.rol_id == filtroRol.value))
    // Si quieres también aplicar filtro por inicial, puedes agregarlo aquí
    .filter(u => !selectedLetter.value || u.nombre[0]?.toUpperCase() === selectedLetter.value)
})

// Funciones originales...
function destroy(id) {
  if (confirm('¿Eliminar este usuario?')) {
    router.delete(route('admin.usuarios.destroy', id), {
      onSuccess: () => toast.success('Usuario eliminado exitosamente.')
    })
  }
}

function goToDashboard() {
  router.visit(route('admin.dashboard'))
}

function goToCreate() {
  router.visit(route('admin.usuarios.create'))
}

function goToEdit(id) {
  router.visit(route('admin.usuarios.edit', id))
}
</script>

<template>
  <div class="max-w-5xl mx-auto mt-8">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-3">
      <h1 class="text-2xl font-bold text-blue-800 flex items-center gap-2">
        <Users class="w-7 h-7 text-blue-500" /> Usuarios
      </h1>
      <div class="flex gap-2">
        <button
          @click="goToDashboard"
          class="flex items-center gap-1 bg-gray-100 hover:bg-gray-200 text-gray-800 px-3 py-2 rounded-lg shadow border border-gray-300 transition font-semibold"
        >
          <ArrowLeft class="w-4 h-4" /> Dashboard
        </button>
        <button
          @click="goToCreate"
          class="flex items-center gap-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow font-semibold transition"
        >
          <Plus class="w-4 h-4" /> Nuevo Usuario
        </button>
      </div>
    </div>

    <!-- FILTRO POR NOMBRE Y ROL -->
    <div class="flex items-center mb-4 gap-3">
      <input
        v-model="busquedaNombre"
        @input="aplicarFiltros"
        type="text"
        placeholder="Buscar por nombre..."
        class="border px-3 py-2 rounded w-60"
      />
      <select v-model="filtroRol" @change="aplicarFiltros" class="border px-3 py-2 rounded w-60">
        <option value="">Todos los roles</option>
        <option v-for="rol in rolesUnicos" :key="rol.rol_id" :value="rol.rol_id">{{ rol.nombre }}</option>
      </select>
    </div>

    <div class="bg-white shadow rounded-2xl overflow-hidden border">
      <table class="min-w-full text-gray-700">
        <thead class="bg-blue-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Nombre</th>
            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Correo</th>
            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Rol</th>
            <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="usuariosFiltrados.length === 0">
            <td colspan="4" class="text-center py-8 text-gray-400 italic">
              <User class="inline mr-2 w-5 h-5" /> No hay usuarios para esta letra.
            </td>
          </tr>
          <tr v-for="usuario in usuariosFiltrados" :key="usuario.usuario_id" class="hover:bg-blue-50 transition">
            <td class="px-6 py-3 border-b font-medium">{{ usuario.nombre }}</td>
            <td class="px-6 py-3 border-b font-mono text-sm">{{ usuario.email }}</td>
            <td class="px-6 py-3 border-b">
              <span v-if="usuario.rol" class="inline-flex items-center gap-1 bg-blue-100 text-blue-700 px-2 py-0.5 rounded text-xs font-semibold">
                {{ usuario.rol.nombre }}
              </span>
              <span v-else class="inline-block bg-gray-100 text-gray-500 px-2 py-0.5 rounded text-xs">Sin rol</span>
            </td>
            <td class="px-6 py-3 border-b flex justify-center gap-2">
              <button
                @click="goToEdit(usuario.usuario_id)"
                class="flex items-center gap-1 bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1.5 rounded-lg shadow transition"
                title="Editar"
              >
                <Edit class="w-4 h-4" /> Editar
              </button>
              <button
                @click="destroy(usuario.usuario_id)"
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
  </div>
</template>
