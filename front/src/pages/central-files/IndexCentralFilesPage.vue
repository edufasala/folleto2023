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
    <div class="col-12 col-md-9 q-pa-xs">
      <div class="row" v-if="empresa.id">
        <div class="col-12 col-md-8">
          <q-item>
            <q-item-section top avatar>
                <q-avatar size="100px" color="grey-3">
                  <q-icon name="account_circle" size="100px" />
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
          <q-btn :loading="loading" :color="tab=='contacto'?'white':'grey'"
                 label="CONTACTO" no-caps text-color="black"
                 :class="`text-bold w-150`"
                 size="15px" @click="tab = 'contacto'"/>
          <q-btn :loading="loading" :color="tab=='pedido'?'white':'grey'"
                 label="PEDIDOS" no-caps text-color="black"
                 :class="`text-bold w-150`"
                 size="15px" @click="tab = 'pedido'"/>
          <q-btn :loading="loading" :color="tab=='notas'?'white':'grey'"
                 label="NOTAS" no-caps text-color="black"
                 :class="`text-bold w-150`"
                 size="15px" @click="tab = 'notas'"/>
          <q-card>
            <q-tab-panels v-model="tab" animated>
              <q-tab-panel name="contacto">
                <div class="row">
                  <div class="col-12 col-md-7">
                    <div class="row">
                      <div class="col-12 row items-center">
                        <div class="text-bold">PERSONAS</div>
                        <q-space />
                        <q-btn :loading="loading" round dense flat icon="add_circle_outline" color="blue">
                          <q-tooltip>Crear</q-tooltip>
                        </q-btn>
                      </div>
                      <div class="col-12">
                        <q-card v-for="perosn in persons" :key="perosn.id" flat bordered class="bg-grey-3 q-mb-xs">
                          <q-card-section class="q-pa-xs">
                            <div class="row text-caption">
                              <div class="col-5">
                                Nombre: <b>{{perosn.nombre}}</b>
                              </div>
                              <div class="col-4">
                                Cargo: <b>{{perosn.cargo}}</b>
                              </div>
                              <div class="col-3">
                                DNI: <b>{{perosn.dni}}</b>
                              </div>
                              <div class="col-5">
<!--                                <pre>{{persons.phone.length}}</pre>-->
<!--                                <div v-if="persons.phone">-->
                                  <div v-for="phone in perosn.phone" :key="phone.id">
                                    Telefono: <b>{{phone.phone}}</b>
                                    <q-btn size="10px" flat dense icon="cancel"
                                           @click="deletePhone(phone.id)"
                                           :loading="loading"
                                           no-caps color="grey">
                                      <q-tooltip>
                                        Eliminar
                                      </q-tooltip>
                                    </q-btn>
                                    <q-btn size="10px" flat dense icon="add_circle_outline"
                                           @click="addPhone(perosn.id)"
                                           :loading="loading"
                                           v-if="phone.id == perosn.phone[perosn.phone.length - 1].id"
                                           no-caps color="blue">
                                      <q-tooltip>
                                        Agregar
                                      </q-tooltip>
                                    </q-btn>
                                  </div>
<!--                                </div>-->
<!--                                <div v-else>as</div>-->
                              </div>
                              <div class="col-7">
                                <div v-for="email in perosn.email" :key="email.id" class="row items-center">
                                  Email: <b>{{email.email}}</b>
                                  <q-space />
                                  <q-checkbox dense v-model="email.status" left-label :label="email.status"
                                              false-value="No" true-value="Si" :disable="loading" />
                                  <q-btn size="10px" flat dense icon="cancel" no-caps
                                         color="grey" :loading="loading">
                                    <q-tooltip>
                                      Eliminar
                                    </q-tooltip>
                                  </q-btn>
                                </div>
                              </div>
                            </div>
                          </q-card-section>
                        </q-card>
                        <pre>{{persons}}</pre>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-md-5">
                  </div>
                </div>
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
export default {
  name: 'IndexCentralFilesPage',
  components: {
    SearchEmpresaComponent
  },
  data () {
    return {
      tab: 'contacto',
      loading: false,
      empresa: {},
      direccion: [],
      phoneDireccions: [],
      facturacion: [],
      sucursals: [],
      persons: []
    }
  },
  mounted () {
    this.empresaSearch({ id: 1 })
  },
  methods: {
    deletePhone (id) {
      this.$q.dialog({
        title: 'Eliminar',
        message: '¿Desea eliminar el telefono?',
        cancel: true,
        persistent: true
      }).onOk(() => {
        this.loading = true
        this.$axios.delete('phones/' + id)
          .then(response => {
            this.empresaSearch(this.empresa)
          }).catch(error => {
            this.$alert.error(error)
          })
      })
    },
    addPhone (personId) {
      this.$q.dialog({
        title: 'Agregar Telefono',
        message: 'Ingrese el telefono',
        prompt: {
          model: '',
          type: 'text'
        },
        cancel: true,
        persistent: true
      }).onOk(data => {
        this.loading = true
        this.$axios.post('phones', {
          phone: data,
          person_id: personId
        }).then(response => {
          this.empresaSearch(this.empresa)
        }).catch(error => {
          this.$alert.error(error)
        })
      })
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
