<template>
<q-page class="q-pa-xs bg-grey-3">
  <div class="row">
    <div class="col-12 text-uppercase luckiest text-h2 text-center">
      PRECIOS
    </div>
    <div class="col-12">
      <q-btn :loading="loading" :color="tab==='sinPliego'?'white':'grey'"
             no-caps text-color="black"
             :class="`text-bold w-50`"
             size="15px" @click="tab = 'sinPliego'">
        PRECIOS DE PRODUCTOS o SERVICIOS &nbsp;<span class="text-orange"> SIN PLIEGO</span>
      </q-btn>
      <q-btn :loading="loading" :color="tab==='conPliego'?'white':'grey'"
             no-caps text-color="black"
             :class="`text-bold w-50`"
             size="15px" @click="tab = 'conPliego'">
        PRECIOS DE PRODUCTOS &nbsp;<span class="text-yellow-6"> CON PLIEGO</span>
      </q-btn>
      <q-btn :loading="loading" :color="tab==='diseno'?'white':'grey'"
             label="PRECIO DE DISEÑOS" no-caps text-color="black"
             :class="`text-bold w-50`"
             size="15px" @click="tab = 'diseno'"/>
      <q-btn :loading="loading" :color="tab==='terminacion'?'white':'grey'"
             label="TERMINACIONES" no-caps text-color="black"
             :class="`text-bold w-50`"
             size="15px" @click="tab = 'terminacion'"/>
<!--      {{tab}}-->
      <q-card>
        <q-tab-panels v-model="tab" animated>
          <q-tab-panel name="sinPliego">
            <SinPliegoPage/>
          </q-tab-panel>
          <q-tab-panel name="conPliego">
            <ConPliegoPage/>
          </q-tab-panel>
          <q-tab-panel name="diseno">
            <DisenoPage/>
          </q-tab-panel>
<!--          <q-tab-panel name="terminacion">-->
<!--            terminacion-->
<!--          </q-tab-panel>-->
        </q-tab-panels>
      </q-card>
    </div>
  </div>
</q-page>
</template>
<script>
import SinPliegoPage from 'pages/precios/SinPliegoPage.vue'
import ConPliegoPage from 'pages/precios/ConPliegoPage.vue'
import DisenoPage from 'pages/precios/DisenoPage.vue'

export default {
  name: 'IndexTesoreriaPage',
  components: {
    DisenoPage,
    ConPliegoPage,
    SinPliegoPage
  },
  data () {
    return {
      tab: 'diseno',
      loading: false
    }
  },
  mounted () {
  },
  methods: {
  }
}
</script>
