<template>
  <div class="row q-pl-xs">
    <div class="col-12 row items-center q-mb-md">
      <div>
        <div>Proxima Compra estimada: <span class="text-bold">{{empresa.proximoPedido}}</span></div>
        <div>Cantidad de pedidos: <span class="text-bold">{{pedidos.length}}</span></div>
      </div>
      <q-space />
      <div>
        <div class="flex flex-center">
          <q-icon name="calendar_today" size="25px" color="grey-8" />
          <span class="text-bold text-bold text-blue">{{empresa.promedioDiasCompra}}</span>
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
<!--      <pre>{{pedidos[0]}}</pre>-->
      <q-markup-table wrap-cells>
        <thead>
        <tr class="bg-black text-white">
          <th class="text-center">Estado</th>
          <th class="text-center">N° Pedido</th>
          <th class="">Sucursal</th>
          <th class="text-center">Producto</th>
          <th class="text-center">Tamaño</th>
          <th class="text-center">Cantidad</th>
          <th class="text-center">Gr</th>
          <th class="text-center">Entrega</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="pedido in pedidos" :key="pedido.id" class="cursor-pointer"
            @click="pedidoClickUpdate(pedido)"
            :class="`${pedido.estadoPedido=='Cancelado'? 'text-red' : ''} ${pedido.estadoPedido=='Activo'? 'bg-blue-2' : ''}`"
        >
          <td class="text-center">
              {{pedido.estadoPedido}}
          </td>
          <td class="text-center">#{{pedido.id}}</td>
          <td class="text-center">
            <template v-if="pedido.sucursal">
              {{pedido.sucursal.nombre}}
            </template>
          </td>
          <td class="text-center">{{pedido.producto}}</td>
          <td class="text-center">{{pedido.medida}}</td>
          <td class="text-center">{{pedido.cantidad}}</td>
          <td class="text-center">{{pedido.gr}}</td>
          <td class="text-center">{{$filters.shortDate(pedido.fechaEntrega, 'DD/MM/YYYY')}}</td>
        </tr>
        </tbody>
      </q-markup-table>
    </div>
    <q-dialog v-model="pedidoDialogVer">
      <PedidoShowComponent :empresa="empresa" :pedido="pedidoDatoUpdate"
                           @empresaSearch="$emit('empresaSearch', $event)"
                           @closeDialogShowPedido="pedidoDialogVer = false"
      />
    </q-dialog>
    <q-dialog v-model="pedidoDialogNew">
      <PedidoNewComponent :empresa="empresa" :pedidoDato="$store.pedido"
                          @empresaSearch="$emit('empresaSearch', $event)"
                          @closeDialog="closeDialog"
      />
    </q-dialog>
<!--    <pre>{{$store.pedido}}</pre>-->
  </div>
</template>
<script>
// import { date } from 'quasar'
import PedidoShowComponent from './PedidoShowComponent.vue'
import PedidoNewComponent from './PedidoNewComponent.vue'

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
  components: {
    PedidoShowComponent,
    PedidoNewComponent
  },
  data () {
    return {
      loading: false,
      pedidoDialog: false,
      pedidoDialogVer: false,
      pedidoDialogNew: false,
      pedidoOption: '',
      // pedidoDato: {
      //   codigo: 0,
      //   producto: '',
      //   medida: '',
      //   cantidad: '',
      //   esp: '',
      //   gr: '',
      //   lados: '',
      //   diseno: '',
      //   descripcion: '',
      //   estado: '',
      //   fechaTexto: '',
      //   estadoPedido: 'Activo',
      //   fecha: date.formatDate(new Date(), 'YYYY-MM-DD'),
      //   diasCompra: 5,
      //   fechaEntrega: date.formatDate(new Date(), 'YYYY-MM-DD'),
      //   fechaEspecial: date.formatDate(new Date(), 'YYYY-MM-DD'),
      //   precioProducto: 0,
      //   precioDiseno: 0,
      //   especificaciones: '',
      //   terminacion: '',
      //   envio: '',
      //   precioEspecificaciones: 0,
      //   precioEnvio: 0,
      //   pago: '',
      //   metodoPago: 'Efectivo',
      //   comentarioPago: '',
      //   iva: 15,
      //   seFacturo: 'No',
      //   facturaA: 'Factura ninguna',
      //   empresa_id: this.empresa.id,
      //   user_id: 3,
      //   sucursal_id: 2,
      //   facturacion_id: 2,
      //   direccion_id: 1,
      //   persona_id: 2,
      //   phone_id: 2,
      //   email_id: 2,
      //   deleted_at: null,
      //   precioTotal: 1594.13,
      //   deuda: 1114.13,
      //   sucursal: this.empresa.sucursals[0],
      //   person: this.empresa.person[0],
      //   direccion: this.empresa.direccion[0],
      //   facturacion: this.empresa.facturacion[0]
      // },
      pedidoDatoUpdate: {},
      pedidosDatos: this.pedidos
    }
  },
  mounted () {
    // this.pedidoDato = this.$store.pedido
    // setTimeout(() => {
    //   this.pedidoClickUpdate(this.pedidos[0])
    // }, 2500)
    // setTimeout(() => {
    //   this.pedidoDialogClick()
    // }, 1000)
  },
  methods: {
    closeDialog () {
      this.pedidoDialogNew = false
      // this.pedidoDato = {
      //   codigo: 0,
      //   producto: '',
      //   medida: '',
      //   cantidad: '',
      //   esp: '',
      //   gr: '',
      //   lados: '',
      //   diseno: 'nuevo',
      //   descripcion: '',
      //   estado: 'Diseño',
      //   fechaTexto: '',
      //   estadoPedido: 'Activo',
      //   fecha: date.formatDate(new Date(), 'YYYY-MM-DD'),
      //   diasCompra: 5,
      //   fechaEntrega: date.formatDate(new Date(), 'YYYY-MM-DD'),
      //   fechaEspecial: date.formatDate(new Date(), 'YYYY-MM-DD'),
      //   precioProducto: 0,
      //   precioDiseno: 0,
      //   especificaciones: '',
      //   terminacion: '',
      //   envio: '',
      //   precioEspecificaciones: 0,
      //   precioEnvio: 0,
      //   pago: '',
      //   metodoPago: 'Efectivo',
      //   comentarioPago: '',
      //   iva: 15,
      //   seFacturo: 'No',
      //   facturaA: 'Factura ninguna',
      //   empresa_id: this.empresa.id,
      //   user_id: 3,
      //   sucursal_id: 2,
      //   facturacion_id: 2,
      //   direccion_id: 1,
      //   persona_id: 2,
      //   phone_id: 2,
      //   email_id: 2,
      //   deleted_at: null,
      //   precioTotal: 1594.13,
      //   deuda: 1114.13,
      //   sucursal: this.empresa.sucursals[0],
      //   person: this.empresa.person[0],
      //   direccion: this.empresa.direccion[0],
      //   facturacion: this.empresa.facturacion[0]
      // }
    },
    pedidoClickUpdate (pedido) {
      this.pedidoDialogVer = true
      this.pedidoOption = 'update'
      this.pedidoDatoUpdate = {
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
    pedidoDialogClick () {
      this.loading = true
      this.$axios.post('getNumeroPedido', { empresa_id: this.empresa.id })
        .then(response => {
          this.pedidoDialogNew = true
          this.$store.pedido.codigo = response.data
        }).catch(error => {
          this.$alert.error(error)
        }).finally(() => {
          this.loading = false
        })
    }
  }
}
</script>
<style>
.formatFecha {
  font-size: 0.8em;
  line-height: 1;
}
</style>
