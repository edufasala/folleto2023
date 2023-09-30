<script>
export default {
  name: 'RevisionPedidoPage',
  data () {
    return {
      loading: false,
      pedido: {},
      pedidos: []
    }
  },
  mounted () {
    this.getPedidos()
  },
  methods: {
    aceptarPedido (pedido) {
      this.loading = true
      this.$axios.post('aceptarPedido', pedido)
        .then(response => {
          this.$alert.success('Pedido aceptado')
          this.getPedidos()
        }).catch(error => {
          this.$alert.error(error.response.data.message)
        }).finally(() => {
          this.loading = false
        })
    },
    rechazarPedido (pedido) {
      this.loading = true
      this.$axios.post('rechazarPedido', pedido)
        .then(response => {
          this.$alert.success('Pedido rechazado')
          this.getPedidos()
        }).catch(error => {
          this.$alert.error(error.response.data.message)
        }).finally(() => {
          this.loading = false
        })
    },
    getPedidos () {
      this.loading = true
      this.$axios.get('revisionPedidos')
        .then(response => {
          this.pedidos = response.data
        }).catch(error => {
          this.$alert(error.response.data.message)
        }).finally(() => {
          this.loading = false
        })
    }
  }
}
</script>

<template>
  <div>
    <div class="text-right">
        Pedidos para revisar <span class="text-bold">{{pedidos.length}}</span>
    </div>
    <q-markup-table>
      <thead>
      <tr class="bg-black text-white">
        <th class="text-left">Fecha</th>
        <th class="text-left">Usuario</th>
        <th class="text-left">Nº CI.</th>
        <th class="text-left">Producto</th>
        <th class="text-left">Gr</th>
        <th class="text-left">Cantidad</th>
        <th class="text-left">Medida</th>
        <th class="text-left">Precio</th>
        <th class="text-left">Estado</th>
        <th class="text-left">Opciones</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="pedido in pedidos" :key="pedido.id">
        <td class="text-left">{{pedido.fecha}}</td>
        <td class="text-left">{{pedido.user.name}}</td>
        <td class="text-left">{{pedido.dni}}</td>
        <td class="text-left">{{pedido.producto}}</td>
        <td class="text-left">{{pedido.gr}}</td>
        <td class="text-left">{{pedido.cantidad}}</td>
        <td class="text-left">{{pedido.medida}}</td>
        <td class="text-left">{{$filters.currency(pedido.precioTotal)}}</td>
        <td class="text-left">
          <q-badge :color="pedido.estadoPedido==='Activo'?'orange':pedido.estadoPedido==='Aceptado'?'green':'red'">
            {{pedido.estadoPedido}}
          </q-badge>
        </td>
        <td class="text-left">
          <q-btn :loading="loading" color="red" dense rounded icon="close" @click="rechazarPedido(pedido)"/>
          <q-btn :loading="loading" color="green" dense rounded icon="check" @click="aceptarPedido(pedido)"/>
        </td>
      </tr>
      </tbody>
    </q-markup-table>
<!--    <pre>{{pedidos}}</pre>-->
  </div>
</template>

<style scoped>

</style>
