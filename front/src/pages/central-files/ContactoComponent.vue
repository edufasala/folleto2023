<template>
  <div class="row">
    <div class="col-12 col-md-7">
      <PersonComponent
        :persons="persons"
        :empresa="empresa"
        :direccion="direccion"
        :phoneDireccions="phoneDireccions"
        :facturacion="facturacion"
        :sucursals="sucursals"
        @empresaSearch="empresaSearch"></PersonComponent>
    </div>
    <div class="col-12 col-md-5">
    </div>
  </div>
</template>
<script>
import PersonComponent from './PersonComponent.vue'
export default {
  name: 'ContactoComponent',
  components: {
    PersonComponent
  },
  props: {
    empresa: {
      type: Object,
      default: () => {}
    },
    direccion: {
      type: Array,
      default: () => []
    },
    phoneDireccions: {
      type: Array,
      default: () => []
    },
    facturacion: {
      type: Array,
      default: () => []
    },
    sucursals: {
      type: Array,
      default: () => []
    },
    persons: {
      type: Array,
      default: () => []
    }
  },
  data () {
    return {
      loading: false,
      personDialog: false,
      personOption: '',
      person: {
        nombre: '',
        cargo: '',
        dni: ''
      }
    }
  },
  methods: {
    empresaSearch (empresa) {
      this.$emit('empresaSearch', empresa)
    }
  }
}
</script>
