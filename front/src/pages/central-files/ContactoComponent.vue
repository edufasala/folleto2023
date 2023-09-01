<template>
  <div class="row">
    <div class="col-12 col-md-8 q-px-xs">
      <PersonComponent
        :persons="persons"
        :empresa="empresa"
        :direccion="direccion"
        :phoneDireccions="phoneDireccions"
        :facturacion="facturacion"
        :sucursals="sucursals"
        @empresaSearch="empresaSearch"/>
      <SucursalComponent
        :empresa="empresa"
        :sucursals="sucursals"
        @empresaSearch="empresaSearch"/>
    </div>
    <div class="col-12 col-md-4 q-px-xs">
      <DireccionComponent
        :empresa="empresa"
        :direccion="direccion"
        :phoneDireccions="phoneDireccions"
        :facturacion="facturacion"
        :sucursals="sucursals"
        @empresaSearch="empresaSearch"/>
      <FacturacionComponent
        :empresa="empresa"
        :direccion="direccion"
        :phoneDireccions="phoneDireccions"
        :facturacion="facturacion"
        :sucursals="sucursals"
        @empresaSearch="empresaSearch"/>
    </div>
  </div>
</template>
<script>
import PersonComponent from './PersonComponent.vue'
import SucursalComponent from './SucursalComponent.vue'
import DireccionComponent from './DireccionComponent.vue'
import FacturacionComponent from './FacturacionComponent.vue'
export default {
  name: 'ContactoComponent',
  components: {
    SucursalComponent,
    PersonComponent,
    DireccionComponent,
    FacturacionComponent
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
      console.log(empresa)
      this.$emit('empresaSearch', empresa)
    }
  }
}
</script>
