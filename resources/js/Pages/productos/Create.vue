<script setup>
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
import { route } from 'ziggy-js'
import { PackagePlus, ArrowLeft, Image as IconImage } from 'lucide-vue-next'

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

// Previsualización de imagen
const imagenPreview = ref(null)

const onFileChange = (e) => {
  const file = e.target.files[0]
  form.imagen_url = file
  if (file) {
    const reader = new FileReader()
    reader.onload = (ev) => {
      imagenPreview.value = ev.target.result
    }
    reader.readAsDataURL(file)
  } else {
    imagenPreview.value = null
  }
}

const submit = () => {
  form.post(route('admin.productos.store'), {
    forceFormData: true
  })
}

function goToIndex() {
  window.history.back()
}
</script>

<template>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-tr from-gray-100 to-blue-100 py-8 px-4">
    <div class="w-full max-w-2xl bg-white shadow-2xl rounded-2xl px-10 py-10">
      <div class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-3">
        <h1 class="text-3xl font-extrabold text-blue-800 flex items-center gap-2">
          <PackagePlus class="w-7 h-7 text-blue-500" /> Crear Nuevo Producto
        </h1>
        <button
          @click="goToIndex"
          type="button"
          class="flex items-center gap-1 bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-lg shadow border border-gray-300 transition font-semibold"
        >
          <ArrowLeft class="w-4 h-4" /> Volver
        </button>
      </div>
      <form @submit.prevent="submit" class="flex flex-col gap-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label for="codigo" class="font-semibold text-gray-700">Código</label>
            <input id="codigo" v-model="form.codigo" type="text"
              class="border-2 border-blue-100 focus:border-blue-500 rounded-xl p-3 w-full transition outline-none"
              :class="{ 'border-red-400': form.errors.codigo }"
              autocomplete="off" />
            <transition name="fade">
              <div v-if="form.errors.codigo" class="text-red-600 text-sm font-semibold animate-pulse mt-1">
                {{ form.errors.codigo }}
              </div>
            </transition>
          </div>
          <div>
            <label for="nombre" class="font-semibold text-gray-700">Nombre</label>
            <input id="nombre" v-model="form.nombre" type="text"
              class="border-2 border-blue-100 focus:border-blue-500 rounded-xl p-3 w-full transition outline-none"
              :class="{ 'border-red-400': form.errors.nombre }"
              autocomplete="off" />
            <transition name="fade">
              <div v-if="form.errors.nombre" class="text-red-600 text-sm font-semibold animate-pulse mt-1">
                {{ form.errors.nombre }}
              </div>
            </transition>
          </div>
          <div class="sm:col-span-2">
            <label for="descripcion" class="font-semibold text-gray-700">Descripción</label>
            <textarea id="descripcion" v-model="form.descripcion"
              class="border-2 border-blue-100 focus:border-blue-500 rounded-xl p-3 w-full transition outline-none"
              :class="{ 'border-red-400': form.errors.descripcion }" rows="2" />
            <transition name="fade">
              <div v-if="form.errors.descripcion" class="text-red-600 text-sm font-semibold animate-pulse mt-1">
                {{ form.errors.descripcion }}
              </div>
            </transition>
          </div>
          <div>
            <label for="diseño" class="font-semibold text-gray-700">Diseño</label>
            <input id="diseño" v-model="form.diseño" type="text"
              class="border-2 border-blue-100 focus:border-blue-500 rounded-xl p-3 w-full transition outline-none"
              :class="{ 'border-red-400': form.errors.diseño }" autocomplete="off" />
            <transition name="fade">
              <div v-if="form.errors.diseño" class="text-red-600 text-sm font-semibold animate-pulse mt-1">
                {{ form.errors.diseño }}
              </div>
            </transition>
          </div>
          <div>
            <label for="color" class="font-semibold text-gray-700">Color</label>
            <input id="color" v-model="form.color" type="text"
              class="border-2 border-blue-100 focus:border-blue-500 rounded-xl p-3 w-full transition outline-none"
              :class="{ 'border-red-400': form.errors.color }" autocomplete="off" />
            <transition name="fade">
              <div v-if="form.errors.color" class="text-red-600 text-sm font-semibold animate-pulse mt-1">
                {{ form.errors.color }}
              </div>
            </transition>
          </div>
          <div>
            <label for="dimensiones" class="font-semibold text-gray-700">Dimensiones</label>
            <input id="dimensiones" v-model="form.dimensiones" type="text"
              class="border-2 border-blue-100 focus:border-blue-500 rounded-xl p-3 w-full transition outline-none"
              :class="{ 'border-red-400': form.errors.dimensiones }" autocomplete="off" />
            <transition name="fade">
              <div v-if="form.errors.dimensiones" class="text-red-600 text-sm font-semibold animate-pulse mt-1">
                {{ form.errors.dimensiones }}
              </div>
            </transition>
          </div>
          <div>
            <label for="piezas_por_caja" class="font-semibold text-gray-700">Piezas por caja</label>
            <input id="piezas_por_caja" v-model="form.piezas_por_caja" type="number" min="1"
              class="border-2 border-blue-100 focus:border-blue-500 rounded-xl p-3 w-full transition outline-none"
              :class="{ 'border-red-400': form.errors.piezas_por_caja }" autocomplete="off" />
            <transition name="fade">
              <div v-if="form.errors.piezas_por_caja" class="text-red-600 text-sm font-semibold animate-pulse mt-1">
                {{ form.errors.piezas_por_caja }}
              </div>
            </transition>
          </div>
          <div>
            <label for="m2_por_caja" class="font-semibold text-gray-700">m² por caja</label>
            <input id="m2_por_caja" v-model="form.m2_por_caja" type="number" step="0.01" min="0"
              class="border-2 border-blue-100 focus:border-blue-500 rounded-xl p-3 w-full transition outline-none"
              :class="{ 'border-red-400': form.errors.m2_por_caja }" autocomplete="off" />
            <transition name="fade">
              <div v-if="form.errors.m2_por_caja" class="text-red-600 text-sm font-semibold animate-pulse mt-1">
                {{ form.errors.m2_por_caja }}
              </div>
            </transition>
          </div>
          <div>
            <label for="stock_actual" class="font-semibold text-gray-700">Stock actual</label>
            <input id="stock_actual" v-model="form.stock_actual" type="number" min="0"
              class="border-2 border-blue-100 focus:border-blue-500 rounded-xl p-3 w-full transition outline-none"
              :class="{ 'border-red-400': form.errors.stock_actual }" autocomplete="off" />
            <transition name="fade">
              <div v-if="form.errors.stock_actual" class="text-red-600 text-sm font-semibold animate-pulse mt-1">
                {{ form.errors.stock_actual }}
              </div>
            </transition>
          </div>
          <div>
            <label for="precio" class="font-semibold text-gray-700">Precio</label>
            <input id="precio" v-model="form.precio" type="number" step="0.01" min="0"
              class="border-2 border-blue-100 focus:border-blue-500 rounded-xl p-3 w-full transition outline-none"
              :class="{ 'border-red-400': form.errors.precio }" autocomplete="off" />
            <transition name="fade">
              <div v-if="form.errors.precio" class="text-red-600 text-sm font-semibold animate-pulse mt-1">
                {{ form.errors.precio }}
              </div>
            </transition>
          </div>
        </div>
        <div>
          <label for="imagen_url" class="font-semibold text-gray-700 flex items-center gap-1">
            <IconImage class="w-4 h-4 text-blue-400" /> Imagen del producto
          </label>
          <input id="imagen_url" type="file" accept="image/*" @change="onFileChange"
            class="border-2 border-blue-100 focus:border-blue-500 rounded-xl p-2 w-full transition outline-none" />
          <div v-if="imagenPreview" class="mt-3 flex items-center gap-4">
            <img :src="imagenPreview" alt="Vista previa" class="h-20 w-20 object-cover rounded-xl shadow" />
            <span class="text-gray-500 text-sm">Vista previa</span>
          </div>
          <transition name="fade">
            <div v-if="form.errors.imagen_url" class="text-red-600 text-sm font-semibold animate-pulse mt-1">
              {{ form.errors.imagen_url }}
            </div>
          </transition>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label for="categoria_id" class="font-semibold text-gray-700">Categoría</label>
            <select id="categoria_id" v-model="form.categoria_id"
              class="border-2 border-blue-100 focus:border-blue-500 rounded-xl p-3 w-full transition outline-none"
              :class="{ 'border-red-400': form.errors.categoria_id }">
              <option value="">Selecciona una categoría</option>
              <option v-for="cat in props.categorias" :key="cat.categoria_id" :value="cat.categoria_id">
                {{ cat.nombre }}
              </option>
            </select>
            <transition name="fade">
              <div v-if="form.errors.categoria_id" class="text-red-600 text-sm font-semibold animate-pulse mt-1">
                {{ form.errors.categoria_id }}
              </div>
            </transition>
          </div>
          <div>
            <label for="origen_id" class="font-semibold text-gray-700">Origen</label>
            <select id="origen_id" v-model="form.origen_id"
              class="border-2 border-blue-100 focus:border-blue-500 rounded-xl p-3 w-full transition outline-none"
              :class="{ 'border-red-400': form.errors.origen_id }">
              <option value="">Selecciona un origen</option>
              <option v-for="ori in props.origenes" :key="ori.origen_id" :value="ori.origen_id">
                {{ ori.pais }}
              </option>
            </select>
            <transition name="fade">
              <div v-if="form.errors.origen_id" class="text-red-600 text-sm font-semibold animate-pulse mt-1">
                {{ form.errors.origen_id }}
              </div>
            </transition>
          </div>
        </div>
        <button
          type="submit"
          :disabled="form.processing"
          class="mt-6 bg-blue-600 hover:bg-blue-700 transition text-white font-bold px-6 py-3 rounded-xl shadow-lg flex items-center justify-center gap-2 disabled:opacity-60"
        >
          <PackagePlus class="w-5 h-5" /> Guardar Producto
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
