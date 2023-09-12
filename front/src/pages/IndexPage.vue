<template>
  <q-page class="flex flex-center">
    <pre>{{$store.permisos}}</pre>
    <img
      alt="Quasar logo"
      src="logo1.png"
      style="width: 200px; height: 200px"
    >
  </q-page>
</template>

<script>
import { defineComponent } from 'vue'

export default defineComponent({
  name: 'IndexPage'
})
</script>
