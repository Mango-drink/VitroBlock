<script setup>
import { useForm } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import { router } from '@inertiajs/vue3'

const props = defineProps({
  producto: Object,
  categorias: Array,
  origenes: Array
})

const form = useForm({
  codigo: props.producto.codigo,
  nombre: props.producto.nombre,
  descripcion: props.producto.descripcion,
  diseño: props.producto.diseño,
  color: props.producto.color,
  dimensiones: props.producto.dimensiones,
  piezas_por_caja: props.producto.piezas_por_caja,
  m2_por_caja: props.producto.m2_por_caja,
  stock_actual: props.producto.stock_actual,
  precio: props.producto.precio,
  imagen_url: props.producto.imagen_url,
  categoria_id: props.producto.categoria_id,
  origen_id: props.producto.origen_id
})

const submit = () => {
  form.put(route('admin.productos.update', { producto: props.producto.producto_id }))
}

function goToIndex() {
  router.visit(route('admin.productos.index'))
}
</script>

<template>
  <div class="min-h-screen bg-gradient-to-tr from-gray-50 to-blue-50 py-10 px-4">
    <div class="max-w-2xl mx-auto bg-white shadow-lg rounded-xl p-8">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-blue-800">Editar Producto</h1>
        <button
          @click="goToIndex"
          type="button"
          class="bg-gray-100 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded shadow border border-gray-300 ml-4 transition font-semibold"
        >
          ← Regresar
        </button>
      </div>
      <form @submit.prevent="submit" class="space-y-5">
        <div>
          <label for="codigo" class="block mb-1 font-semibold">Código:</label>
          <input id="codigo" v-model="form.codigo" type="text" class="border rounded p-2 w-full" />
          <div v-if="form.errors.codigo" class="text-red-500 mt-1">{{ form.errors.codigo }}</div>
        </div>
        <div>
          <label for="nombre" class="block mb-1 font-semibold">Nombre:</label>
          <input id="nombre" v-model="form.nombre" type="text" class="border rounded p-2 w-full" />
          <div v-if="form.errors.nombre" class="text-red-500 mt-1">{{ form.errors.nombre }}</div>
        </div>
        <div>
          <label for="descripcion" class="block mb-1 font-semibold">Descripción:</label>
          <textarea id="descripcion" v-model="form.descripcion" class="border rounded p-2 w-full"></textarea>
          <div v-if="form.errors.descripcion" class="text-red-500 mt-1">{{ form.errors.descripcion }}</div>
        </div>
        <div>
          <label for="diseño" class="block mb-1 font-semibold">Diseño:</label>
          <input id="diseño" v-model="form.diseño" type="text" class="border rounded p-2 w-full" />
          <div v-if="form.errors.diseño" class="text-red-500 mt-1">{{ form.errors.diseño }}</div>
        </div>
        <div>
          <label for="color" class="block mb-1 font-semibold">Color:</label>
          <input id="color" v-model="form.color" type="text" class="border rounded p-2 w-full" />
          <div v-if="form.errors.color" class="text-red-500 mt-1">{{ form.errors.color }}</div>
        </div>
        <div>
          <label for="dimensiones" class="block mb-1 font-semibold">Dimensiones:</label>
          <input id="dimensiones" v-model="form.dimensiones" type="text" class="border rounded p-2 w-full" />
          <div v-if="form.errors.dimensiones" class="text-red-500 mt-1">{{ form.errors.dimensiones }}</div>
        </div>
        <div>
          <label for="piezas_por_caja" class="block mb-1 font-semibold">Piezas por caja:</label>
          <input id="piezas_por_caja" v-model="form.piezas_por_caja" type="number" class="border rounded p-2 w-full" />
          <div v-if="form.errors.piezas_por_caja" class="text-red-500 mt-1">{{ form.errors.piezas_por_caja }}</div>
        </div>
        <div>
          <label for="m2_por_caja" class="block mb-1 font-semibold">m² por caja:</label>
          <input id="m2_por_caja" v-model="form.m2_por_caja" type="number" step="0.01" class="border rounded p-2 w-full" />
          <div v-if="form.errors.m2_por_caja" class="text-red-500 mt-1">{{ form.errors.m2_por_caja }}</div>
        </div>
        <div>
          <label for="stock_actual" class="block mb-1 font-semibold">Stock actual:</label>
          <input id="stock_actual" v-model="form.stock_actual" type="number" class="border rounded p-2 w-full" />
          <div v-if="form.errors.stock_actual" class="text-red-500 mt-1">{{ form.errors.stock_actual }}</div>
        </div>
        <div>
          <label for="precio" class="block mb-1 font-semibold">Precio:</label>
          <input id="precio" v-model="form.precio" type="number" step="0.01" class="border rounded p-2 w-full" />
          <div v-if="form.errors.precio" class="text-red-500 mt-1">{{ form.errors.precio }}</div>
        </div>
        <div>
          <label for="imagen_url" class="block mb-1 font-semibold">Imagen (URL):</label>
          <input id="imagen_url" v-model="form.imagen_url" type="text" class="border rounded p-2 w-full" />
          <div v-if="form.errors.imagen_url" class="text-red-500 mt-1">{{ form.errors.imagen_url }}</div>
        </div>
        <div>
          <label for="categoria_id" class="block mb-1 font-semibold">Categoría:</label>
          <select id="categoria_id" v-model="form.categoria_id" class="border rounded p-2 w-full">
            <option value="">Selecciona una categoría</option>
            <option v-for="cat in props.categorias" :key="cat.categoria_id" :value="cat.categoria_id">{{ cat.nombre }}</option>
          </select>
          <div v-if="form.errors.categoria_id" class="text-red-500 mt-1">{{ form.errors.categoria_id }}</div>
        </div>
        <div>
          <label for="origen_id" class="block mb-1 font-semibold">Origen:</label>
          <select id="origen_id" v-model="form.origen_id" class="border rounded p-2 w-full">
            <option value="">Selecciona un origen</option>
            <option v-for="ori in props.origenes" :key="ori.origen_id" :value="ori.origen_id">{{ ori.pais }}</option>
          </select>
          <div v-if="form.errors.origen_id" class="text-red-500 mt-1">{{ form.errors.origen_id }}</div>
        </div>
        <button
          type="submit"
          :disabled="form.processing"
          class="bg-blue-600 text-white px-4 py-2 rounded mt-4 hover:bg-blue-700 transition font-semibold shadow"
        >
          Guardar Cambios
        </button>
      </form>
    </div>
  </div>
</template>
