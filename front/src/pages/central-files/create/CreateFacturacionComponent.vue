<template>
  <div class="row q-pl-xs">
    <div class="col-12 row items-center">
      <div class="text-bold">FACTURACION</div>
      <q-space />
      <q-btn :loading="loading" round dense flat icon="add_circle_outline" color="blue" @click="facturacionDialogClick">
        <q-tooltip>Crear Facturacion</q-tooltip>
      </q-btn>
    </div>
    <div class="col-12">
      <q-card v-for="d in facturacion" :key="d.id" class="bg-grey-1 q-mb-xs">
        <q-card-section class="q-pa-xs">
          <div class="row text-caption">
            <div class="col-12 row items-center">
              CUIT/CUIL: <b>{{d.cuit}}</b>
              <q-space />
              <q-btn size="10px" flat dense icon="o_edit" no-caps
                     color="orange" :loading="loading"
                     @click="facturacionDato = d; facturacionDialog = true; facturacionOption = 'edit'">
                <q-tooltip>
                  Editar
                </q-tooltip>
              </q-btn>
              <q-btn size="10px" flat dense icon="cancel" no-caps
                     color="grey" :loading="loading"
                     @click="deleteFacturacion(d.id)">
                <q-tooltip>
                  Eliminar
                </q-tooltip>
              </q-btn>
            </div>
            <div class="col-12">
              Condicional: <b>{{d.condicional}}</b>
            </div>
            <div class="col-12">
              Razon Social: <b>{{d.razonSocial}}</b>
            </div>
            <div class="col-12">
              Comentario: <b>{{d.comentario}}</b>
            </div>
<!--            <pre>{{facturacion}}</pre>-->
          </div>
        </q-card-section>
      </q-card>
    </div>
    <q-dialog v-model="facturacionDialog">
      <q-card class="q-pa-xs" style="max-width: 400px">
        <q-card-section class="q-py-none row items-center">
          <div class="text-h6">{{facturacionOption === 'create' ? 'Crear' : 'Editar'}} Facturacion</div>
          <q-space />
          <q-btn flat dense icon="cancel" v-close-popup />
        </q-card-section>
        <q-card-section class="q-py-none">
          <q-form @submit="facturacionSubmit">
            <div class="row">
              <div class="col-12">
                <q-input dense outlined v-model="facturacionDato.cuit" label="CUIT/CUIL"
                         :rules="[val => !!val || 'El CUIT/CUIL es requerido']"/>
              </div>
              <div class="col-12">
                <q-input dense outlined v-model="facturacionDato.condicional" label="Condicional"
                         :rules="[val => !!val || 'La condicional es requerida']"/>
              </div>
              <div class="col-12">
                <q-input dense outlined v-model="facturacionDato.razonSocial" label="Razon Social"
                         :rules="[val => !!val || 'La razon social es requerida']"/>
              </div>
              <div class="col-12">
                <q-input dense outlined v-model="facturacionDato.comentario" label="Comentario"
                          :rules="[val => !!val || 'El comentario es requerido']"/>
              </div>
            </div>
            <q-card-actions align="right">
              <q-btn dense no-caps label="Cancelar" v-close-popup color="red" :loading="loading"/>
              <q-btn dense no-caps :loading="loading" type="submit"
                     :label="facturacionOption === 'create' ? 'Crear' : 'Editar'"
                     :color="facturacionOption === 'create' ? 'blue' : 'orange'" />
            </q-card-actions>
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>
  </div>
</template>
<script>
export default {
  name: 'CreateFacturacionComponent',
  props: {
    empresa: {
      type: Object,
      default: () => {}
    },
    facturacion: {
      type: Array,
      default: () => []
    }
  },
  data () {
    return {
      loading: false,
      facturacionDialog: false,
      facturacionOption: '',
      facturacionDato: {}
    }
  },
  methods: {
    deleteFacturacion (id) {
      this.$q.dialog({
        title: 'Eliminar',
        message: '¿Desea eliminar la facturacion?',
        cancel: true,
        persistent: true
      }).onOk(() => {
        this.loading = true
        this.$axios.delete('facturacion/' + id)
          .then(response => {
            this.$emit('empresaSearch', this.empresa)
          }).catch(error => {
            this.$alert.error(error)
          }).finally(() => {
            this.loading = false
          })
      })
    },
    facturacionSubmit () {
      this.loading = true
      if (this.facturacionOption === 'create') {
        this.$axios.post('facturacion', {
          ...this.facturacionDato,
          empresa_id: this.empresa.id
        }).then(response => {
          this.$emit('empresaSearch', this.empresa)
          this.facturacionDialog = false
        }).catch(error => {
          this.$alert.error(error)
        }).finally(() => {
          this.loading = false
        })
      } else {
        this.$axios.put('facturacion/' + this.facturacionDato.id, {
          ...this.facturacionDato,
          empresa_id: this.empresa.id
        }).then(response => {
          this.$emit('empresaSearch', this.empresa)
          this.facturacionDialog = false
        }).catch(error => {
          this.$alert.error(error)
        }).finally(() => {
          this.loading = false
        })
      }
    },
    facturacionDialogClick () {
      this.facturacionDialog = true
      this.facturacionOption = 'create'
      this.facturacionDato = {}
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
    addPhone (facturacionId) {
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
          facturacion_id: facturacionId
        }).then(response => {
          this.$emit('empresaSearch', this.empresa)
        }).catch(error => {
          this.$alert.error(error)
        }).finally(() => {
          this.loading = false
        })
      })
    },
    addEmail (facturacionId) {
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
          facturacion_id: facturacionId
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
