<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
  operacion: Object,
  productos: Array,
  usuarios: Array,
})

const form = useForm({
  tipo: props.operacion.tipo,
  cantidad: props.operacion.cantidad,
  fecha_hora: props.operacion.fecha_hora,
  producto_id: props.operacion.producto_id,
  usuario_id: props.operacion.usuario_id,
})

function submit() {
  form.put(route('operacion.update', props.operacion.operacion_id))
}
</script>

<template>
  <div>
    <h1 class="text-2xl font-bold mb-4">Editar Operación</h1>
    <form @submit.prevent="submit" class="space-y-4">
      <div>
        <label>Tipo de operación</label>
        <select v-model="form.tipo" required class="border rounded p-2 w-full">
          <option value="">Seleccione</option>
          <option value="alta">Alta</option>
          <option value="baja">Baja</option>
          <option value="modificación">Modificación</option>
        </select>
        <div v-if="form.errors.tipo" class="text-red-500">{{ form.errors.tipo }}</div>
      </div>
      <div>
        <label>Cantidad</label>
        <input v-model="form.cantidad" type="number" min="1" class="border rounded p-2 w-full" required />
        <div v-if="form.errors.cantidad" class="text-red-500">{{ form.errors.cantidad }}</div>
      </div>
      <div>
        <label>Fecha y hora</label>
        <input v-model="form.fecha_hora" type="datetime-local" class="border rounded p-2 w-full" required />
        <div v-if="form.errors.fecha_hora" class="text-red-500">{{ form.errors.fecha_hora }}</div>
      </div>
      <div>
        <label>Producto</label>
        <select v-model="form.producto_id" required class="border rounded p-2 w-full">
          <option value="">Seleccione</option>
          <option v-for="prod in productos" :key="prod.producto_id" :value="prod.producto_id">{{ prod.nombre }}</option>
        </select>
        <div v-if="form.errors.producto_id" class="text-red-500">{{ form.errors.producto_id }}</div>
      </div>
      <div>
        <label>Usuario</label>
        <select v-model="form.usuario_id" required class="border rounded p-2 w-full">
          <option value="">Seleccione</option>
          <option v-for="user in usuarios" :key="user.usuario_id" :value="user.usuario_id">{{ user.nombre }}</option>
        </select>
        <div v-if="form.errors.usuario_id" class="text-red-500">{{ form.errors.usuario_id }}</div>
      </div>
      <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded" :disabled="form.processing">
        Guardar Cambios
      </button>
    </form>
  </div>
</template>
