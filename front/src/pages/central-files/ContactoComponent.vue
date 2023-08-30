<template>
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
                  <template v-if="perosn.phone.length>0">
                    <div v-for="phone in perosn.phone" :key="phone.id" class="row items-center q-mr-md">
                      Telefono: <b>{{phone.phone}}</b>
                      <q-space />
                      <q-btn size="10px" flat dense icon="cancel"
                             @click="deletePhone(phone.id)"
                             :loading="loading"
                             no-caps color="grey">
                        <q-tooltip>
                          Eliminar Telefono
                        </q-tooltip>
                      </q-btn>
                      <q-btn size="10px" flat dense icon="add_circle_outline"
                             @click="addPhone(perosn.id)"
                             :loading="loading"
                             v-if="phone.id == perosn.phone[perosn.phone.length - 1].id"
                             no-caps color="blue">
                        <q-tooltip>
                          Agregar Telefono
                        </q-tooltip>
                      </q-btn>
                      <q-btn v-else size="10px" flat dense icon=""/>
                    </div>
                  </template>
                  <template v-else>
                    <q-btn size="10px" flat dense icon="add_circle_outline"
                           @click="addPhone(perosn.id)"
                           :loading="loading"
                           no-caps color="blue">
                      <q-tooltip>
                        Agregar Telefono
                      </q-tooltip>
                    </q-btn>
                  </template>
                </div>
                <div class="col-7">
                  <template v-if="perosn.email.length>0">
                    <div v-for="email in perosn.email" :key="email.id" class="row items-center">
                      Email: <b>{{email.email}}</b>
                      <q-space />
                      <q-checkbox dense v-model="email.status" left-label :label="email.status"
                                  false-value="No" true-value="Si" :disable="loading" @update:model-value="updateEmailStatus(email)"/>
                      <q-btn size="10px" flat dense icon="cancel" no-caps
                             color="grey" :loading="loading" @click="deleteEmail(email.id)">
                        <q-tooltip>
                          Eliminar Email
                        </q-tooltip>
                      </q-btn>
                      <q-btn size="10px" flat dense icon="add_circle_outline" no-caps
                             color="blue" :loading="loading" v-if="email.id == perosn.email[perosn.email.length - 1].id"
                             @click="addEmail(perosn.id)">
                        <q-tooltip>
                          Agregar Email
                        </q-tooltip>
                      </q-btn>
                      <q-btn v-else size="10px" flat dense icon=""/>
                    </div>
                  </template>
                  <template v-else>
                    <q-btn size="10px" flat dense icon="add_circle_outline" no-caps
                           color="blue" :loading="loading" @click="addEmail(perosn.id)">
                      <q-tooltip>
                        Agregar Email
                      </q-tooltip>
                    </q-btn>
                  </template>
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
</template>
<script>
export default {
  name: 'ContactoComponent',
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
      loading: false
    }
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
            this.$emit('empresaSearch', this.empresa)
          }).catch(error => {
            this.$alert.error(error)
          }).finally(() => {
            this.loading = false
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
          this.$emit('empresaSearch', this.empresa)
        }).catch(error => {
          this.$alert.error(error)
        }).finally(() => {
          this.loading = false
        })
      })
    },
    addEmail (personId) {
      this.$q.dialog({
        title: 'Agregar Email',
        message: 'Ingrese el email',
        prompt: {
          model: '',
          type: 'text'
        },
        cancel: true,
        persistent: true
      }).onOk(data => {
        this.loading = true
        this.$axios.post('emails', {
          email: data,
          person_id: personId
        }).then(response => {
          this.$emit('empresaSearch', this.empresa)
        }).catch(error => {
          this.$alert.error(error)
        }).finally(() => {
          this.loading = false
        })
      })
    },
    deleteEmail (id) {
      this.$q.dialog({
        title: 'Eliminar',
        message: '¿Desea eliminar el email?',
        cancel: true,
        persistent: true
      }).onOk(() => {
        this.loading = true
        this.$axios.delete('emails/' + id)
          .then(response => {
            this.$emit('empresaSearch', this.empresa)
          }).catch(error => {
            this.$alert.error(error)
          }).finally(() => {
            this.loading = false
          })
      })
    },
    updateEmailStatus (email) {
      this.$axios.put('emails/' + email.id, {
        status: email.status
      })
    }
  }
}
</script>
