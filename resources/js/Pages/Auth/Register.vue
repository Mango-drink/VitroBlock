<script setup>
import { useForm } from '@inertiajs/vue3'

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
  <div>
    <h1>Crear cuenta</h1>
    <form @submit.prevent="submit">
      <div>
        <label for="name">Nombre</label>
        <input v-model="form.name" name="name" required autofocus />
        <div v-if="form.errors.name" style="color: red;">{{ form.errors.name }}</div>
      </div>

      <div>
        <label for="email">Correo electrónico</label>
        <input v-model="form.email" name="email" type="email" required />
        <div v-if="form.errors.email" style="color: red;">{{ form.errors.email }}</div>
      </div>

      <div>
        <label for="password">Contraseña</label>
        <input v-model="form.password" name="password" type="password" required />
        <div v-if="form.errors.password" style="color: red;">{{ form.errors.password }}</div>
      </div>

      <div>
        <label for="password_confirmation">Confirma Contraseña</label>
        <input v-model="form.password_confirmation" name="password_confirmation" type="password" required />
        <div v-if="form.errors.password_confirmation" style="color: red;">{{ form.errors.password_confirmation }}</div>
      </div>

      <button type="submit" :disabled="form.processing">Registrarse</button>
    </form>
  </div>
</template>
