<template>
<q-page class="q-pa-xs bg-grey-3">
  <div class="row">
    <div class="col-12 col-md-3 bg-blue-1 full-height" v-if="ocultar">
      <div class="row">
        <div class="col-12 text-uppercase luckiest text-h6 text-center">
          Central Files
        </div>
        <div class="col-12">
          <SearchEmpresaComponent @empresaSearch="empresaSearch" />
        </div>
      </div>
    </div>
    <div :class="`col-12 q-pa-xs ${ocultar?'col-md-9':'col-md-12'}`">
      <div class="row" v-if="empresa.id">
        <div class="col-12 col-md-8">
          <q-item>
            <q-item-section top avatar>
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
              <q-item-label class="text-bold text-h5">{{empresa.nombre}}</q-item-label>
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
                      Contacto: <b>{{empresa.contacto}}</b><br>
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
                        $ 2000
                      </div>
                    </q-card-section>
                  </q-card>
                </div>
                <div class="col-6">
                  <div class="row">
                    <div class="col text-center q-pa-xs bg-red-8"></div>
                    <div class="col text-center q-pa-xs bg-red-5"></div>
                    <div class="col text-center q-pa-xs bg-yellow"></div>
                    <div class="col text-center q-pa-xs bg-green-4"></div>
                    <div class="col text-center q-pa-xs bg-green"></div>
                  </div>
                  <div class="text-center text-bold text-caption">Credibilidad 50</div>
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
                                   v-if="persons.length>0"
                                   :phoneDireccions="phoneDireccions"
                                   :facturacion="facturacion"
                                   :sucursals="sucursals"
                                   :persons="persons"
                                   @empresaSearch="empresaSearch"/>
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
</q-page>
</template>
<script>
import SearchEmpresaComponent from 'pages/central-files/SearchEmpresaComponent.vue'
import ContactoComponent from 'pages/central-files/ContactoComponent.vue'
import NotasComponent from 'pages/central-files/NotasComponent.vue'
export default {
  name: 'IndexCentralFilesPage',
  components: {
    SearchEmpresaComponent,
    ContactoComponent,
    NotasComponent
  },
  data () {
    return {
      tab: 'notas',
      loading: false,
      empresa: {},
      ocultar: true,
      direccion: [],
      phoneDireccions: [],
      facturacion: [],
      sucursals: [],
      persons: [],
      notes: []
    }
  },
  mounted () {
    this.empresaSearch({ id: 1 })
  },
  methods: {
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
        })
        .catch(error => {
          console.log(error)
        }).finally(() => {
          this.loading = false
          this.ocultar = false
        })
    }
  }
}
</script>
