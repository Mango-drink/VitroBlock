<script setup>
import { usePage } from '@inertiajs/vue3'
import { watchEffect } from 'vue'


const page = usePage()
</script>

<template>
  <div>
    <div v-if="page.props.flash && page.props.flash.success" class="bg-green-200 text-green-900 p-2 rounded mb-4">
      {{ page.props.flash.success }}
    </div>
    <!-- Aquí tu tabla/lista de origenes -->
  </div>
</template>
