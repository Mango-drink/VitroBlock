<script setup>
import { useForm } from '@inertiajs/vue3'
import { UserPlus, ArrowLeft } from 'lucide-vue-next'
import { Link } from '@inertiajs/vue3' // Asegúrate de importar esto

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: ''
})

function submit() {
  form.post(route('register'))
}
</script>

<template>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-tr from-gray-100 to-blue-100 py-8 px-4">
    <div class="w-full max-w-md bg-white shadow-xl rounded-2xl px-8 py-10">
      
      <!-- Botón de regreso al inicio -->
      <div class="flex justify-start mb-6">
        <Link
          href="/"
          class="flex items-center gap-1 bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-lg shadow border border-gray-300 transition font-semibold"
        >
          <ArrowLeft class="w-4 h-4" /> Inicio
        </Link>
      </div>
      
      <div class="flex flex-col items-center mb-8">
        <UserPlus class="w-12 h-12 text-blue-500 mb-2" />
        <h1 class="text-2xl font-extrabold text-blue-800 mb-1">Crear Cuenta</h1>
        <p class="text-gray-600 text-sm">Regístrate para acceder al sistema</p>
      </div>
      <form @submit.prevent="submit" class="flex flex-col gap-4">
        <div>
          <label for="name" class="font-semibold text-gray-700">Nombre</label>
          <input
            v-model="form.name"
            name="name"
            id="name"
            required
            autofocus
            autocomplete="off"
            placeholder="Tu nombre"
            class="border-2 border-blue-200 focus:border-blue-500 rounded-xl p-3 w-full text-gray-700 transition placeholder-gray-400 shadow-sm outline-none"
            :class="{ 'border-red-400': form.errors.name }"
          />
          <transition name="fade">
            <div v-if="form.errors.name" class="text-red-600 text-sm pl-1 font-semibold animate-pulse mt-1">
              {{ form.errors.name }}
            </div>
          </transition>
        </div>
        <div>
          <label for="email" class="font-semibold text-gray-700">Correo electrónico</label>
          <input
            v-model="form.email"
            name="email"
            id="email"
            type="email"
            required
            autocomplete="off"
            placeholder="ejemplo@correo.com"
            class="border-2 border-blue-200 focus:border-blue-500 rounded-xl p-3 w-full text-gray-700 transition placeholder-gray-400 shadow-sm outline-none"
            :class="{ 'border-red-400': form.errors.email }"
          />
          <transition name="fade">
            <div v-if="form.errors.email" class="text-red-600 text-sm pl-1 font-semibold animate-pulse mt-1">
              {{ form.errors.email }}
            </div>
          </transition>
        </div>
        <div>
          <label for="password" class="font-semibold text-gray-700">Contraseña</label>
          <input
            v-model="form.password"
            name="password"
            id="password"
            type="password"
            required
            placeholder="Contraseña"
            class="border-2 border-blue-200 focus:border-blue-500 rounded-xl p-3 w-full text-gray-700 transition placeholder-gray-400 shadow-sm outline-none"
            :class="{ 'border-red-400': form.errors.password }"
            autocomplete="new-password"
          />
          <transition name="fade">
            <div v-if="form.errors.password" class="text-red-600 text-sm pl-1 font-semibold animate-pulse mt-1">
              {{ form.errors.password }}
            </div>
          </transition>
        </div>
        <div>
          <label for="password_confirmation" class="font-semibold text-gray-700">Confirma Contraseña</label>
          <input
            v-model="form.password_confirmation"
            name="password_confirmation"
            id="password_confirmation"
            type="password"
            required
            placeholder="Repite la contraseña"
            class="border-2 border-blue-200 focus:border-blue-500 rounded-xl p-3 w-full text-gray-700 transition placeholder-gray-400 shadow-sm outline-none"
            :class="{ 'border-red-400': form.errors.password_confirmation }"
            autocomplete="new-password"
          />
          <transition name="fade">
            <div v-if="form.errors.password_confirmation" class="text-red-600 text-sm pl-1 font-semibold animate-pulse mt-1">
              {{ form.errors.password_confirmation }}
            </div>
          </transition>
        </div>
        <button
          type="submit"
          :disabled="form.processing"
          class="mt-2 bg-blue-600 hover:bg-blue-700 transition text-white font-bold px-6 py-3 rounded-xl shadow-lg flex items-center justify-center gap-2 disabled:opacity-60"
        >
          <UserPlus class="w-5 h-5" /> Registrarse
        </button>
      </form>
    </div>
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
