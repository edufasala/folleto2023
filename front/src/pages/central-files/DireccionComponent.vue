<template>
  <div class="row q-pl-xs">
    <div class="col-12 row items-center">
      <div class="text-bold">DIRECCIONES</div>
      <q-space />
      <q-btn :loading="loading" round dense flat icon="add_circle_outline" color="blue" @click="direccionDialogClick">
        <q-tooltip>Crear</q-tooltip>
      </q-btn>
    </div>
    <div class="col-12">
      <q-card v-for="d in direccion" :key="d.id" flat bordered class="bg-grey-3 q-mb-xs">
        <q-card-section class="q-pa-xs">
          <div class="row text-caption">
            <div class="col-12 row items-center">
              Nombre: <b>{{d.direccion}}</b>
              <q-space />
              <q-btn size="10px" flat dense icon="o_edit" no-caps
                     color="orange" :loading="loading"
                     @click="direccionDato = d; direccionDialog = true; direccionOption = 'edit'">
                <q-tooltip>
                  Editar
                </q-tooltip>
              </q-btn>
              <q-btn size="10px" flat dense icon="cancel" no-caps
                     color="grey" :loading="loading"
                     @click="deleteDirecion(d.id)">
                <q-tooltip>
                  Eliminar
                </q-tooltip>
              </q-btn>
            </div>
            <div class="col-12">
              C. Postal: <b>{{d.codigoPostal}}</b>
            </div>
            <div class="col-12 row items-center">
              Localidad: <b>{{d.localidad}}</b>
            </div>
            <div class="col-12">
              <template v-if="d.phone_direccions.length>0">
                <div v-for="phone in d.phone_direccions" :key="phone.id" class="row">
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
                         @click="addPhone(d.id)"
                         :loading="loading"
                         v-if="phone.id == d.phone_direccions[d.phone_direccions.length - 1].id"
                         no-caps color="blue">
                    <q-tooltip>
                      Agregar Telefono
                    </q-tooltip>
                  </q-btn>
                  <q-btn v-else size="10px" flat dense icon=""/>
                </div>
              </template>
              <template v-else>
<!--                <span class="text-overline">Agregar Telefono</span>-->
                <q-btn size="10px" flat dense icon="add_circle_outline"
                       @click="addPhone(d.id)"
                       :loading="loading"
                       no-caps color="blue">
                  <q-tooltip>
                    Agregar Telefono
                  </q-tooltip>
                </q-btn>
<!--              </template>-->
<!--            </div>-->
<!--            <div class="col-7">-->
<!--              <template v-if="direccion.email.length>0">-->
<!--                <div v-for="email in direccion.email" :key="email.id" class="row items-center">-->
<!--                  Email: <b>{{email.email}}</b>-->
<!--                  <q-space />-->
<!--                  <q-checkbox dense v-model="email.status" left-label :label="email.status"-->
<!--                              false-value="No" true-value="Si" :disable="loading" @update:model-value="updateEmailStatus(email)"/>-->
<!--                  <q-btn size="10px" flat dense icon="cancel" no-caps-->
<!--                         color="grey" :loading="loading" @click="deleteEmail(email.id)">-->
<!--                    <q-tooltip>-->
<!--                      Eliminar Email-->
<!--                    </q-tooltip>-->
<!--                  </q-btn>-->
<!--                  <q-btn size="10px" flat dense icon="add_circle_outline" no-caps-->
<!--                         color="blue" :loading="loading" v-if="email.id == direccion.email[direccion.email.length - 1].id"-->
<!--                         @click="addEmail(direccion.id)">-->
<!--                    <q-tooltip>-->
<!--                      Agregar Email-->
<!--                    </q-tooltip>-->
<!--                  </q-btn>-->
<!--                  <q-btn v-else size="10px" flat dense icon=""/>-->
<!--                </div>-->
<!--              </template>-->
<!--              <template v-else>-->
<!--                <q-btn size="10px" flat dense icon="add_circle_outline" no-caps-->
<!--                       color="blue" :loading="loading" @click="addEmail(direccion.id)">-->
<!--                  <q-tooltip>-->
<!--                    Agregar Email-->
<!--                  </q-tooltip>-->
<!--                </q-btn>-->
              </template>
            </div>
          </div>
        </q-card-section>
      </q-card>
    </div>
    <q-dialog v-model="direccionDialog">
      <q-card class="q-pa-xs" style="max-width: 400px">
        <q-card-section class="q-py-none row items-center">
          <div class="text-h6">{{direccionOption === 'create' ? 'Crear' : 'Editar'}} Direcion</div>
          <q-space />
          <q-btn flat dense icon="cancel" v-close-popup />
        </q-card-section>
        <q-card-section class="q-py-none">
          <q-form @submit="direccionSubmit">
            <div class="row">
              <div class="col-12">
                <q-input dense outlined v-model="direccionDato.direccion" label="Direccion"
                         :rules="[val => !!val || 'La direccion es requerida']"/>
              </div>
              <div class="col-12">
                <q-input dense outlined v-model="direccionDato.codigoPostal" label="Codigo Postal"
                          :rules="[val => !!val || 'El codigo postal es requerido']"/>
              </div>
              <div class="col-12">
                <q-input dense outlined v-model="direccionDato.localidad" label="Localidad"
                         :rules="[val => !!val || 'La localidad es requerida']"/>
              </div>
            </div>
            <q-card-actions align="right">
              <q-btn dense no-caps label="Cancelar" v-close-popup color="red" :loading="loading"/>
              <q-btn dense no-caps :loading="loading" type="submit"
                     :label="direccionOption === 'create' ? 'Crear' : 'Editar'"
                     :color="direccionOption === 'create' ? 'blue' : 'orange'" />
            </q-card-actions>
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>
  </div>
</template>
<script>
export default {
  name: 'DirecionComponent',
  props: {
    empresa: {
      type: Object,
      default: () => {}
    },
    direccion: {
      type: Array,
      default: () => []
    }
  },
  data () {
    return {
      loading: false,
      direccionDialog: false,
      direccionOption: '',
      direccionDato: {}
    }
  },
  methods: {
    deleteDirecion (id) {
      this.$q.dialog({
        title: 'Eliminar',
        message: '¿Desea eliminar la direcciona?',
        cancel: true,
        persistent: true
      }).onOk(() => {
        this.loading = true
        this.$axios.delete('direccion/' + id)
          .then(response => {
            this.$emit('empresaSearch', this.empresa)
          }).catch(error => {
            this.$alert.error(error)
          }).finally(() => {
            this.loading = false
          })
      })
    },
    direccionSubmit () {
      this.loading = true
      if (this.direccionOption === 'create') {
        this.$axios.post('direccion', {
          direccion: this.direccionDato.direccion,
          codigoPostal: this.direccionDato.codigoPostal,
          localidad: this.direccionDato.localidad,
          empresa_id: this.empresa.id
        }).then(response => {
          this.$emit('empresaSearch', this.empresa)
          this.direccionDialog = false
        }).catch(error => {
          this.$alert.error(error)
        }).finally(() => {
          this.loading = false
        })
      } else {
        this.$axios.put('direccion/' + this.direccionDato.id, {
          direccion: this.direccionDato.direccion,
          codigoPostal: this.direccionDato.codigoPostal,
          localidad: this.direccionDato.localidad,
          empresa_id: this.empresa.id
        }).then(response => {
          this.$emit('empresaSearch', this.empresa)
          this.direccionDialog = false
        }).catch(error => {
          this.$alert.error(error)
        }).finally(() => {
          this.loading = false
        })
      }
    },
    direccionDialogClick () {
      this.direccionDialog = true
      this.direccionOption = 'create'
      this.direccionDato = {}
    },
    deletePhone (id) {
      this.$q.dialog({
        title: 'Eliminar',
        message: '¿Desea eliminar el telefono?',
        cancel: true,
        persistent: true
      }).onOk(() => {
        this.loading = true
        this.$axios.delete('phoneDireccions/' + id)
          .then(response => {
            this.$emit('empresaSearch', this.empresa)
          }).catch(error => {
            this.$alert.error(error)
          }).finally(() => {
            this.loading = false
          })
      })
    },
    addPhone (direccionId) {
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
        this.$axios.post('phoneDireccions', {
          phone: data,
          direccion_id: direccionId
        }).then(response => {
          this.$emit('empresaSearch', this.empresa)
        }).catch(error => {
          this.$alert.error(error)
        }).finally(() => {
          this.loading = false
        })
      })
    },
    addEmail (direccionId) {
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
          direccion_id: direccionId
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
