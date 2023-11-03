<template>
<q-page class="q-pa-xs bg-grey-3">
  <div class="row">
    <div class="col-12 col-md-3 bg-blue-1 full-height" v-if="ocultar">
      <div class="row">
        <div class="col-12 text-uppercase luckiest text-h6 text-center">
          Central Files
          <q-btn :loading="loading" round dense flat icon="add_circle_outline" color="blue"
                 to="create-empresa">
            <q-tooltip>Crear Empresa</q-tooltip>
          </q-btn>
<!--          <q-btn :loading="loading" round dense flat icon="o_delete" color="red" @click="eliminarEmpresasSinPedidos">-->
<!--            <q-tooltip>Eliminar empresas sin pedidos</q-tooltip>-->
<!--          </q-btn>-->
        </div>
        <div class="col-12">
          <SearchEmpresaComponent
            :last_page="last_page"
            @empresaFilter="empresaFilter"
            :loading="loading"
            @empresaSearch="empresaSearch"
            :empresas="empresas"
            @empresaPage="empresaPage"/>
        </div>
      </div>
    </div>
    <div :class="`col-12 q-pa-xs ${ocultar?'col-md-9':'col-md-12'}`">
      <div class="row" v-if="empresa.id">
        <div class="col-12 col-md-8">
          <q-item>
            <q-item-section top avatar class="q-pl-lg">
              <q-btn dense flat icon="menu" color="grey" no-caps
                     :loading="loading" @click="ocultar = !ocultar" style="position: absolute; left: 0;">
                <q-tooltip>
                  Ver mas
                </q-tooltip>
              </q-btn>
                <q-avatar size="100px" color="grey-3">
                  <q-icon name="account_circle" size="90px" />
                </q-avatar>
            </q-item-section>
            <q-item-section>
              <q-item-label class="text-bold text-h5 row items-center">
                {{empresa.nombre}}
                <q-space />
                <q-btn dense flat icon="o_refresh" color="grey" no-caps
                       :loading="loading" @click="empresaSearch(empresa)">
                  <q-tooltip>
                    Actualizar
                  </q-tooltip>
                </q-btn>
                <q-btn dense flat icon="o_edit" color="grey" no-caps
                       :loading="loading" @click="clickEditEmpresa(empresa)">
                  <q-tooltip>
                    Editar
                  </q-tooltip>
                </q-btn>
              </q-item-label>
              <q-item-label >
                <q-item>
                  <q-item-section top avatar>
                    <q-item-label class="text-h5 text-red-7 text-bold">
                      #{{empresa.id}}
                    </q-item-label>
                  </q-item-section>
                  <q-item-section side top>
                    <q-item-label>
                      Vendedor: <b>{{empresa.vendedor}}</b><br>
                      Como nos encontro: <b>{{empresa.contacto}}</b><br>
                      Inicio: <b v-if="empresa.created_at">
                      {{$filters.shortDate(empresa.created_at)}}
                    </b>
                    </q-item-label>
                  </q-item-section>
                </q-item>
              </q-item-label>
            </q-item-section>
          </q-item>
        </div>
        <div class="col-12 col-md-4">
          <q-card>
            <q-card-section class="q-pa-none q-ma-none">
              <div class="row">
                <div class="col-6">
                  <q-card flat bordered class="q-ma-xs">
                    <q-card-section class="q-pa-xs text-center bg-grey text-white">
                      A favor
                    </q-card-section>
                    <q-card-section class="q-pa-xs text-center bg-grey-1">
                      <div class="text-h5 text-bold text-red-7">
                        $ {{aFavor}}
                      </div>
                    </q-card-section>
                  </q-card>
                </div>
                <div class="col-6">
                  <div class="row">
                    <div class="col cursor-pointer q-pa-xs bg-red-8" @click="credibilidadEmpresa(20)"></div>
                    <div class="col cursor-pointer q-pa-xs bg-red-5" @click="credibilidadEmpresa(40)"></div>
                    <div class="col cursor-pointer q-pa-xs bg-yellow" @click="credibilidadEmpresa(60)"></div>
                    <div class="col cursor-pointer q-pa-xs bg-green-4" @click="credibilidadEmpresa(80)"></div>
                    <div class="col cursor-pointer q-pa-xs bg-green" @click="credibilidadEmpresa(100)"></div>
                  </div>
                  <div class="text-center text-bold text-caption">Credibilidad {{empresa.credibilidad}}%</div>
                  <div class="text-center">
                    <q-btn dense label="Pago" no-caps color="blue" />
                    <q-btn dense icon="close" no-caps color="grey" />
                  </div>
                </div>
              </div>
            </q-card-section>
          </q-card>
        </div>
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
              <q-tab-panel name="pedido">
                <PedidosComponent :empresa="empresa" :pedidos="pedidos" @empresaSearch="empresaSearch"/>
              </q-tab-panel>
              <q-tab-panel name="notas">
                <NotasComponent :empresa="empresa" :notes="notes" @empresaSearch="empresaSearch"/>
              </q-tab-panel>
            </q-tab-panels>
          </q-card>
        </div>
      </div>
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
              <q-input dense outlined v-model="empresa.contacto" label="Como nos encontró" type="text"
                        :rules="[val => !!val || 'El contacto es requerido']"/>
            </div>
            <div class="col-12">
              <q-input dense outlined v-model="empresa.vendedor" label="Vendedor" type="text"
                       :rules="[val => !!val || 'El vendedor es requerido']"/>
            </div>
<!--            <template v-if="empresaOption === 'create' ">-->
<!--              <div class="col-12">-->
<!--                <q-select dense outlined v-model="empresa.vendedorCargo" label="Cargo" :options="$cargos"-->
<!--                          :rules="[val => !!val || 'El cargo es requerido']"/>-->
<!--              </div>-->
<!--              <div class="col-12">-->
<!--                <q-input dense outlined v-model="empresa.vendedorNombre" label="Nombre Personal" type="text"-->
<!--                         :rules="[val => !!val || 'El nombre del vendedor es requerido']"/>-->
<!--              </div>-->
<!--              <div class="col-12">-->
<!--                <q-input dense outlined v-model="empresa.vendedorDni" label="DNI Personal" type="text"-->
<!--                         :rules="[val => !!val || 'El DNI del vendedor es requerido']"/>-->
<!--              </div>-->
<!--              <div class="col-12">-->
<!--                <q-input dense outlined v-model="empresa.vendedorTelefono" label="Telefono Personal" type="text"-->
<!--                         :rules="[val => !!val || 'El telefono del vendedor es requerido']"/>-->
<!--              </div>-->
<!--              <div class="col-12">-->
<!--                <q-input dense outlined v-model="empresa.vendedorEmail" label="Email Personal" type="text"-->
<!--                         :rules="[val => !!val || 'El email del vendedor es requerido']"/>-->
<!--              </div>-->
<!--            </template>-->
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
import SearchEmpresaComponent from 'pages/central-files/SearchEmpresaComponent.vue'
import ContactoComponent from 'pages/central-files/ContactoComponent.vue'
import NotasComponent from 'pages/central-files/NotasComponent.vue'
import PedidosComponent from 'pages/central-files/PedidosComponent.vue'
import { date } from 'quasar'
export default {
  name: 'IndexCentralFilesPage',
  components: {
    SearchEmpresaComponent,
    ContactoComponent,
    NotasComponent,
    PedidosComponent
  },
  data () {
    return {
      page: 1,
      last_page: 1,
      tab: 'contacto',
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
    credibilidadEmpresa (credibilidad) {
      this.loading = true
      this.empresa.credibilidad = credibilidad
      this.$axios.post('empresaCredibilidad', {
        empresa_id: this.empresa.id,
        credibilidad: credibilidad
      }).then(response => {
        // this.empresaSearch(this.empresa)
      }).catch(error => {
        this.$alert(error.response.data.message)
      }).finally(() => {
        this.loading = false
      })
    },
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
      this.page = 1
      this.getEmpresas(search, filter)
    },
    getEmpresas (search, filter) {
      this.loading = true
      this.$axios.get('empresas?search=' + search + '&filter=' + filter + '&page=' + this.page)
        .then(response => {
          this.empresas = response.data.data
          this.last_page = response.data.last_page
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
          // this.getEmpresas('', this.filter)
          // this.empresaSearch({ id: response.data.id })
          this.empresaDialog = false
        }).catch(error => {
          this.$alert.error(error)
        }).finally(() => {
          this.loading = false
        })
      } else {
        this.$axios.put('empresas/' + this.empresa.id, this.empresa).then(response => {
          this.getEmpresas('', this.filter)
          this.empresaDialog = false
        }).catch(error => {
          this.$alert.error(error)
        }).finally(() => {
          this.loading = false
        })
      }
    },
    empresaPage (search, filter, page) {
      this.page = page
      this.getEmpresas(search, filter)
    },
    empresaSearch (empresa) {
      this.empresa = empresa
      this.loading = true
      this.page = 1
      // this.tab = 'contacto'

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
          this.$store.pedido = {
            codigo: 0,
            producto: '',
            medida: '',
            cantidad: '',
            esp: '',
            gr: '',
            lados: '',
            diseno: '',
            descripcion: '',
            estado: '',
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
            pago: '',
            metodoPago: 'Efectivo',
            comentarioPago: '',
            iva: 15,
            seFacturo: 'No',
            facturaA: 'Factura ninguna',
            empresa_id: this.empresa.id,
            user_id: 3,
            sucursal_id: 2,
            facturacion_id: 2,
            direccion_id: 1,
            persona_id: 2,
            phone_id: 2,
            email_id: 2,
            deleted_at: null,
            precioTotal: 1594.13,
            deuda: 1114.13,
            sucursal: this.empresa.sucursals[0],
            person: this.empresa.person[0],
            direccion: this.empresa.direccion[0],
            facturacion: this.empresa.facturacion[0]
          }
        })
        .catch(error => {
          console.log(error)
        }).finally(() => {
          this.loading = false
          // this.ocultar = false
        })
    }
  },
  computed: {
    aFavor () {
      const sumDeudadPedido = parseFloat(this.empresa.sumDeudaPedido || 0)
      // console.log(this.empresa)
      const sumPagoEmpresa = parseFloat(this.empresa.sumPagoEmpresa || 0)
      // console.log(sumPagoEmpresa)
      return sumPagoEmpresa - sumDeudadPedido
    },
    url () {
      const path = this.$route.path
      // console.log(path)
      return path
    }
  }
}
</script>
