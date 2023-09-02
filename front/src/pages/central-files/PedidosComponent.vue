<template>
  <div class="row q-pl-xs">
    <div class="col-12 row items-center q-mb-md">
      <div>
        <div>Proxima Compra estimada: <span class="text-bold">{{proximaCompra}}</span></div>
        <div>Cantidad de pedidos: <span class="text-bold">{{pedidos.length}}</span></div>
      </div>
      <q-space />
      <div>
        <div class="flex flex-center">
          <q-icon name="calendar_today" size="25px" color="grey-8" />
          <span class="text-bold text-bold text-blue">{{promedioDiasPedidos}}</span>
        </div>
        <div class="text-caption">
          Regularidad en dias
        </div>
      </div>
      <q-btn :loading="loading" dense  label="Hacer pedido"
             no-caps color="blue" @click="pedidoDialogClick" class="text-bold">
        <q-tooltip>Crear Pedido</q-tooltip>
      </q-btn>
    </div>
    <div class="col-12">
      <q-card v-for="pedido in pedidos" :key="pedido.id" :class="`bg-${pedido.color}-2 q-mb-md`">
        <q-card-section class="q-pa-xs">
          <div class="row text-caption">
            <div class="col-12 row items-center">
              <b class="q-pr-md">{{$filters.dateDmY(pedido.fecha)}} </b>
              <span class="text-grey">{{pedido.user.name}}</span>
              <q-space />
              <q-btn size="10px" flat dense icon="o_edit" no-caps
                     color="orange" :loading="loading"
                     @click="pedidoClickUpdate(pedido)">
                <q-tooltip>
                  Editar
                </q-tooltip>
              </q-btn>
              <q-btn size="10px" flat dense icon="cancel" no-caps
                     color="grey" :loading="loading"
                     @click="deleteNota(pedido.id)">
                <q-tooltip>
                  Eliminar
                </q-tooltip>
              </q-btn>
            </div>
            <div class="col-12">
              {{pedido.body}}
            </div>
            <div class="col-12">
              <pre>{{pedido}}</pre>
            </div>
          </div>
        </q-card-section>
      </q-card>
    </div>
    <q-dialog v-model="pedidoDialog">
      <q-card class="q-pa-xs" style="max-width: 400px">
        <q-card-section class="q-py-none row items-center">
          <div class="text-h6">{{pedidoOption === 'create' ? 'Crear' : 'Editar'}} Nota</div>
          <q-space />
          <q-btn flat dense icon="cancel" v-close-popup />
        </q-card-section>
        <q-card-section class="q-py-none">
          <q-form @submit="pedidoSubmit">
            <div class="row">
              <div class="col-12">
                <q-input dense outlined v-model="pedidoDato.date" label="Fecha" type="date"
                         :rules="[val => !!val || 'La fecha es requerida']"/>
              </div>
              <div class="col-12">
                <q-select dense outlined v-model="pedidoDato.color" label="Color" :options="['white', 'red']"
                          :rules="[val => !!val || 'El color es requerido']"/>
              </div>
              <div class="col-12">
                <q-input dense outlined v-model="pedidoDato.body" label="Nota" type="textarea"
                         :rules="[val => !!val || 'La nota es requerida']"/>
              </div>
            </div>
            <q-card-actions align="right">
              <q-btn dense no-caps label="Cancelar" v-close-popup color="red" :loading="loading"/>
              <q-btn dense no-caps :loading="loading" type="submit"
                     :label="pedidoOption === 'create' ? 'Crear' : 'Editar'"
                     :color="pedidoOption === 'create' ? 'blue' : 'orange'" />
            </q-card-actions>
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>
  </div>
</template>
<script>
import { date } from 'quasar'
import moment from 'moment'

export default {
  name: 'PedidosComponent',
  props: {
    empresa: {
      type: Object,
      required: true
    },
    pedidos: {
      type: Array,
      required: true
    }
  },
  data () {
    return {
      loading: false,
      pedidoDialog: false,
      pedidoOption: '',
      pedidoDato: {},
      pedidosDatos: this.pedidos
    }
  },
  methods: {
    pedidoClickUpdate (pedido) {
      this.pedidoDialog = true
      this.pedidoOption = 'update'
      this.pedidoDato = {
        ...pedido
      }
    },
    deleteNota (id) {
      this.$q.dialog({
        title: 'Eliminar',
        message: '¿Desea eliminar la pedido?',
        cancel: true,
        persistent: true
      }).onOk(() => {
        this.loading = true
        this.$axios.delete('pedidos/' + id)
          .then(response => {
            this.$emit('empresaSearch', this.empresa)
          }).catch(error => {
            this.$alert.error(error)
          }).finally(() => {
            this.loading = false
          })
      })
    },
    pedidoSubmit () {
      this.loading = true
      if (this.pedidoOption === 'create') {
        this.$axios.post('pedidos', {
          ...this.pedidoDato,
          empresa_id: this.empresa.id
        }).then(response => {
          this.$emit('empresaSearch', this.empresa)
          this.pedidoDialog = false
        }).catch(error => {
          this.$alert.error(error)
        }).finally(() => {
          this.loading = false
        })
      } else {
        this.$axios.put('pedidos/' + this.pedidoDato.id, {
          ...this.pedidoDato,
          empresa_id: this.empresa.id
        }).then(response => {
          this.$emit('empresaSearch', this.empresa)
          this.pedidoDialog = false
        }).catch(error => {
          this.$alert.error(error)
        }).finally(() => {
          this.loading = false
        })
      }
    },
    pedidoDialogClick () {
      this.pedidoDialog = true
      this.pedidoOption = 'create'
      this.pedidoDato = {
        date: date.formatDate(new Date(), 'YYYY-MM-DD'),
        color: 'white'
      }
    }
  },
  computed: {
    promedioDiasPedidos () {
      // eslint-disable-next-line vue/no-side-effects-in-computed-properties
      const avg = this.pedidosDatos.reduce((a, b) => {
        return a + b.diasCompra
      }, 0) / this.pedidosDatos.length
      return avg.toFixed(2)
    },
    proximaCompra () {
      // eslint-disable-next-line vue/no-side-effects-in-computed-properties
      const ordenarPedidos = this.pedidosDatos.sort((a, b) => {
        return new Date(a.fecha) - new Date(b.fecha)
      })
      if (ordenarPedidos.length === 0) {
        return 'No hay pedidos'
      }
      const compraFinal = ordenarPedidos[ordenarPedidos.length - 1]
      return moment(compraFinal.fecha).format('DD/MM/YYYY')
    }
  }
}
</script>
