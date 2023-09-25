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
            <q-markup-table>
              <thead>
              <tr class="bg-black text-white">
                <th class="text-left"><q-checkbox v-model="allSelected" dark label="All" /></th>
                <th class="text-left">Fecha</th>
                <th class="text-left">Nº CI.</th>
                <th class="text-left">Nombre</th>
                <th class="text-left">Medio</th>
                <th class="text-left">Monto</th>
                <th class="text-left">Facturado</th>
                <th class="text-left">Usuario</th>
              </tr>
              </thead>
              <tbody>
                <tr v-for="pago in pagos" :key="pago.id">
                  <td class="text-left"><q-checkbox v-model="pago.selected"/></td>
                  <td class="text-left">{{pago.fecha}}</td>
                  <td class="text-left">{{pago.dni}}</td>
                  <td class="text-left">{{pago.nombre}}</td>
                  <td class="text-left">{{pago.metodoPago}}</td>
                  <td class="text-left">{{$filters.currency(pago.monto)}}</td>
                  <td class="text-left">
                    <q-badge :color="pago.facturado?'green':'red'">
                      {{pago.facturado}}
                    </q-badge>
                  </td>
                  <td class="text-left">{{pago.user.name}}</td>
                </tr>
              </tbody>
            </q-markup-table>
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
</q-page>
</template>
<script>
export default {
  name: 'IndexTesoreriaPage',
  data () {
    return {
      tab: 'revisionPago',
      loading: false,
      pago: {},
      allSelected: false,
      pagos: [],
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
    this.getPagos()
  },
  methods: {
    // eliminarEmpresasSinPedidos () {
    //   this.$q.dialog({
    //     title: 'Eliminar Empresas',
    //     message: '¿Estas seguro de eliminar las empresas sin pedidos?',
    //     cancel: true,
    //     persistent: true
    //   }).onOk(() => {
    //     this.loading = true
    //     this.$axios.delete('eliminarEmpresasSinPedidos')
    //       .then(response => {
    //         this.getEmpresas('', this.filter)
    //       }).catch(error => {
    //         this.$alert(error.response.data.message)
    //       }).finally(() => {
    //         this.loading = false
    //       })
    //   }).onCancel(() => {
    //   }).onDismiss(() => {
    //   })
    // },
    // clickEditEmpresa (empresa) {
    //   this.empresaDialog = true
    //   this.empresa = { ...empresa }
    //   this.empresaOption = 'edit'
    // },
    // empresaFilter (search, filter) {
    //   this.filter = filter
    //   this.getEmpresas(search, filter)
    // },
    getPagos () {
      this.loading = true
      this.$axios.get('pagos')
        .then(response => {
          this.pagos = response.data
          console.log(this.pagos)
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
      return path
    }
  }
}
</script>
