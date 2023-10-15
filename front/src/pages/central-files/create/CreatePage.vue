<template>
  <q-page class="q-pa-xs bg-grey-3">
    <div class="row">
      <div class="col-12 text-uppercase luckiest text-h3 text-center">
        Nuevo Cliente
      </div>
      <div class="col-12 flex flex-center">
        <div style="width: 500px">
        <q-item clickable v-ripple>
          <q-item-section avatar>
            <q-avatar>
              <q-icon name="account_circle" size="45px" color="grey-8" />
            </q-avatar>
          </q-item-section>

          <q-item-section>
            <div class="row">
              <div class="col-4 flex flex-center">
                Empresa:
              </div>
              <div class="col-8">
                <q-input dense
                         class="super-small"
                         outlined
                         v-model="empresa.nombre"
                         :input-style="{ fontSize: '12px' }" />
              </div>
              <div class="col-4 flex flex-center">
                Contacto:
              </div>
              <div class="col-8">
                <q-input dense
                         class="super-small"
                         outlined
                         v-model="empresa.contacto"
                         :input-style="{ fontSize: '12px' }" />
              </div>
              <div class="col-4 flex flex-center">
                Vendedor:
              </div>
              <div class="col-8">
                <q-input dense
                         class="super-small"
                         outlined
                         v-model="empresa.vendedor"
                         :input-style="{ fontSize: '12px' }" />
              </div>
            </div>
          </q-item-section>
        </q-item>
        </div>
      </div>
      <div class="col-12 q-pa-xs">
        <div class="row">
          <div class="col-12">
            <q-card>
<!--              <q-tab-panels v-model="tab" animated>-->
                <q-tab-panel name="contacto">
                  <ContactoComponent :empresa="empresa" :direccion="direccion"
                                     :phoneDireccions="phoneDireccions"
                                     :facturacion="facturacion"
                                     :sucursals="sucursals"
                                     :persons="persons"
                                     @newPerson="newPerson"
                                     @newSucursal="newSucursal"
                                     @newDireccion="newDireccion"
                                      @newFacturacion="newFacturacion"
                  />
                </q-tab-panel>
<!--                <q-tab-panel name="pedido">-->
<!--                  <PedidosComponent :empresa="empresa" :pedidos="pedidos" @empresaSearch="empresaSearch"/>-->
<!--                </q-tab-panel>-->
<!--              </q-tab-panels>-->
              <div class="text-center q-pb-xs">
                <q-btn no-caps label="Crear Pedido" color="blue" class="text-bold" @click="nuevoPedido"/>
              </div>
            </q-card>
          </div>
        </div>
      </div>
    </div>
    <q-dialog v-model="pedidoDialogNew">
      <PedidoNewComponent :empresa="empresa" :pedidoDato="pedidoDato"
                          @closeDialog="closeDialog"
      />
    </q-dialog>
    <pre>{{empresa}}</pre>
  </q-page>
</template>
<script>
import ContactoComponent from 'pages/central-files/create/CreateContactoComponent.vue'
import PedidoNewComponent from 'pages/central-files/PedidoNewComponent.vue'
import { date } from 'quasar'
// import PedidosComponent from 'pages/central-files/PedidosComponent.vue'
export default {
  name: 'IndexCentralFilesPage',
  components: {
    PedidoNewComponent,
    ContactoComponent
    // PedidosComponent
  },
  data () {
    return {
      pedidoDialogNew: false,
      loading: false,
      pedidoDato: {
        codigo: 0,
        producto: '',
        medida: '',
        cantidad: '',
        esp: '',
        gr: '150',
        lados: '2 lados diferentes',
        diseno: 'nuevo',
        descripcion: '',
        estado: 'Diseño',
        fechaTexto: '',
        estadoPedido: 'Activo',
        fecha: date.formatDate(new Date(), 'YYYY-MM-DD'),
        diasCompra: 5,
        fechaEntrega: date.formatDate(new Date(), 'YYYY-MM-DD'),
        fechaEspecial: date.formatDate(new Date(), 'YYYY-MM-DD'),
        precioProducto: 0,
        precioDiseno: 0,
        especificaciones: '',
        terminacion: '',
        envio: '',
        precioEspecificaciones: 0,
        precioEnvio: 0,
        pago: 0,
        metodoPago: 'Efectivo',
        comentarioPago: '',
        iva: 15,
        seFacturo: 'No',
        facturaA: 'Factura ninguna',
        empresa_id: 0,
        user_id: 3,
        sucursal_id: 2,
        facturacion_id: 2,
        direccion_id: 1,
        persona_id: 2,
        phone_id: 2,
        email_id: 2,
        deleted_at: null,
        precioTotal: 1594.13,
        deuda: 1114.13
        // sucursal: this.empresa.sucursals[0],
        // person: this.empresa.person[0],
        // direccion: this.empresa.direccion[0],
        // facturacion: this.empresa.facturacion[0]
      },
      empresa: {
        id: 0,
        nombre: '',
        contacto: '',
        vendedor: '',
        proximoPedido: '28 dic 2021',
        promedioDiasCompra: 0,
        codigo: '#0001',
        direccion: [
        ],
        facturacion: [
        ],
        sucursals: [
        ],
        person: [
        ],
        notes: [],
        pedidos: []
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
    this.direccion = this.empresa.direccion
    this.phoneDireccions = this.direccion.phone_direccions
    this.facturacion = this.empresa.facturacion
    this.sucursals = this.empresa.sucursals
    this.persons = this.empresa.person
    this.notes = this.empresa.notes
    this.pedidos = this.empresa.pedidos
  },
  methods: {
    closeDialog () {
      this.pedidoDialogNew = false
    },
    nuevoPedido () {
      if (this.empresa.person.length === 0) {
        this.$alert.error('Debe agregar un contacto')
        return
      }
      if (this.empresa.sucursals.length === 0) {
        this.$alert.error('Debe agregar una sucursal')
        return
      }
      this.pedidoDato.persona_id = this.empresa.person[0].id
      this.pedidoDato.sucursal_id = this.empresa.sucursals[0].id
      this.pedidoDialogNew = true
    },
    newFacturacion (facturacion) {
      const id = this.facturacion.length + 1
      facturacion.id = id
      facturacion.empresa_id = this.empresa.id
      this.facturacion.push(facturacion)
      // this.empresas.facturacion = this.facturacion
    },
    newDireccion (direccion) {
      const id = this.direccion.length + 1
      direccion.id = id
      direccion.empresa_id = this.empresa.id
      direccion.phone_direccions = [
        {
          phone: direccion.phone
        }
      ]
      this.direccion.push(direccion)
      // this.empresas.direccion = this.direccion
    },
    newSucursal (sucursal) {
      const id = this.sucursals.length + 1
      sucursal.id = id
      sucursal.empresa_id = this.empresa.id
      this.sucursals.push(sucursal)
      // this.empresas.sucursals = this.sucursals
    },
    newPerson (person) {
      const id = this.persons.length + 1
      person.id = id
      person.phone = [
        {
          phone: person.phone
        }
      ]
      person.email = [
        {
          email: person.email,
          status: 'Si'
        }
      ]
      console.log(person)
      this.persons.push(person)
      // this.empresas.person = this.persons
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
<style lang="scss">
.super-small.q-field--dense {
  .q-field__control-container,
  .q-field__native {
    //padding-top: 10px !important;
  }

  .q-field__control {
    height: 25px !important;
    min-height: 25px !important;
  }

  .q-field__marginal {
    height: 25px !important;
  }

  .q-field__label {
    top: 6px !important;
  }
}
</style>
