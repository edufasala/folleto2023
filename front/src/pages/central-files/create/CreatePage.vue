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
                  />
                </q-tab-panel>
<!--                <q-tab-panel name="pedido">-->
<!--                  <PedidosComponent :empresa="empresa" :pedidos="pedidos" @empresaSearch="empresaSearch"/>-->
<!--                </q-tab-panel>-->
<!--              </q-tab-panels>-->
            </q-card>
          </div>
        </div>
      </div>
    </div>
    <pre>{{empresa}}</pre>
  </q-page>
</template>
<script>
import ContactoComponent from 'pages/central-files/create/CreateContactoComponent.vue'
// import PedidosComponent from 'pages/central-files/PedidosComponent.vue'
export default {
  name: 'IndexCentralFilesPage',
  components: {
    ContactoComponent
    // PedidosComponent
  },
  data () {
    return {
      loading: false,
      empresa: {
        id: 1,
        nombre: '',
        contacto: '',
        vendedor: '',
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
        ],
        person: [
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
    this.direccion = this.empresa.direccion
    this.phoneDireccions = this.direccion.phone_direccions
    this.facturacion = this.empresa.facturacion
    this.sucursals = this.empresa.sucursals
    this.persons = this.empresa.person
    this.notes = this.empresa.notes
    this.pedidos = this.empresa.pedidos
  },
  methods: {
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
