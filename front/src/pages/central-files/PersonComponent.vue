<template>
      <div class="row">
        <div class="col-12 row items-center q-pa-none">
          <div class="text-bold">PERSONAS</div>
          <q-space />
          <q-btn :loading="loading" round dense flat icon="add_circle_outline" color="blue" @click="personDialogClick">
            <q-tooltip>Crear</q-tooltip>
          </q-btn>
        </div>
        <div class="col-12 q-mb-md">
          <q-separator />
        </div>
        <div class="col-12">
          <q-card v-for="perosn in persons" :key="perosn.id" class="bg-grey-1 q-mb-xs">
            <q-card-section class="q-pa-xs">
              <div class="row text-caption">
                <div class="col-5">
                  Nombre: <b>{{perosn.nombre}}</b>
                </div>
                <div class="col-4">
                  Cargo: <b>{{perosn.cargo}}</b>
                </div>
                <div class="col-3 row items-center">
                  DNI: <b>{{perosn.dni}}</b>
                  <q-space />
                  <q-btn size="10px" flat dense icon="o_edit" no-caps
                         color="orange" :loading="loading"
                         @click="person = perosn; personDialog = true; personOption = 'edit'">
                    <q-tooltip>
                      Editar
                    </q-tooltip>
                  </q-btn>
                  <q-btn size="10px" flat dense icon="cancel" no-caps
                         color="grey" :loading="loading"
                         @click="deletePerson(perosn.id)">
                    <q-tooltip>
                      Eliminar
                    </q-tooltip>
                  </q-btn>
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
                           label="Agregar Telefono"
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
                           label="Agregar Email"
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
        </div>
        <q-dialog v-model="personDialog">
          <q-card class="q-pa-xs" style="max-width: 400px">
            <q-card-section class="q-py-none row items-center">
              <div class="text-h6">{{personOption == 'create' ? 'Crear' : 'Editar'}} Persona</div>
              <q-space />
              <q-btn flat dense icon="cancel" v-close-popup />
            </q-card-section>
            <q-card-section class="q-py-none">
              <q-form @submit="personSubmit">
                <div class="row">
                  <div class="col-12">
                    <q-input dense outlined v-model="person.nombre" label="Nombre"
                             :rules="[val => !!val || 'El nombre es requerido']"/>
                  </div>
                  <div class="col-12">
                    <q-input dense outlined v-model="person.cargo" label="Cargo"
                              :rules="[val => !!val || 'El cargo es requerido']"/>
                  </div>
                  <div class="col-12">
                    <q-input dense outlined v-model="person.dni" label="DNI" hint=""/>
                  </div>
                  <div class="col-12">
                    <q-input dense outlined v-model="person.phone" label="Telefono" hint=""/>
                  </div>
                  <div class="col-12">
                    <q-input dense outlined v-model="person.email" label="email" hint=""/>
                  </div>
                </div>
                <q-card-actions align="right">
                  <q-btn dense no-caps label="Cancelar" v-close-popup color="red" :loading="loading"/>
                  <q-btn dense no-caps :loading="loading" type="submit"
                         :label="personOption == 'create' ? 'Crear' : 'Editar'"
                         :color="personOption == 'create' ? 'blue' : 'orange'" />
                </q-card-actions>
              </q-form>
            </q-card-section>
          </q-card>
        </q-dialog>
      </div>
</template>
<script>
export default {
  name: 'PersonComponent',
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
      loading: false,
      personDialog: false,
      personOption: '',
      person: {
        nombre: '',
        cargo: '',
        dni: ''
      }
    }
  },
  methods: {
    deletePerson (id) {
      this.$q.dialog({
        title: 'Eliminar',
        message: '¿Desea eliminar la persona?',
        cancel: true,
        persistent: true
      }).onOk(() => {
        this.loading = true
        this.$axios.delete('persons/' + id)
          .then(response => {
            this.$emit('empresaSearch', this.empresa)
          }).catch(error => {
            this.$alert.error(error)
          }).finally(() => {
            this.loading = false
          })
      })
    },
    personSubmit () {
      this.loading = true
      if (this.personOption === 'create') {
        this.$axios.post('persons', {
          nombre: this.person.nombre,
          cargo: this.person.cargo,
          dni: this.person.dni,
          empresa_id: this.empresa.id,
          phone: this.person.phone,
          email: this.person.email
        }).then(response => {
          this.$emit('empresaSearch', this.empresa)
          this.personDialog = false
        }).catch(error => {
          this.$alert.error(error)
        }).finally(() => {
          this.loading = false
        })
      } else {
        this.$axios.put('persons/' + this.person.id, {
          nombre: this.person.nombre,
          cargo: this.person.cargo,
          dni: this.person.dni
        }).then(response => {
          this.$emit('empresaSearch', this.empresa)
          this.personDialog = false
        }).catch(error => {
          this.$alert.error(error)
        }).finally(() => {
          this.loading = false
        })
      }
    },
    personDialogClick () {
      this.personDialog = true
      this.personOption = 'create'
      this.person = {
        nombre: '',
        cargo: '',
        dni: ''
      }
    },
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
