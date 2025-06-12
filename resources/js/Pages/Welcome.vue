<script setup>
import { Head } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import { LogIn, UserPlus, Layers } from 'lucide-vue-next'

function goLogin() {
  router.visit(route('login'))
}
function goRegister() {
  router.visit(route('register'))
}
</script>

<template>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-tr from-gray-100 to-blue-100 py-8 px-4">
    <Head title="VitroBlocks" />
    <div class="w-full max-w-lg bg-white shadow-2xl rounded-2xl px-10 py-14 flex flex-col items-center gap-6">
      <Layers class="w-14 h-14 text-blue-500 mb-2 drop-shadow-lg" />
      <h1 class="text-4xl font-extrabold text-blue-800 mb-2 text-center tracking-tight">Bienvenido a <span class="text-blue-500">VitroBlocks</span></h1>
      <p class="text-lg text-gray-600 text-center">
        Tu plataforma moderna para la gestión integral de productos, reportes y usuarios.<br>
        Simplifica procesos, administra tu inventario y haz crecer tu negocio.
      </p>
      <div class="flex flex-col sm:flex-row gap-4 mt-6 w-full justify-center">
        <button
          @click="goLogin"
          class="flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl shadow-lg font-bold transition text-lg w-full sm:w-auto"
        >
          <LogIn class="w-5 h-5" /> Iniciar Sesión
        </button>
        <button
          @click="goRegister"
          class="flex items-center justify-center gap-2 bg-gray-100 hover:bg-blue-100 text-blue-700 px-6 py-3 rounded-xl shadow font-bold border border-blue-200 transition text-lg w-full sm:w-auto"
        >
          <UserPlus class="w-5 h-5" /> Registrarse
        </button>
      </div>
    </div>
  </div>
</template>
