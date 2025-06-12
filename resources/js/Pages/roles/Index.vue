<script setup>
import { router, usePage } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import { useToast } from 'vue-toastification'
import { UserCog, Edit, Trash2, Plus, ArrowLeft } from 'lucide-vue-next'

const props = defineProps({
  roles: Array
})

const toast = useToast()

const page = usePage()
if (page.props.flash && page.props.flash.success) {
  toast.success(page.props.flash.success)
}

function destroy(id) {
  if (confirm('¿Eliminar este rol?')) {
    router.delete(route('roles.destroy', { rol: id }), {
      onSuccess: () => toast.success('Rol eliminado exitosamente.'),
      onError: () => toast.error('No se pudo eliminar el rol.')
    })
  }
}

function goToDashboard() {
  router.visit(route('admin.dashboard'))
}

function goToCreate() {
  router.visit(route('admin.roles.create'))
}

function goToEdit(id) {
  router.visit(route('admin.roles.edit', { rol: id }))
}
</script>

<template>
  <div class="max-w-3xl mx-auto mt-8">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-3">
      <h1 class="text-2xl font-bold text-blue-800 flex items-center gap-2">
        <UserCog class="w-7 h-7 text-blue-500" /> Roles
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
          <Plus class="w-4 h-4" /> Nuevo Rol
        </button>
      </div>
    </div>
    <div class="bg-white shadow rounded-2xl overflow-hidden border">
      <table class="min-w-full text-gray-700">
        <thead class="bg-blue-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Nombre</th>
            <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="props.roles.length === 0">
            <td colspan="2" class="text-center py-8 text-gray-400 italic">
              No hay roles registrados.
            </td>
          </tr>
          <tr v-for="rol in props.roles" :key="rol.rol_id" class="hover:bg-blue-50 transition">
            <td class="px-6 py-3 border-b font-medium">{{ rol.nombre }}</td>
            <td class="px-6 py-3 border-b flex justify-center gap-2">
              <button
                @click="goToEdit(rol.rol_id)"
                class="flex items-center gap-1 bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1.5 rounded-lg shadow transition"
                title="Editar"
              >
                <Edit class="w-4 h-4" /> Editar
              </button>
              <button
                @click="destroy(rol.rol_id)"
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
