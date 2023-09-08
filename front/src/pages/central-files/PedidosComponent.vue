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
          <td class="text-center">{{pedido.sucursal.nombre}}</td>
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
      <PedidoNewComponent :empresa="empresa" :pedidoDato="pedidoDato" @empresaSearch="$emit('empresaSearch', $event)"/>
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
      pedidoDato: {},
      pedidosDatos: this.pedidos
    }
  },
  mounted () {
    // setTimeout(() => {
    //   this.pedidoClickUpdate(this.pedidos[0])
    // }, 2500)
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
          this.pedidoDato = {
            codigo: response.data,
            producto: 'Folleto',
            medida: '10x15',
            cantidad: '1',
            esp: '',
            gr: '150',
            lados: '2 lados diferentes',
            diseno: 'nuevo',
            descripcion: '',
            estado: 'Cancelado',
            estadoPedido: 'Activo',
            fecha: '2023-07-04',
            diasCompra: 5,
            fechaEntrega: date.formatDate(new Date(), 'YYYY-MM-DD'),
            fechaEspecial: date.formatDate(new Date(), 'YYYY-MM-DD'),
            precioProducto: 0,
            precioDiseno: 726.69,
            especificaciones: 'Voluptate quia quas consequatur molestiae explicabo qui aut explicabo. Quasi impedit occaecati modi officiis cumque in. Et quaerat perferendis dolorem in amet. Deleniti aut et neque vero aperiam et.',
            terminacion: '',
            envio: 'Si',
            precioEspecificaciones: 0,
            precioEnvio: 23.47,
            pago: 480,
            metodoPago: 'Transferencia',
            comentarioPago: 'Veniam est ad dolorem inventore aut vero nulla ratione. Dolorem consequatur doloremque laborum et soluta sit magnam. Excepturi in neque a rerum et maxime.',
            iva: 15,
            seFacturo: 'Si',
            empresa_id: 1,
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
            direccion: {
              id: 1,
              direccion: 'At non tempore odit et vitae dolor.',
              codigoPostal: '8203',
              localidad: 'Belle McLaughlin',
              empresa_id: 1,
              deleted_at: null
            },
            facturacion: {
              id: 2,
              cuit: '50602797920',
              condicional: 'Aubree Bechtelar',
              razonSocial: 'Anita Mosciski',
              comentario: 'Sunt et neque nobis veritatis eveniet.',
              empresa_id: 1,
              deleted_at: null
            },
            phone: {
              id: 2,
              phone: '+1.603.974.3973',
              person_id: 1,
              deleted_at: null
            },
            email: {
              id: 2,
              email: 'iva04@gmail.com',
              status: 'Si',
              person_id: 1,
              deleted_at: null
            },
            pagos: [
              {
                id: 91,
                fecha: '1985-03-16',
                hora: '18:00:33',
                tipo: 'Pago',
                monto: 96.99,
                facturado: 'No',
                metodoPago: 'Otro',
                comentario: 'Rerum doloribus est quia et. Velit recusandae sed dolorem reiciendis aut laboriosam. Similique ea ipsam qui nulla nostrum quos. Sint voluptates quos et consectetur vel.',
                pedido_id: 19,
                facturacion_id: 1,
                user_id: 3,
                user: {
                  id: 3,
                  name: 'Prof. Angelica Volkman I',
                  email: 'acasper@example.com',
                  email_verified_at: '2023-09-08T01:19:00.000000Z',
                  role: 'Diseñador',
                  active: 'N'
                }
              },
              {
                id: 92,
                fecha: '2014-11-07',
                hora: '01:13:33',
                tipo: 'Seña',
                monto: 5.3,
                facturado: 'Si',
                metodoPago: 'Transferencia',
                comentario: 'Odio illum et dolor praesentium laudantium et. Vitae et in tempore minus harum. Qui corporis quia eveniet recusandae inventore.',
                pedido_id: 19,
                facturacion_id: 2,
                user_id: 5,
                user: {
                  id: 5,
                  name: 'Eleonore Kuhlman',
                  email: 'nitzsche.gerald@example.com',
                  email_verified_at: '2023-09-08T01:19:00.000000Z',
                  role: 'Administrador',
                  active: 'S'
                }
              },
              {
                id: 93,
                fecha: '2015-02-11',
                hora: '15:34:55',
                tipo: 'Pago',
                monto: 99.9,
                facturado: 'No',
                metodoPago: 'Efectivo',
                comentario: 'Excepturi animi aut autem dolorum quod qui. Eum fugit impedit in adipisci natus. Qui ea eveniet est et. Laboriosam vero ea cum alias quaerat.',
                pedido_id: 19,
                facturacion_id: 2,
                user_id: 19,
                user: {
                  id: 19,
                  name: 'Brooks Keeling',
                  email: 'lsporer@example.org',
                  email_verified_at: '2023-09-08T01:19:00.000000Z',
                  role: 'Diseñador',
                  active: 'N'
                }
              },
              {
                id: 94,
                fecha: '2000-08-17',
                hora: '20:58:56',
                tipo: 'Pago',
                monto: 90.9,
                facturado: 'No',
                metodoPago: 'Otro',
                comentario: 'Voluptatem sed tempore quia. In in qui ut officia est quia. Doloremque quo quae sed eum enim reiciendis. Fugit illo fugiat quasi in fuga voluptas labore.',
                pedido_id: 19,
                facturacion_id: 1,
                user_id: 9,
                user: {
                  id: 9,
                  name: 'Jalen Heaney',
                  email: 'aschaden@example.net',
                  email_verified_at: '2023-09-08T01:19:00.000000Z',
                  role: 'Gerente de ventas',
                  active: 'S'
                }
              },
              {
                id: 95,
                fecha: '1984-05-10',
                hora: '06:39:18',
                tipo: 'Seña',
                monto: 20.88,
                facturado: 'No',
                metodoPago: 'Efectivo',
                comentario: 'Fugit tempore sapiente perspiciatis veniam debitis suscipit. Soluta earum quas est autem qui quis. Id autem cum consequatur natus quaerat ea neque. Ut reprehenderit qui nostrum et.',
                pedido_id: 19,
                facturacion_id: 2,
                user_id: 20,
                user: {
                  id: 20,
                  name: 'Mr. Manuela Nienow PhD',
                  email: 'zoconner@example.net',
                  email_verified_at: '2023-09-08T01:19:00.000000Z',
                  role: 'Entregador',
                  active: 'S'
                }
              }
            ],
            status: [
              {
                id: 181,
                fecha: '1983-10-28',
                hora: '11:48:50',
                realizado: 'Entrega',
                nota: 'Dolorem explicabo sunt in illum doloremque pariatur temporibus. Eum optio nostrum quo natus quis. Magnam quisquam omnis corrupti incidunt blanditiis. Sunt culpa aspernatur quaerat laboriosam omnis.',
                pedido_id: 19,
                user_id: 15,
                user: {
                  id: 15,
                  name: 'Ruben McLaughlin',
                  email: 'rippin.amani@example.com',
                  email_verified_at: '2023-09-08T01:19:00.000000Z',
                  role: 'Entregador',
                  active: 'S'
                }
              },
              {
                id: 182,
                fecha: '2017-12-12',
                hora: '16:46:28',
                realizado: 'Cancelado',
                nota: 'Eum dolorem reiciendis odio similique. Sit distinctio aliquid quo quia sit. Voluptas doloremque rerum nulla vero.',
                pedido_id: 19,
                user_id: 18,
                user: {
                  id: 18,
                  name: 'Ivory Ondricka I',
                  email: 'cassin.rowland@example.org',
                  email_verified_at: '2023-09-08T01:19:00.000000Z',
                  role: 'Diseñador',
                  active: 'N'
                }
              },
              {
                id: 183,
                fecha: '1993-12-03',
                hora: '03:57:17',
                realizado: 'Cancelado',
                nota: 'Doloremque recusandae soluta qui nemo quod sint quo. Officiis amet explicabo dolorem facilis dolore doloribus harum perferendis. Qui est voluptas accusantium voluptas.',
                pedido_id: 19,
                user_id: 4,
                user: {
                  id: 4,
                  name: 'Kariane Boehm I',
                  email: 'schowalter.viola@example.net',
                  email_verified_at: '2023-09-08T01:19:00.000000Z',
                  role: 'Vendedor',
                  active: 'N'
                }
              },
              {
                id: 184,
                fecha: '2011-05-28',
                hora: '15:42:57',
                realizado: 'Facturacion',
                nota: 'Et voluptate dicta esse eos optio. Autem at quis praesentium eum. Doloremque sint quis nihil voluptas ullam iure enim. Qui qui natus tempora ut corporis rerum.',
                pedido_id: 19,
                user_id: 19,
                user: {
                  id: 19,
                  name: 'Brooks Keeling',
                  email: 'lsporer@example.org',
                  email_verified_at: '2023-09-08T01:19:00.000000Z',
                  role: 'Diseñador',
                  active: 'N'
                }
              },
              {
                id: 185,
                fecha: '1971-03-21',
                hora: '18:16:00',
                realizado: 'Facturacion',
                nota: 'Doloremque omnis sunt qui sunt ipsum dolores sint. Et facilis aut minus veniam quasi. Quaerat voluptate eveniet quo tenetur. Voluptas suscipit voluptatibus dolorem quia temporibus quia sit.',
                pedido_id: 19,
                user_id: 21,
                user: {
                  id: 21,
                  name: 'Toney Corkery',
                  email: 'marcelina45@example.net',
                  email_verified_at: '2023-09-08T01:19:00.000000Z',
                  role: 'Entregador',
                  active: 'S'
                }
              },
              {
                id: 186,
                fecha: '1994-02-14',
                hora: '07:48:09',
                realizado: 'Envio',
                nota: 'Quibusdam a et illo ut provident sint. Tempora consequatur dolorum tenetur sunt asperiores. Voluptate nulla suscipit amet alias esse aspernatur. Harum eligendi vitae ea ut quis molestias.',
                pedido_id: 19,
                user_id: 5,
                user: {
                  id: 5,
                  name: 'Eleonore Kuhlman',
                  email: 'nitzsche.gerald@example.com',
                  email_verified_at: '2023-09-08T01:19:00.000000Z',
                  role: 'Administrador',
                  active: 'S'
                }
              },
              {
                id: 187,
                fecha: '2022-03-02',
                hora: '19:47:28',
                realizado: 'Entrega',
                nota: 'Dolorem et hic est temporibus. Molestiae ad suscipit cumque. Velit fugit accusamus sequi ea architecto modi. Aut minus libero quisquam nihil illo. Odio vitae sit sed consequatur et.',
                pedido_id: 19,
                user_id: 5,
                user: {
                  id: 5,
                  name: 'Eleonore Kuhlman',
                  email: 'nitzsche.gerald@example.com',
                  email_verified_at: '2023-09-08T01:19:00.000000Z',
                  role: 'Administrador',
                  active: 'S'
                }
              },
              {
                id: 188,
                fecha: '2004-01-17',
                hora: '20:30:48',
                realizado: 'Entrega',
                nota: 'Quasi nulla unde ut pariatur nobis. Nihil nihil dolorum nihil. Saepe voluptatem perspiciatis consequatur eum molestiae quo expedita.',
                pedido_id: 19,
                user_id: 16,
                user: {
                  id: 16,
                  name: 'Mrs. Ariane Koepp DDS',
                  email: 'bradtke.makenzie@example.org',
                  email_verified_at: '2023-09-08T01:19:00.000000Z',
                  role: 'Diseñador',
                  active: 'S'
                }
              },
              {
                id: 189,
                fecha: '1973-08-21',
                hora: '14:21:02',
                realizado: 'Pago',
                nota: 'Qui molestiae aut aperiam esse aut ut. Officiis maxime eius qui. Sint eos deleniti dolore necessitatibus animi fugit. Occaecati consequatur harum optio sint.',
                pedido_id: 19,
                user_id: 19,
                user: {
                  id: 19,
                  name: 'Brooks Keeling',
                  email: 'lsporer@example.org',
                  email_verified_at: '2023-09-08T01:19:00.000000Z',
                  role: 'Diseñador',
                  active: 'N'
                }
              },
              {
                id: 190,
                fecha: '2009-07-28',
                hora: '02:11:52',
                realizado: 'Entregado',
                nota: 'Aut rem nisi consequatur quasi cupiditate quo quam. Ut aliquid ut voluptatum eum qui. In ut sit quos aut ratione et. Voluptas amet reprehenderit totam asperiores. Aut harum nemo quo.',
                pedido_id: 19,
                user_id: 16,
                user: {
                  id: 16,
                  name: 'Mrs. Ariane Koepp DDS',
                  email: 'bradtke.makenzie@example.org',
                  email_verified_at: '2023-09-08T01:19:00.000000Z',
                  role: 'Diseñador',
                  active: 'S'
                }
              }
            ]
          }
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
