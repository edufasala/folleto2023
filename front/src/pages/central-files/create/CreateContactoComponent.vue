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
        @newPerson="newPerson"
      />
      <SucursalComponent
        class="q-pt-md"
        :empresa="empresa"
        :sucursals="sucursals"
        />
    </div>
    <div class="col-12 col-md-4 q-px-xs">
      <DireccionComponent
        :empresa="empresa"
        :direccion="direccion"
        :phoneDireccions="phoneDireccions"
        :facturacion="facturacion"
        :sucursals="sucursals"
        />
      <FacturacionComponent
        :empresa="empresa"
        :direccion="direccion"
        :phoneDireccions="phoneDireccions"
        :facturacion="facturacion"
        :sucursals="sucursals"
        />
    </div>
  </div>
</template>
<script>
import PersonComponent from './CreatePersonComponent.vue'
import SucursalComponent from './CreateSucursalComponent.vue'
import DireccionComponent from './CreateDireccionComponent.vue'
import FacturacionComponent from './CreateFacturacionComponent.vue'
export default {
  name: 'CreateContactoComponent',
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
    newPerson (person) {
      this.$emit('newPerson', person)
    },
    empresaSearch (empresa) {
      this.$emit('empresaSearch', empresa)
    }
  }
}
</script>
