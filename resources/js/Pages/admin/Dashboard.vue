<script setup>
import { router, usePage } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import { LogOut, Package, Users, Layers, Globe, Tag, List } from 'lucide-vue-next'

const page = usePage()
const user = page.props.auth.user
</script>

<template>
  <div class="min-h-screen bg-gradient-to-tr from-gray-50 to-blue-50 flex flex-col">
    <!-- Header -->
    <header class="bg-white shadow p-4 flex items-center justify-between">
      <div class="flex items-center gap-2">
        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v4a4 4 0 004 4h10a4 4 0 004-4V7M16 7V5a4 4 0 00-8 0v2" />
        </svg>
        <h1 class="text-2xl font-bold text-gray-700">Panel de Administración</h1>
      </div>
      <span class="text-gray-500 font-semibold">👤 {{ user.nombre }}</span>
    </header>
    <main class="flex flex-1">
      <!-- Sidebar -->
      <aside class="w-64 bg-white/90 p-6 shadow-lg border-r flex flex-col">
        <div class="mb-10">
          <p class="text-lg font-semibold text-blue-800 mb-1">Bienvenido,</p>
          <p class="text-2xl font-bold text-blue-600">{{ user.nombre }}</p>
        </div>
        <nav class="flex flex-col gap-2">
          <button @click="router.visit(route('admin.productos.index'))"
            class="flex items-center gap-2 px-4 py-2 rounded transition hover:bg-blue-100 font-medium">
            <Package class="w-5 h-5 text-blue-600" /> Productos
          </button>
          <button @click="router.visit(route('categorias.index'))"
            class="flex items-center gap-2 px-4 py-2 rounded transition hover:bg-green-100 font-medium">
            <Tag class="w-5 h-5 text-green-600" /> Categorías
          </button>
          <button @click="router.visit(route('origenes.index'))"
            class="flex items-center gap-2 px-4 py-2 rounded transition hover:bg-yellow-100 font-medium">
            <Globe class="w-5 h-5 text-yellow-600" /> Orígenes
          </button>
          <button @click="router.visit(route('roles.index'))"
            class="flex items-center gap-2 px-4 py-2 rounded transition hover:bg-purple-100 font-medium">
            <Layers class="w-5 h-5 text-purple-600" /> Roles
          </button>
          <button @click="router.visit(route('usuarios.index'))"
            class="flex items-center gap-2 px-4 py-2 rounded transition hover:bg-pink-100 font-medium">
            <Users class="w-5 h-5 text-pink-600" /> Usuarios
          </button>
          <button @click="router.visit(route('operacion.index'))"
            class="flex items-center gap-2 px-4 py-2 rounded transition hover:bg-red-100 font-medium">
            <List class="w-5 h-5 text-red-600" /> Operaciones
          </button>
        </nav>
        <div class="flex-1" />
        <button @click="router.post(route('logout'))"
          class="flex items-center gap-2 px-4 py-2 rounded transition hover:bg-gray-200 text-red-600 font-semibold mt-6 border border-red-200">
          <LogOut class="w-5 h-5" /> Cerrar sesión
        </button>
      </aside>
      <!-- Main Content -->
      <section class="flex-1 p-8 flex flex-col justify-center items-center">
        <h2 class="text-2xl font-semibold mb-3 text-blue-800">
          👋 ¡Hola, {{ user.nombre }}!
        </h2>
        <p class="text-gray-600 mb-2">
          Selecciona una opción del menú lateral para gestionar los módulos del sistema.
        </p>
        <div class="w-32 h-1 bg-gradient-to-r from-blue-400 via-pink-300 to-purple-400 rounded-full opacity-40 my-2" />
        <!-- Aquí puedes renderizar contenido dinámico adicional -->
      </section>
    </main>
  </div>
</template>
