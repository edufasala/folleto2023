<template>
  <div class="row q-pl-xs">
    <div class="col-12 row items-center">
      <div>Total: <span class="text-bold text-red-7">{{notes.length}}</span></div>
      <q-space />
      <q-btn :loading="loading" round dense flat icon="add_circle_outline" color="blue" @click="noteDialogClick">
        <q-tooltip>Crear</q-tooltip>
      </q-btn>
    </div>
    <div class="col-12">
      <q-card v-for="note in notes" :key="note.id" :class="`bg-${note.color}-2 q-mb-md`">
        <q-card-section class="q-pa-xs">
          <div class="row text-caption">
            <div class="col-12 row items-center">
              <b class="q-pr-md">{{$filters.dateDmY(note.date)}} </b>
              <span class="text-grey">{{note.user.name}}</span>
              <q-space />
              <q-btn size="10px" flat dense icon="o_edit" no-caps
                     color="orange" :loading="loading"
                     @click="noteClickUpdate(note)">
                <q-tooltip>
                  Editar
                </q-tooltip>
              </q-btn>
              <q-btn size="10px" flat dense icon="cancel" no-caps
                     color="grey" :loading="loading"
                     @click="deleteNota(note.id)">
                <q-tooltip>
                  Eliminar
                </q-tooltip>
              </q-btn>
            </div>
            <div class="col-12">
              {{note.body}}
            </div>
<!--            <div class="col-12">-->
<!--              <pre>{{note}}</pre>-->
<!--            </div>-->
          </div>
        </q-card-section>
      </q-card>
    </div>
    <q-dialog v-model="noteDialog">
      <q-card class="q-pa-xs" style="max-width: 400px">
        <q-card-section class="q-py-none row items-center">
          <div class="text-h6">{{noteOption === 'create' ? 'Crear' : 'Editar'}} Nota</div>
          <q-space />
          <q-btn flat dense icon="cancel" v-close-popup />
        </q-card-section>
        <q-card-section class="q-py-none">
          <q-form @submit="noteSubmit">
            <div class="row">
              <div class="col-12">
                <q-input dense outlined v-model="noteDato.date" label="Fecha" type="date"
                         :rules="[val => !!val || 'La fecha es requerida']"/>
              </div>
              <div class="col-12">
                <q-select dense outlined v-model="noteDato.color" label="Color" :options="['white', 'red']"
                          :rules="[val => !!val || 'El color es requerido']"/>
              </div>
              <div class="col-12">
                <q-input dense outlined v-model="noteDato.body" label="Nota" type="textarea"
                         :rules="[val => !!val || 'La nota es requerida']"/>
              </div>
            </div>
            <q-card-actions align="right">
              <q-btn dense no-caps label="Cancelar" v-close-popup color="red" :loading="loading"/>
              <q-btn dense no-caps :loading="loading" type="submit"
                     :label="noteOption === 'create' ? 'Crear' : 'Editar'"
                     :color="noteOption === 'create' ? 'blue' : 'orange'" />
            </q-card-actions>
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>
  </div>
</template>
<script>
import { date } from 'quasar'

export default {
  name: 'NotasComponent',
  props: {
    empresa: {
      type: Object,
      required: true
    },
    notes: {
      type: Array,
      required: true
    }
  },
  data () {
    return {
      loading: false,
      noteDialog: false,
      noteOption: '',
      noteDato: {}
    }
  },
  methods: {
    noteClickUpdate (note) {
      this.noteDialog = true
      this.noteOption = 'update'
      this.noteDato = {
        ...note
      }
    },
    deleteNota (id) {
      this.$q.dialog({
        title: 'Eliminar',
        message: '¿Desea eliminar la note?',
        cancel: true,
        persistent: true
      }).onOk(() => {
        this.loading = true
        this.$axios.delete('notes/' + id)
          .then(response => {
            this.$emit('empresaSearch', this.empresa)
          }).catch(error => {
            this.$alert.error(error)
          }).finally(() => {
            this.loading = false
          })
      })
    },
    noteSubmit () {
      this.loading = true
      if (this.noteOption === 'create') {
        this.$axios.post('notes', {
          ...this.noteDato,
          empresa_id: this.empresa.id
        }).then(response => {
          this.$emit('empresaSearch', this.empresa)
          this.noteDialog = false
        }).catch(error => {
          this.$alert.error(error)
        }).finally(() => {
          this.loading = false
        })
      } else {
        this.$axios.put('notes/' + this.noteDato.id, {
          ...this.noteDato,
          empresa_id: this.empresa.id
        }).then(response => {
          this.$emit('empresaSearch', this.empresa)
          this.noteDialog = false
        }).catch(error => {
          this.$alert.error(error)
        }).finally(() => {
          this.loading = false
        })
      }
    },
    noteDialogClick () {
      this.noteDialog = true
      this.noteOption = 'create'
      this.noteDato = {
        date: date.formatDate(new Date(), 'YYYY-MM-DD'),
        color: 'white'
      }
    }
  }
}
</script>
