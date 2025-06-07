<script setup>
import { useForm } from '@inertiajs/vue3'
import { watchEffect } from 'vue'

import { route } from 'ziggy-js'

// Esperamos recibir las listas de categorías y orígenes como props
const props = defineProps({
  categorias: Array,
  origenes: Array
})

const form = useForm({
  codigo: '',
  nombre: '',
  descripcion: '',
  diseño: '',
  color: '',
  dimensiones: '',
  piezas_por_caja: '',
  m2_por_caja: '',
  stock_actual: '',
  precio: '',
  imagen_url: null,
  categoria_id: '',
  origen_id: ''
})

const onFileChange = (e) => {
  form.imagen_url = e.target.files[0];
}

const submit = () => {
  form.post(route('productos.store'), {
    forceFormData: true
  })
}
</script>

<template>
  <div>
    <h1>Crear Nuevo Producto</h1>
    <form @submit.prevent="submit" class="space-y-4">
      <div>
        <label for="codigo">Código:</label>
        <input id="codigo" v-model="form.codigo" type="text" class="border rounded p-2 w-full" />
        <div v-if="form.errors.codigo" class="text-red-500">{{ form.errors.codigo }}</div>
      </div>
      <div>
        <label for="nombre">Nombre:</label>
        <input id="nombre" v-model="form.nombre" type="text" class="border rounded p-2 w-full" />
        <div v-if="form.errors.nombre" class="text-red-500">{{ form.errors.nombre }}</div>
      </div>
      <div>
        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" v-model="form.descripcion" class="border rounded p-2 w-full"></textarea>
        <div v-if="form.errors.descripcion" class="text-red-500">{{ form.errors.descripcion }}</div>
      </div>
      <div>
        <label for="diseño">Diseño:</label>
        <input id="diseño" v-model="form.diseño" type="text" class="border rounded p-2 w-full" />
        <div v-if="form.errors.diseño" class="text-red-500">{{ form.errors.diseño }}</div>
      </div>
      <div>
        <label for="color">Color:</label>
        <input id="color" v-model="form.color" type="text" class="border rounded p-2 w-full" />
        <div v-if="form.errors.color" class="text-red-500">{{ form.errors.color }}</div>
      </div>
      <div>
        <label for="dimensiones">Dimensiones:</label>
        <input id="dimensiones" v-model="form.dimensiones" type="text" class="border rounded p-2 w-full" />
        <div v-if="form.errors.dimensiones" class="text-red-500">{{ form.errors.dimensiones }}</div>
      </div>
      <div>
        <label for="piezas_por_caja">Piezas por caja:</label>
        <input id="piezas_por_caja" v-model="form.piezas_por_caja" type="number" class="border rounded p-2 w-full" />
        <div v-if="form.errors.piezas_por_caja" class="text-red-500">{{ form.errors.piezas_por_caja }}</div>
      </div>
      <div>
        <label for="m2_por_caja">m² por caja:</label>
        <input id="m2_por_caja" v-model="form.m2_por_caja" type="number" step="0.01" class="border rounded p-2 w-full" />
        <div v-if="form.errors.m2_por_caja" class="text-red-500">{{ form.errors.m2_por_caja }}</div>
      </div>
      <div>
        <label for="stock_actual">Stock actual:</label>
        <input id="stock_actual" v-model="form.stock_actual" type="number" class="border rounded p-2 w-full" />
        <div v-if="form.errors.stock_actual" class="text-red-500">{{ form.errors.stock_actual }}</div>
      </div>
      <div>
        <label for="precio">Precio:</label>
        <input id="precio" v-model="form.precio" type="number" step="0.01" class="border rounded p-2 w-full" />
        <div v-if="form.errors.precio" class="text-red-500">{{ form.errors.precio }}</div>
      </div>
      <div>
        <label for="imagen_url">Imagen (URL):</label>
        <input id="imagen_url" type="file" @change="onFileChange" class="border rounded p-2 w-full" />
        <div v-if="form.errors.imagen_url" class="text-red-500">{{ form.errors.imagen_url }}</div>
      </div>
      <div>
        <label for="categoria_id">Categoría:</label>
        <select id="categoria_id" v-model="form.categoria_id" class="border rounded p-2 w-full">
          <option value="">Selecciona una categoría</option>
          <option v-for="cat in props.categorias" :key="cat.categoria_id" :value="cat.categoria_id">{{ cat.nombre }}</option>
        </select>
        <div v-if="form.errors.categoria_id" class="text-red-500">{{ form.errors.categoria_id }}</div>
      </div>
      <div>
        <label for="origen_id">Origen:</label>
        <select id="origen_id" v-model="form.origen_id" class="border rounded p-2 w-full">
          <option value="">Selecciona un origen</option>
          <option v-for="ori in props.origenes" :key="ori.origen_id" :value="ori.origen_id">{{ ori.pais }}</option>
        </select>
        <div v-if="form.errors.origen_id" class="text-red-500">{{ form.errors.origen_id }}</div>
      </div>
      <div>
        <button
          type="submit"
          :disabled="form.processing"
          class="bg-blue-500 text-white px-4 py-2 rounded"
        >
          Guardar Producto
        </button>
      </div>
    </form>
  </div>
</template>
