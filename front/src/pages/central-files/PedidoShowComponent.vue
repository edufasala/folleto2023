<template>
  <q-card class="q-pa-xs" style="max-width: 750px">
    <q-card-section class="q-py-xs row items-center">
      <div class="text-h5 text-bold"> Pedido # {{pedido.codigo}}</div>
      <q-space />
      <div class="text-right formatFecha">
        <div>Fecha de Pedido <span class="text-bold">{{$filters.datedMy(pedido.fecha)}}</span></div>
        <div>Fecha de Entrega <span class="text-bold">{{$filters.datedMy(pedido.fechaEntrega)}}</span></div>
      </div>
      <q-btn flat dense icon="cancel" v-close-popup />
    </q-card-section>
    <q-card-section class="q-py-none">
      <q-form @submit="pedidoSubmit">
        <div class="row">
          <div class="col-12">
            <div class="row items-center">
              <div>
              <div class="text-bold text-subtitle1"><span class="text-red">#{{empresa.id}}</span> {{empresa.nombre}}</div>
              <div> Sucursal: <span class="text-bold">{{pedido.sucursal.nombre}}</span></div>
              </div>
              <q-space />
              <div>
                <div> Vendedor: <span class="text-bold">{{pedido.user.name}}</span></div>
              </div>
            </div>
          </div>
          <div class="col-12">
            <q-card class="q-pa-xs bg-grey-3" flat bordered cla>
              <q-card-section class="q-pa-xs">
                <div class="row">
                  <div class="col-12 col-md-6">
                    Nombre: <span class="text-bold">{{pedido.person.nombre}}</span>
                  </div>
                  <div class="col-12 col-md-3">
                    Cargo: <span class="text-bold">{{pedido.person.cargo}}</span>
                  </div>
                  <div class="col-12 col-md-3">
                    DNI: <span class="text-bold">{{pedido.person.dni}}</span>
                  </div>
                  <div class="col-12 col-md-6">
                    Teléfono: <span class="text-bold">{{pedido.phone.phone}}</span>
                  </div>
                  <div class="col-12 col-md-6">
                    Email: <span class="text-bold">{{pedido.email.email}}</span>
                  </div>
                </div>
              </q-card-section>
            </q-card>
          </div>
        </div>
        <pre>{{pedido}}</pre>
        <pre>{{empresa}}</pre>
        <q-card-actions align="right">
          <q-btn dense no-caps label="Cancelar" v-close-popup color="red" :loading="loading"/>
<!--          <q-btn dense no-caps :loading="loading" type="submit"-->
<!--                 :label="pedidoOption === 'create' ? 'Crear' : 'Editar'"-->
<!--                 :color="pedidoOption === 'create' ? 'blue' : 'orange'" />-->
        </q-card-actions>
      </q-form>
    </q-card-section>
  </q-card>
</template>
<script>

export default {
  name: 'NotasComponent',
  props: {
    empresa: {
      type: Object,
      required: true
    },
    pedido: {
      type: Object,
      required: true
    }
  },
  data () {
    return {
      pedidoDato: {},
      loading: false
    }
  },
  mounted () {
    this.pedidoDato = this.pedido
  },
  methods: {
    pedidoSubmit () {
      // this.loading = true
      // this.$emit('pedidoSubmit', this.pedidoDato)
    }
  }
}
</script>
