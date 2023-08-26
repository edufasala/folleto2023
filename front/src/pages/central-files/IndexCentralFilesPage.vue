<template>
<q-page class="q-pa-xs bg-grey-3">
  <div class="row">
    <div class="col-12 col-md-3 bg-blue-1 full-height">
      <div class="row">
        <div class="col-12 text-uppercase luckiest text-h6 text-center">
          Central Files
        </div>
        <div class="col-12">
          <SearchEmpresaComponent @empresaSearch="empresaSearch" />
        </div>
      </div>
    </div>
    <div class="col-12 col-md-9">
      <div class="row" v-if="empresa.id">
        <div class="col-12 col-md-8">
          <q-item>
            <q-item-section top avatar>
                <q-avatar size="100px" color="grey-3">
                  <q-icon name="account_circle" size="100px" />
                </q-avatar>
            </q-item-section>
            <q-item-section>
              <q-item-label class="text-bold text-h4">{{empresa.nombre}}</q-item-label>
              <q-item-label >
                <q-item>
                  <q-item-section top avatar>
                    <q-item-label class="text-h4 text-red-7 text-bold">
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
                    <q-card-section class="q-pa-xs text-center">
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
      </div>
    </div>
  </div>
</q-page>
</template>
<script>
import SearchEmpresaComponent from 'pages/central-files/SearchEmpresaComponent.vue'
export default {
  name: 'IndexCentralFilesPage',
  components: {
    SearchEmpresaComponent
  },
  data () {
    return {
      loading: false,
      empresa: {},
      direccion: [],
      phoneDireccions: [],
      facturacion: [],
      sucursals: [],
      persons: [],
      phone: [],
      email: []
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
          this.persons = response.data.persons
          this.phone = this.persons.phone
          this.email = this.persons.email
        })
        .catch(error => {
          console.log(error)
        }).finally(() => {
          this.loading = false
        })
    }
  }
}
</script>
