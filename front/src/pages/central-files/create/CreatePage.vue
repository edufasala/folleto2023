<template>
  <q-page class="q-pa-xs bg-grey-3">
    <div class="row">
      <div class="col-12 text-uppercase luckiest text-h3 text-center">
        Nuevo Cliente
      </div>
      <div class="col-12 flex flex-center">
        <div class="row">
          <div class="col-4 flex flex-center">
            Empresa:
          </div>
          <div class="col-8">
            <q-input dense
                     outlined
                     v-model="empresa.nombre"/>
          </div>
          <div class="col-4 flex flex-center">
            Empresa:
          </div>
          <div class="col-8">
            <q-input dense
                     outlined
                     label="Hello"/>
          </div>
          <div class="col-4 flex flex-center">
            Empresa:
          </div>
          <div class="col-8">
            <q-input dense
                     outlined
                     label="Hello"/>
          </div>
        </div>
      </div>
      <div class="col-12 q-pa-xs">
        <div class="row">
          <div class="col-12">
            <q-btn :loading="loading" :color="tab==='contacto'?'white':'grey'"
                   label="CONTACTO" no-caps text-color="black"
                   :class="`text-bold w-150`"
                   size="15px" @click="tab = 'contacto'"/>
            <q-btn :loading="loading" :color="tab==='pedido'?'white':'grey'"
                   label="PEDIDOS" no-caps text-color="black"
                   :class="`text-bold w-150`"
                   size="15px" @click="tab = 'pedido'"/>
            <q-btn :loading="loading" :color="tab==='notas'?'white':'grey'"
                   label="NOTAS" no-caps text-color="black"
                   :class="`text-bold w-150`"
                   size="15px" @click="tab = 'notas'"/>
            <q-card>
              <q-tab-panels v-model="tab" animated>
                <q-tab-panel name="contacto">
                  <ContactoComponent :empresa="empresa" :direccion="direccion"
                                     :phoneDireccions="phoneDireccions"
                                     :facturacion="facturacion"
                                     :sucursals="sucursals"
                                     :persons="persons"
                                     @empresaSearch="empresaSearch"/>
                </q-tab-panel>
                <q-tab-panel name="notas">
                  <NotasComponent :empresa="empresa" :notes="notes" @empresaSearch="empresaSearch"/>
                </q-tab-panel>
                <q-tab-panel name="pedido">
                  <PedidosComponent :empresa="empresa" :pedidos="pedidos" @empresaSearch="empresaSearch"/>
                </q-tab-panel>
              </q-tab-panels>
            </q-card>
          </div>
        </div>
      </div>
    </div>
    <pre>{{empresa}}</pre>
  </q-page>
</template>
<script>
import ContactoComponent from 'pages/central-files/ContactoComponent.vue'
import NotasComponent from 'pages/central-files/NotasComponent.vue'
import PedidosComponent from 'pages/central-files/PedidosComponent.vue'
export default {
  name: 'IndexCentralFilesPage',
  components: {
    ContactoComponent,
    NotasComponent,
    PedidosComponent
  },
  data () {
    return {
      tab: 'contacto',
      loading: false,
      empresa: {
        id: 1,
        nombre: 'Tapiceria Los Salteños',
        contacto: 'Marcos',
        vendedor: 'Tapiceria Los Salteños',
        deleted_at: null,
        created_at: '2018-05-02T03:48:54.000000Z',
        proximoPedido: '28 dic 2021',
        promedioDiasCompra: 0,
        codigo: '#0001',
        direccion: [
          {
            id: 1,
            direccion: 'Av. Brasil 2357',
            codigoPostal: '0000',
            localidad: '',
            empresa_id: 1,
            deleted_at: null,
            phone_direccions: []
          }
        ],
        facturacion: [
          {
            id: 1,
            cuit: '123456',
            condicional: 'CONDICIONAL',
            razonSocial: 'RAZON SOCIAL',
            comentario: 'COMENTARIO',
            empresa_id: 1,
            deleted_at: null
          }
        ],
        sucursals: [
          {
            id: 1,
            nombre: 'Av. Brasil 2357',
            comentario: '27425677670  \nAldana Rocio Leiva',
            empresa_id: 1,
            deleted_at: null
          }
        ],
        person: [
          {
            id: 1,
            nombre: 'Tapiceria Los Salteños',
            cargo: 'No se conoce',
            dni: '1',
            empresa_id: 1,
            deleted_at: null,
            phone: [],
            email: []
          }
        ],
        notes: [],
        pedidos: [
          {
            id: 1,
            codigo: 0,
            producto: 'Tarjetas Personales',
            medida: '9x5',
            cantidad: '100',
            esp: '0',
            gr: '350gr',
            lados: '',
            diseno: '99',
            descripcion: 'No se conoce',
            estado: '',
            estadoPedido: 'Terminados',
            fecha: '2015-01-14',
            diasCompra: 0,
            fechaEntrega: '2023-09-27',
            fechaEspecial: '2023-09-27',
            fechaTexto: null,
            precioProducto: 0,
            precioDiseno: 0,
            especificaciones: '',
            terminacion: '',
            envio: 'No',
            precioEspecificaciones: 0,
            precioEnvio: 0,
            pago: 0,
            metodoPago: 'Efectivo',
            comentarioPago: '',
            iva: 0,
            seFacturo: 'Si',
            facturaA: null,
            empresa_id: 1,
            user_id: 1,
            sucursal_id: null,
            facturacion_id: null,
            direccion_id: null,
            persona_id: null,
            phone_id: null,
            email_id: null,
            deleted_at: null,
            precioTotal: 0,
            deuda: 0,
            sena: 0,
            sucursal: null,
            person: null,
            direccion: null,
            facturacion: null,
            phone: null,
            email: null,
            pagos: [],
            status: []
          }
        ]
      },
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
    // this.$watch(() => this.$route.path, () => {
    //   this.ocultar = true
    //   // this.empresas = []
    //   this.empresa = {}
    // })
    // this.getEmpresas('', this.filter)
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
      this.tab = 'contacto'
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
<style>
</style>
