<template>
<q-page class="q-pa-xs bg-grey-3">
  <div class="row">
    <div class="col-12 text-uppercase luckiest text-h2 text-center">
      TESORERIA
    </div>
    <div class="col-12">
      <q-btn :loading="loading" :color="tab==='revisionPago'?'white':'grey'"
             label="REVISION DE PAGOS" no-caps text-color="black"
             :class="`text-bold w-200`"
             size="15px" @click="tab = 'revisionPago'"/>
      <q-btn :loading="loading" :color="tab==='revisionPedido'?'white':'grey'"
             label="REVISION DE PEDIDOS" no-caps text-color="black"
             :class="`text-bold w-200`"
             size="15px" @click="tab = 'revisionPedido'"/>
      <q-btn :loading="loading" :color="tab==='busqueda'?'white':'grey'"
             label="BUSQUEDA" no-caps text-color="black"
             :class="`text-bold w-200`"
             size="15px" @click="tab = 'busqueda'"/>
      <q-card>
        <q-tab-panels v-model="tab" animated>
          <q-tab-panel name="revisionPago">
            contacto
          </q-tab-panel>
          <q-tab-panel name="revisionPedido">
            notas
          </q-tab-panel>
          <q-tab-panel name="busqueda">
            pedido
          </q-tab-panel>
        </q-tab-panels>
      </q-card>
    </div>
  </div>
  <q-dialog v-model="empresaDialog">
    <q-card class="q-pa-xs" style="max-width: 400px">
      <q-card-section class="q-py-none row items-center">
        <div class="text-h6">{{empresaOption === 'create' ? 'Crear' : 'Editar'}} Empresa</div>
        <q-space />
        <q-btn flat dense icon="cancel" v-close-popup />
      </q-card-section>
      <q-card-section class="q-py-none">
        <q-form @submit="empresaSubmit">
          <div class="row">
            <div class="col-12">
              <q-input dense outlined v-model="empresa.nombre" label="Nombre" type="text"
                       :rules="[val => !!val || 'El nombre es requerido']"/>
            </div>
            <div class="col-12">
              <q-input dense outlined v-model="empresa.contacto" label="Contacto"
                        :rules="[val => !!val || 'El contacto es requerido']"/>
            </div>
            <div class="col-12">
              <q-input dense outlined v-model="empresa.vendedor" label="Vendedor" type="text"
                       :rules="[val => !!val || 'El vendedor es requerido']"/>
            </div>
            <template v-if="empresaOption === 'create' ">
              <div class="col-12">
                <q-select dense outlined v-model="empresa.vendedorCargo" label="Cargo" :options="$cargos"
                          :rules="[val => !!val || 'El cargo es requerido']"/>
              </div>
              <div class="col-12">
                <q-input dense outlined v-model="empresa.vendedorNombre" label="Nombre Personal" type="text"
                         :rules="[val => !!val || 'El nombre del vendedor es requerido']"/>
              </div>
              <div class="col-12">
                <q-input dense outlined v-model="empresa.vendedorDni" label="DNI Personal" type="text"
                         :rules="[val => !!val || 'El DNI del vendedor es requerido']"/>
              </div>
              <div class="col-12">
                <q-input dense outlined v-model="empresa.vendedorTelefono" label="Telefono Personal" type="text"
                         :rules="[val => !!val || 'El telefono del vendedor es requerido']"/>
              </div>
              <div class="col-12">
                <q-input dense outlined v-model="empresa.vendedorEmail" label="Email Personal" type="text"
                         :rules="[val => !!val || 'El email del vendedor es requerido']"/>
              </div>
            </template>
          </div>
          <q-card-actions align="right">
            <q-btn dense no-caps label="Cancelar" v-close-popup color="red" :loading="loading"/>
            <q-btn dense no-caps :loading="loading" type="submit"
                   :label="empresaOption === 'create' ? 'Crear' : 'Editar'"
                   :color="empresaOption === 'create' ? 'blue' : 'orange'" />
          </q-card-actions>
        </q-form>
      </q-card-section>
    </q-card>
  </q-dialog>
</q-page>
</template>
<script>
// import SearchEmpresaComponent from 'pages/central-files/SearchEmpresaComponent.vue'
// import ContactoComponent from 'pages/central-files/ContactoComponent.vue'
// import NotasComponent from 'pages/central-files/NotasComponent.vue'
// import PedidosComponent from 'pages/central-files/PedidosComponent.vue'
export default {
  name: 'IndexTesoreriaPage',
  // components: {
  //   SearchEmpresaComponent,
  //   ContactoComponent,
  //   NotasComponent,
  //   PedidosComponent
  // },
  data () {
    return {
      tab: 'revisionPago',
      loading: false,
      empresa: {},
      empresas: [],
      pedidos: [],
      ocultar: true,
      direccion: [],
      phoneDireccions: [],
      facturacion: [],
      sucursals: [],
      persons: [],
      notes: [],
      empresaDialog: false,
      empresaOption: '',
      filter: 'numero'
    }
  },
  mounted () {
    this.$watch(() => this.$route.path, () => {
      this.ocultar = true
      // this.empresas = []
      this.empresa = {}
    })
    this.getEmpresas('', this.filter)
    // this.empresaSearch({ id: 1 })
  },
  methods: {
    eliminarEmpresasSinPedidos () {
      this.$q.dialog({
        title: 'Eliminar Empresas',
        message: '¿Estas seguro de eliminar las empresas sin pedidos?',
        cancel: true,
        persistent: true
      }).onOk(() => {
        this.loading = true
        this.$axios.delete('eliminarEmpresasSinPedidos')
          .then(response => {
            this.getEmpresas('', this.filter)
          }).catch(error => {
            this.$alert(error.response.data.message)
          }).finally(() => {
            this.loading = false
          })
      }).onCancel(() => {
        // console.log('>>>> Cancel')
      }).onDismiss(() => {
        // console.log('I am triggered on both OK and Cancel')
      })
    },
    clickEditEmpresa (empresa) {
      this.empresaDialog = true
      this.empresa = { ...empresa }
      this.empresaOption = 'edit'
    },
    empresaFilter (search, filter) {
      this.filter = filter
      this.getEmpresas(search, filter)
    },
    getEmpresas (search, filter) {
      this.loading = true
      this.$axios.get('empresas?search=' + search + '&filter=' + filter)
        .then(response => {
          this.empresas = response.data.data
        }).catch(error => {
          this.$alert(error.response.data.message)
        }).finally(() => {
          this.loading = false
        })
    },
    empresaDialogClick () {
      this.empresaDialog = true
      this.empresaOption = 'create'
      this.empresa = {}
    },
    empresaSubmit () {
      this.loading = true
      if (this.empresaOption === 'create') {
        this.$axios.post('empresas', this.empresa).then(response => {
          this.getEmpresas()
          this.empresaSearch({ id: response.data.id })
          this.empresaDialog = false
        }).catch(error => {
          this.$alert.error(error)
        }).finally(() => {
          this.loading = false
        })
      } else {
        this.$axios.put('empresas/' + this.empresa.id, this.empresa).then(response => {
          this.getEmpresas()
          this.empresaDialog = false
        }).catch(error => {
          this.$alert.error(error)
        }).finally(() => {
          this.loading = false
        })
      }
    },
    empresaSearch (empresa) {
      this.empresa = empresa
      this.loading = true
      this.$axios.get('empresas/' + empresa.id)
        .then(response => {
          this.empresa = response.data
          this.direccion = response.data.direccion
          this.phoneDireccions = this.direccion.phone_direccions
          this.facturacion = response.data.facturacion
          this.sucursals = response.data.sucursals
          this.persons = response.data.person
          this.notes = response.data.notes
          this.pedidos = response.data.pedidos
        })
        .catch(error => {
          console.log(error)
        }).finally(() => {
          this.loading = false
          this.ocultar = false
        })
    }
  },
  computed: {
    url () {
      const path = this.$route.path
      // console.log(path)
      return path
    }
  }
}
</script>
