<template>
  <q-item
    clickable
    :to="to"
    :class="`color-menu left-${color}`"
  >
    <q-item-section
      v-if="icon"
      avatar
    >
      <q-icon :name="icon" />
    </q-item-section>

    <q-item-section>
      <q-item-label class="text-uppercase text-bold">{{ title }}</q-item-label>
      <q-item-label caption class="color-menu">{{ caption }}</q-item-label>
    </q-item-section>
  </q-item>
</template>

<script>
import { defineComponent } from 'vue'

export default defineComponent({
  name: 'EssentialLink',
  props: {
    title: {
      type: String,
      required: true
    },

    caption: {
      type: String,
      default: ''
    },

    link: {
      type: String,
      default: '#'
    },

    icon: {
      type: String,
      default: ''
    },
    to: {
      type: String,
      default: ''
    },
    color: {
      type: String,
      default: 'primary'
    }
  }
})
</script>
