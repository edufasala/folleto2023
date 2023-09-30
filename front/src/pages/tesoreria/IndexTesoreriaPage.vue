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
            <RevisionPagoPage/>
          </q-tab-panel>
          <q-tab-panel name="revisionPedido">
            <RevisionPedidoPage/>
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
import RevisionPagoPage from 'pages/tesoreria/RevisionPagoPage.vue'
import RevisionPedidoPage from 'pages/tesoreria/RevisionPedidoPage.vue'

export default {
  name: 'IndexTesoreriaPage',
  components: { RevisionPedidoPage, RevisionPagoPage },
  data () {
    return {
      tab: 'revisionPedido',
      loading: false
    }
  }
}
</script>
