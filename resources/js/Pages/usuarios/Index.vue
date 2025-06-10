<script setup>
import { router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import { useToast } from 'vue-toastification'
import { usePage } from '@inertiajs/vue3'

const props = defineProps({
  usuarios: Array
})

const toast = useToast()
const page = usePage()

if (page.props.flash && page.props.flash.success) {
  toast.success(page.props.flash.success)
}

function destroy(id) {
  if (confirm('¿Eliminar este usuario?')) {
    router.delete(route('usuarios.destroy', id), {
      onSuccess: () => toast.success('Usuario eliminado exitosamente.')
    })
  }
}

function goToDashboard() {
  router.visit(route('admin.dashboard'))
}

function goToCreate() {
  router.visit(route('usuarios.create'))
}

function goToEdit(id) {
  router.visit(route('usuarios.edit', id))
}
</script>

<template>
  <div>
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">Usuarios</h1>
      <div class="flex gap-2">
        <button
          @click="goToDashboard"
          class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-3 py-2 rounded shadow border border-gray-400 transition"
        >← Dashboard</button>
        <button
          @click="goToCreate"
          class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition"
        >Nuevo Usuario</button>
      </div>
    </div>
    <table class="min-w-full border border-gray-300">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-4 py-2 border-b">Nombre</th>
          <th class="px-4 py-2 border-b">Correo</th>
          <th class="px-4 py-2 border-b">Rol</th>
          <th class="px-4 py-2 border-b">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="usuario in usuarios" :key="usuario.usuario_id" class="hover:bg-gray-50">
          <td class="px-4 py-2 border-b">{{ usuario.nombre }}</td>
          <td class="px-4 py-2 border-b">{{ usuario.email }}</td>
          <td class="px-4 py-2 border-b">{{ usuario.rol?.nombre || 'Sin rol' }}</td>
          <td class="px-4 py-2 border-b flex gap-2">
            <button
              @click="goToEdit(usuario.usuario_id)"
              class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500 transition"
            >Editar</button>
            <button
              @click="destroy(usuario.usuario_id)"
              class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition"
            >Eliminar</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
