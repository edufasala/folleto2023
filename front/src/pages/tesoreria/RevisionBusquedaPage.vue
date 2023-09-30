<script>
import { date } from 'quasar'

export default {
  name: 'RevisionBusquedaPage',
  data () {
    return {
      loading: false,
      pago: {},
      pagos: [],
      pedidos: [],
      users: [],
      user: '',
      allSelected: false,
      fechaDesde: date.formatDate(new Date(), 'YYYY-MM-DD'),
      fechaHasta: date.formatDate(new Date(), 'YYYY-MM-DD'),
      metodoPago: ''
    }
  },
  mounted () {
    this.getBuqueda()
    this.getUsers()
  },
  methods: {
    getUsers () {
      this.loading = true
      this.$axios.get('users')
        .then(response => {
          this.users = []
          response.data.forEach(user => {
            this.users.push(user)
          })
        }).catch(error => {
          this.$alert(error.response.data.message)
        }).finally(() => {
          this.loading = false
        })
    },
    imprimir () {
      console.log('imprimir')
    },
    getBuqueda () {
      this.loading = true
      this.$axios.get(`busquedaPagos?fechaDesde=${this.fechaDesde}&fechaHasta=${this.fechaHasta}
      &metodoPago=${this.metodoPago}&user=${this.user.id}`)
        .then(response => {
          this.pagos = []
          response.data.forEach(pago => {
            pago.selected = false
            this.pagos.push(pago)
          })
        }).catch(error => {
          this.$alert(error.response.data.message)
        }).finally(() => {
          this.loading = false
        })
    }
  },
  computed: {
    totalSinRevisar () {
      let total = 0
      this.pagos.forEach(pago => {
        if (pago.estado === 'Pendiente') {
          total += pago.monto
        }
      })
      return total
    },
    seleccionado () {
      let seleccionado = 0
      this.pagos.forEach(pago => {
        if (pago.selected) {
          seleccionado += pago.monto
        }
      })
      return seleccionado
    }
  }
}
</script>

<template>
  <div>
    <div class="row items-center q-pa-xs">
      <span class="bg-grey-4 q-pa-xs text-subtitle1 text-bold">
        <div class="flex flex-center">
          Desde <q-input type="date" v-model="fechaDesde" dense outlined class="q-ma-xs" style="width: 150px"/>
          Usuario <q-select v-model="user" dense outlined :options="users" option-value="id"
                            option-label="name" class="q-ma-xs" style="width: 150px"
        />
        </div>
        <div class="flex flex-center">
          Hasta <q-input type="date" v-model="fechaHasta" dense outlined class="q-ma-xs" style="width: 150px"/>
          M. PAGO <q-select v-model="metodoPago" dense outlined :options="$metodoPago" class="q-ma-xs" style="width: 150px"/>
        </div>
      </span>
      <q-btn :loading="loading" color="blue" size="15px" @click="getBuqueda" class="q-ma-xs" icon="search"/>
      <q-btn :loading="loading" color="blue" size="15px" @click="imprimir" class="q-ma-xs" icon="print"/>
      <q-space/>
      <div>
        Total <span class="text-blue">${{totalSinRevisar}}</span>
      </div>
    </div>
    <q-markup-table>
      <thead>
      <tr class="bg-black text-white">
        <th class="text-left">Fecha</th>
        <th class="text-left">Estado</th>
        <th class="text-left">Nº CI.</th>
        <th class="text-left">Nombre</th>
        <th class="text-left">Medio</th>
        <th class="text-left">Monto</th>
        <th class="text-left">Facturado</th>
        <th class="text-left">Usuario</th>
        <th class="text-left">Comentario</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="pago in pagos" :key="pago.id">
        <td class="text-left">{{pago.fecha}}</td>
        <td class="text-left">
          <q-badge :color="pago.estado==='Pendiente'?'orange':pago.estado==='Aceptado'?'green':'red'">
            {{pago.estado}}
          </q-badge>
        </td>
        <td class="text-left">{{pago.dni}}</td>
        <td class="text-left">{{pago.nombre}}</td>
        <td class="text-left">{{pago.metodoPago}}</td>
        <td class="text-left">{{$filters.currency(pago.monto)}}</td>
        <td class="text-left">
          <q-badge :color="pago.facturado?'green':'red'">
            {{pago.facturado}}
          </q-badge>
        </td>
        <td class="text-left">{{pago.user.name}}</td>
        <td class="text-left">{{pago.comentario}}</td>
      </tr>
      </tbody>
    </q-markup-table>
  </div>
</template>

<style scoped>

</style>
