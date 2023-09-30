<template>
<q-page class="q-pa-xs bg-grey-3">
  <div class="row">
    <div class="col-12 text-uppercase luckiest text-h2 text-center">
      TESORERIA
    </div>
    <div class="col-12">
      <q-btn :loading="loading" :color="tab==='revisionPago'?'white':'grey'"
             label="REVISION DE PAGOS" no-caps text-color="black"
             :class="`text-bold w-200`"
             size="15px" @click="tab = 'revisionPago'"/>
      <q-btn :loading="loading" :color="tab==='revisionPedido'?'white':'grey'"
             label="REVISION DE PEDIDOS" no-caps text-color="black"
             :class="`text-bold w-200`"
             size="15px" @click="tab = 'revisionPedido'"/>
      <q-btn :loading="loading" :color="tab==='busqueda'?'white':'grey'"
             label="BUSQUEDA" no-caps text-color="black"
             :class="`text-bold w-200`"
             size="15px" @click="tab = 'busqueda'"/>
      <q-card>
        <q-tab-panels v-model="tab" animated>
          <q-tab-panel name="revisionPago">
            <div class="row items-center q-pa-xs">
              <span class="bg-grey-4 q-pa-xs text-subtitle1 text-bold">
                Selecionado <span class="text-blue">${{seleccionado}}</span>
                <q-btn :loading="loading" class="q-ml-lg" label="Aceptar" color="green" @click="aceptar" no-caps/>
                <q-btn :loading="loading" class="q-ml-sm" label="Rechazar" color="red" @click="rechazar" no-caps/>
              </span>
              <q-space/>
              <div>
                Total sin revisar <span class="text-blue">${{totalSinRevisar}}</span>
              </div>
            </div>
            <q-markup-table>
              <thead>
              <tr class="bg-black text-white">
                <th class="text-left"><q-checkbox v-model="allSelected" dark label="All" @update:modelValue="v => {pagos.forEach(pago => pago.selected = v)}"/></th>
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
                  <td class="text-left"><q-checkbox v-model="pago.selected"/></td>
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
          </q-tab-panel>
          <q-tab-panel name="revisionPedido">
            notas
          </q-tab-panel>
          <q-tab-panel name="busqueda">
            pedido
          </q-tab-panel>
        </q-tab-panels>
      </q-card>
    </div>
  </div>
</q-page>
</template>
<script>
export default {
  name: 'IndexTesoreriaPage',
  data () {
    return {
      tab: 'revisionPago',
      loading: false,
      pago: {},
      allSelected: false,
      pagos: [],
      pedidos: []
    }
  },
  mounted () {
    this.getPagos()
  },
  methods: {
    aceptar () {
      this.loading = true
      const pagos = []
      this.pagos.forEach(pago => {
        if (pago.selected) {
          pagos.push(pago)
        }
      })
      this.$axios.post('aceptarEstadoPago', {
        pagos
      })
        .then(response => {
          this.getPagos()
        }).catch(error => {
          this.$alert(error.response.data.message)
        }).finally(() => {
          this.loading = false
        })
    },
    rechazar () {
      this.loading = true
      const pagos = []
      this.pagos.forEach(pago => {
        if (pago.selected) {
          pagos.push(pago)
        }
      })
      this.$axios.post('rechazarEstadoPago', {
        pagos
      })
        .then(response => {
          this.getPagos()
        }).catch(error => {
          this.$alert(error.response.data.message)
        }).finally(() => {
          this.loading = false
        })
    },
    getPagos () {
      this.loading = true
      this.$axios.get('pagos')
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
