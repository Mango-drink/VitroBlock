<script setup>
import { ref, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import { LogOut, Package, Search } from 'lucide-vue-next'

const props = defineProps(['productos'])

// Filtros reactivos
const search = ref('')
const categoria = ref('')
const origen = ref('')
const precioMin = ref('')
const precioMax = ref('')

// Obtén todas las categorías y orígenes únicos (para los select)
const categoriasDisponibles = computed(() =>
  [...new Set(props.productos.map(p => p.categoria?.nombre).filter(Boolean))]
)
const origenesDisponibles = computed(() =>
  [...new Set(props.productos.map(p => p.origen?.pais).filter(Boolean))]
)

// Filtro frontend avanzado
const productosFiltrados = computed(() => {
  return props.productos.filter(prod => {
    // Filtro búsqueda (nombre)
    const matchNombre = !search.value || (prod.nombre && prod.nombre.toLowerCase().includes(search.value.toLowerCase()))
    // Filtro categoría
    const matchCategoria = !categoria.value || prod.categoria?.nombre === categoria.value
    // Filtro origen
    const matchOrigen = !origen.value || prod.origen?.pais === origen.value
    // Filtro precio
    const precio = Number(prod.precio)
    const matchPrecioMin = !precioMin.value || precio >= Number(precioMin.value)
    const matchPrecioMax = !precioMax.value || precio <= Number(precioMax.value)
    return matchNombre && matchCategoria && matchOrigen && matchPrecioMin && matchPrecioMax
  })
})

function logout() {
  router.post(route('logout'))
}
</script>

<template>
  <div class="min-h-screen bg-gradient-to-tr from-blue-50 via-white to-blue-100 py-12 px-4">
    <!-- Logout y título -->
    <div class="max-w-6xl mx-auto flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
      <h1 class="text-4xl font-extrabold text-blue-800 tracking-tight flex items-center gap-2">
        <Package class="w-8 h-8 text-blue-500 drop-shadow" /> Catálogo de Productos
      </h1>
      <button
        @click="logout"
        class="mt-4 sm:mt-0 px-4 py-2 flex items-center gap-2 bg-red-50 hover:bg-red-200 text-red-700 font-bold rounded-xl shadow border border-red-200 transition"
      >
        <LogOut class="w-5 h-5" /> Cerrar sesión
      </button>
    </div>

    <!-- Filtros avanzados -->
    <div class="max-w-6xl mx-auto bg-white shadow-lg rounded-2xl px-8 py-6 mb-10 flex flex-col md:flex-row md:items-end gap-6 border border-blue-100">
      <div class="flex-1">
        <label class="font-semibold text-gray-700 mb-1 block">Buscar por nombre</label>
        <div class="flex items-center gap-2">
          <input
            v-model="search"
            type="text"
            placeholder="Ej. Porcelanato, Block..."
            class="border-2 border-blue-100 rounded-xl p-3 w-full text-gray-700 placeholder-gray-400 shadow-sm outline-none focus:border-blue-400 transition"
          />
          <Search class="w-5 h-5 text-blue-400" />
        </div>
      </div>
      <div>
        <label class="font-semibold text-gray-700 mb-1 block">Categoría</label>
        <select v-model="categoria" class="border-2 border-blue-100 rounded-xl p-3 w-full min-w-[140px]">
          <option value="">Todas</option>
          <option v-for="cat in categoriasDisponibles" :key="cat" :value="cat">{{ cat }}</option>
        </select>
      </div>
      <div>
        <label class="font-semibold text-gray-700 mb-1 block">Origen</label>
        <select v-model="origen" class="border-2 border-blue-100 rounded-xl p-3 w-full min-w-[140px]">
          <option value="">Todos</option>
          <option v-for="org in origenesDisponibles" :key="org" :value="org">{{ org }}</option>
        </select>
      </div>
      <div class="flex gap-2 items-center">
        <div>
          <label class="font-semibold text-gray-700 mb-1 block">Precio min</label>
          <input
            v-model="precioMin"
            type="number"
            min="0"
            placeholder="$ Min"
            class="border-2 border-blue-100 rounded-xl p-3 w-24 text-gray-700 placeholder-gray-400 shadow-sm outline-none focus:border-blue-400 transition"
          />
        </div>
        <div>
          <label class="font-semibold text-gray-700 mb-1 block">Precio máx</label>
          <input
            v-model="precioMax"
            type="number"
            min="0"
            placeholder="$ Max"
            class="border-2 border-blue-100 rounded-xl p-3 w-24 text-gray-700 placeholder-gray-400 shadow-sm outline-none focus:border-blue-400 transition"
          />
        </div>
      </div>
      <button
        v-if="search || categoria || origen || precioMin || precioMax"
        @click="search='',categoria='',origen='',precioMin='',precioMax=''"
        class="ml-2 px-4 py-2 bg-gray-200 rounded-xl text-gray-700 font-semibold shadow border border-gray-300 hover:bg-gray-300 transition"
      >
        Limpiar
      </button>
    </div>
    <!-- Fin filtros -->

    <!-- Grid de productos -->
    <div v-if="productosFiltrados.length" class="max-w-6xl mx-auto grid gap-8 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
      <div
        v-for="producto in productosFiltrados"
        :key="producto.producto_id"
        class="group bg-white rounded-2xl shadow-lg border border-blue-100 flex flex-col items-center p-6 hover:scale-[1.03] hover:shadow-2xl transition cursor-pointer"
      >
        <div class="w-32 h-32 bg-gray-100 rounded-xl overflow-hidden flex items-center justify-center mb-4">
          <img
            v-if="producto.imagen_url"
            :src="`/storage/${producto.imagen_url}`"
            class="object-cover w-full h-full group-hover:scale-105 transition"
            alt="Imagen del producto"
          />
          <span v-else class="text-gray-400 text-xs text-center">Sin imagen</span>
        </div>
        <div class="w-full text-center">
          <h2 class="text-xl font-bold text-blue-700 mb-1 truncate">{{ producto.nombre }}</h2>
          <span class="inline-block bg-blue-100 text-blue-800 font-semibold px-3 py-1 rounded-full text-lg mb-2 shadow">
            ${{ Number(producto.precio).toFixed(2) }}
          </span>
          <div class="flex justify-center gap-2 mb-2">
            <span v-if="producto.categoria" class="bg-pink-100 text-pink-700 px-2 py-0.5 rounded-lg text-xs font-semibold">
              {{ producto.categoria.nombre }}
            </span>
            <span v-if="producto.origen" class="bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-lg text-xs font-semibold">
              {{ producto.origen.pais }}
            </span>
          </div>
        </div>
        <span class="text-xs text-gray-400 mt-auto">ID: {{ producto.producto_id }}</span>
      </div>
    </div>
    <div v-else class="max-w-lg mx-auto mt-20 flex flex-col items-center gap-2">
      <Package class="w-20 h-20 text-blue-200" />
      <span class="text-lg text-gray-400 text-center font-semibold">No hay productos que coincidan con tu búsqueda.</span>
    </div>
  </div>
</template>
