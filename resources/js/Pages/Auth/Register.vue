<script setup>
import { ref } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import { useToast } from 'vue-toastification'

const form = ref({ 
  name:'',          // ← Importante: debe llamarse 'nombre'
  email: '',
  password: '',
  password_confirmation: '',
  terms: true 
})

const errors = usePage().props.errors || {}
const toast = useToast()

function submit() {
  console.log(form.value)
  router.post(route('register'), form.value, {
    onSuccess: () => {
      toast.success('Registro exitoso');
      router.visit('/dashboard');
    },
    onError: () => toast.error('Verifica los datos del formulario')
  })
}


</script>

<template>

  <div>
    <h1>Crear cuenta</h1>
    <pre>{{ errors }}</pre>
    <form @submit.prevent="submit">
      <div>
        <label for="name">Nombre</label>
        <input v-model="form.name" name="name" required autofocus />
        <div v-if="errors.name" style="color: red;">{{ errors.name }}</div>
      </div>

      <div>
        <label for="email">Correo electrónico</label>
        <input v-model="form.email" name="email" type="email" required />
        <div v-if="errors.email" style="color: red;">{{ errors.email }}</div>
      </div>

      <div>
        <label for="password">Contraseña</label>
        <input v-model="form.password" name="password" type="password" required />
        <div v-if="errors.password" style="color: red;">{{ errors.password }}</div>
      </div>

      <div>
        <label for="password_confirmation">Confirma Contraseña</label>
        <input v-model="form.password_confirmation" name="password_confirmation" type="password" required />
      </div>
      <input type="hidden" name="terms" v-model="form.terms" />


      <button type="submit">Registrarse</button>
    </form>
  </div>
</template>
