<script setup>
import { router, usePage } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

const page = usePage()
const user = page.props.auth.user
</script>

<template>
  <div>
    <p>Bienvenido, {{ user.nombre }}</p>
  </div>
  <div v-if="success" class="mb-4 bg-green-100 text-green-800 p-3 rounded border border-green-300 shadow">
      {{ success }}
  </div>

  <div class="min-h-screen bg-gray-100 flex flex-col">
    <header class="bg-white shadow p-4 flex items-center justify-between">
      <h1 class="text-2xl font-bold text-gray-700">Panel de Administración</h1>
      <span class="text-gray-500">Bienvenido, {{ user.nombre }}</span>
    </header>
    <main class="flex flex-1">
      <aside class="w-64 bg-white p-6 shadow-lg">
        <nav class="flex flex-col gap-4">
          <button @click="router.visit(route('admin.productos.index'))" class="text-left px-4 py-2 rounded hover:bg-blue-100">
            Productos
          </button>
          <button @click="router.visit(route('categorias.index'))" class="text-left px-4 py-2 rounded hover:bg-green-100">
            Categorías
          </button>
          <button @click="router.visit(route('origenes.index'))" class="text-left px-4 py-2 rounded hover:bg-yellow-100">
            Orígenes
          </button>
          <button @click="router.visit(route('roles.index'))" class="text-left px-4 py-2 rounded hover:bg-purple-100">
            Roles
          </button>
          <button @click="router.visit(route('usuarios.index'))" class="text-left px-4 py-2 rounded hover:bg-pink-100">
            Usuarios
          </button>
          <button @click="router.visit(route('operacion.index'))" class="text-left px-4 py-2 rounded hover:bg-red-100">
            Operaciones
          </button>
          <button @click="router.post(route('logout'))" class="text-left px-4 py-2 rounded hover:bg-gray-200 text-red-600 font-semibold">
            Cerrar sesión
          </button>
        </nav>
      </aside>
      <section class="flex-1 p-8">
        <h2 class="text-xl font-semibold mb-4">Selecciona una opción del menú para gestionar módulos.</h2>
        <!-- Aquí puedes renderizar contenido dinámico si quieres -->
      </section>
    </main>
  </div>
</template>
