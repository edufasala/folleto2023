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
      <q-markup-table>
        <thead>
        <tr class="bg-black text-white">
          <th class="text-center">Estado</th>
          <th class="text-center">N° Pedido</th>
          <th class="text-center">Sucursal</th>
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
            :class="`${pedido.estadoPedido=='Cancelado'? 'text-red' : ''}`"
        >
          <td class="text-center">
              {{pedido.estadoPedido}}
          </td>
          <td class="text-center">#{{pedido.codigo}}</td>
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
      <PedidoShowComponent :empresa="empresa" :pedido="pedidoDato" @empresaSearch="$emit('empresaSearch', $event)"/>
    </q-dialog>
    <q-dialog v-model="pedidoDialogNew">
      <PedidoNewComponent :empresa="empresa" :pedidoDato="pedidoDato"
                          @empresaSearch="$emit('empresaSearch', $event)"
                          @closeDialog="pedidoDialogNew = false"
      />
    </q-dialog>
  </div>
</template>
<script>
import { date } from 'quasar'
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
      pedidoDato: {
        codigo: 0,
        producto: 'Folleto',
        medida: '10x15',
        cantidad: '1',
        esp: '',
        gr: '150',
        lados: '2 lados diferentes',
        diseno: 'nuevo',
        descripcion: '',
        estado: 'Diseño',
        estadoPedido: 'Activo',
        fecha: date.formatDate(new Date(), 'YYYY-MM-DD'),
        diasCompra: 5,
        fechaEntrega: date.formatDate(new Date(), 'YYYY-MM-DD'),
        fechaEspecial: date.formatDate(new Date(), 'YYYY-MM-DD'),
        precioProducto: 0,
        precioDiseno: 0,
        especificaciones: '',
        terminacion: '',
        envio: '',
        precioEspecificaciones: 0,
        precioEnvio: 0,
        pago: 0,
        metodoPago: 'Efectivo',
        comentarioPago: '',
        iva: 15,
        seFacturo: 'Si',
        empresa_id: this.empresa.id,
        user_id: 3,
        sucursal_id: 2,
        facturacion_id: 2,
        direccion_id: 1,
        persona_id: 2,
        phone_id: 2,
        email_id: 2,
        deleted_at: null,
        precioTotal: 1594.13,
        deuda: 1114.13,
        sucursal: this.empresa.sucursals[0],
        person: this.empresa.person[0],
        direccion: this.empresa.direccion[0],
        facturacion: this.empresa.facturacion[0]
      },
      pedidosDatos: this.pedidos
    }
  },
  mounted () {
    // setTimeout(() => {
    //   this.pedidoClickUpdate(this.pedidos[0])
    // }, 2500)
    // setTimeout(() => {
    //   this.pedidoDialogClick()
    // }, 1000)
  },
  methods: {
    pedidoClickUpdate (pedido) {
      this.pedidoDialogVer = true
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
          this.pedidoDato = {
            codigo: 0,
            producto: 'Folleto',
            medida: '10x15',
            cantidad: '1',
            esp: '',
            gr: '150',
            lados: '2 lados diferentes',
            diseno: 'nuevo',
            descripcion: '',
            estado: 'Diseño',
            estadoPedido: 'Activo',
            fecha: date.formatDate(new Date(), 'YYYY-MM-DD'),
            diasCompra: 5,
            fechaEntrega: date.formatDate(new Date(), 'YYYY-MM-DD'),
            fechaEspecial: date.formatDate(new Date(), 'YYYY-MM-DD'),
            precioProducto: 0,
            precioDiseno: 0,
            especificaciones: '',
            terminacion: '',
            envio: '',
            precioEspecificaciones: 0,
            precioEnvio: 0,
            pago: 0,
            metodoPago: 'Efectivo',
            comentarioPago: '',
            iva: 15,
            seFacturo: 'Si',
            empresa_id: this.empresa.id,
            user_id: 3,
            sucursal_id: 2,
            facturacion_id: 2,
            direccion_id: 1,
            persona_id: 2,
            phone_id: 2,
            email_id: 2,
            deleted_at: null,
            precioTotal: 1594.13,
            deuda: 1114.13,
            sucursal: this.empresa.sucursals[0],
            person: this.empresa.person[0],
            direccion: this.empresa.direccion[0],
            facturacion: this.empresa.facturacion[0]
          }
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
      this.loading = true
      this.$axios.post('getNumeroPedido', { empresa_id: this.empresa.id })
        .then(response => {
          this.pedidoDialogNew = true
          this.pedidoDato.codigo = response.data
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
