<template>
  <q-card class="q-pa-xs" style="max-width: 950px">
    <q-card-section class="q-py-xs row items-center">
      <div class="text-h5 text-bold"> Pedido # {{pedidoDato.codigo}}</div>
      <q-space />
      <div class="text-right formatFecha">
        <div>Fecha de Pedido <span class="text-bold">{{$filters.datedMy(pedido.fecha)}}</span></div>
        <div>Fecha de Entrega <span class="text-bold">{{$filters.datedMy(pedido.fechaEntrega)}}</span></div>
      </div>
      <q-btn flat dense icon="cancel" v-close-popup />
    </q-card-section>
    <q-card-section class="q-py-none">
      <q-form>
        <div class="row">
          <div class="col-12">
            <div class="row items-center">
              <div>
              <div class="text-bold text-subtitle1"><span class="text-red">#{{empresa.id}}</span> {{empresa.nombre}}</div>
              <div> Sucursal: <span class="text-bold" v-if="pedidoDato.sucursal">{{pedidoDato.sucursal.nombre}}</span></div>
              </div>
              <q-space />
              <div>
                <div> Vendedor: <span class="text-bold">{{pedido.user.name}}</span></div>
              </div>
            </div>
          </div>
          <div class="col-12">
            <q-card class="q-pa-xs bg-grey-3" flat bordered>
              <q-card-section class="q-pa-xs">
                <div class="row">
                  <div class="col-12 col-md-6">
                    Nombre: <span class="text-bold" v-if="pedidoDato.person">{{pedidoDato.person.nombre}}</span>
                  </div>
                  <div class="col-12 col-md-3">
                    Cargo: <span class="text-bold" v-if="pedidoDato.person">{{pedidoDato.person.cargo}}</span>
                  </div>
                  <div class="col-12 col-md-3">
                    DNI: <span class="text-bold" v-if="pedidoDato.person">{{pedidoDato.person.dni}}</span>
                  </div>
                  <div class="col-12 col-md-6">
                    Teléfono: <span class="text-bold" v-if="pedidoDato.phone">{{pedidoDato.phone.phone}}</span>
                  </div>
                  <div class="col-12 col-md-6">
                    Email: <span class="text-bold" v-if="pedidoDato.email">{{pedidoDato.email.email}}</span>
                  </div>
                </div>
              </q-card-section>
            </q-card>
          </div>
        </div>
        <div class="q-mt-md">
          <q-card>
            <q-tabs
              v-model="tab"
              dense
              class="text-grey"
              active-color="primary"
              indicator-color="primary"
              align="justify"
              narrow-indicator
            >
              <q-tab name="pedido" no-caps>
                  <span class="text-bold">Pedido</span>
              </q-tab>
              <q-tab name="taller" no-caps>
                  <span class="text-bold">Taller y Entrega</span>
              </q-tab>
              <q-tab name="$" no-caps>
                  <span class="text-bold">$</span>
              </q-tab>
              <q-tab name="status" no-caps>
                  <span class="text-bold">Status</span>
              </q-tab>
            </q-tabs>
            <q-separator />
            <q-tab-panels v-model="tab" animated class="bg-grey-2">
              <q-tab-panel style="height: 300px;width: 650px" name="pedido">
                <div class="row">
                  <div class="col-4 col-md-2">Producto</div>
                  <div class="col-8 col-md-6 text-bold">{{ pedidoDato.producto }}</div>
                  <div class="col-4 col-md-2">Medida</div>
                  <div class="col-8 col-md-2 text-bold">{{ pedidoDato.medida }}</div>
                  <div class="col-4 col-md-2">Cantidad</div>
                  <div class="col-8 col-md-4 text-bold">{{ pedidoDato.cantidad }}</div>
                  <div class="col-4 col-md-1">Esp.</div>
                  <div class="col-8 col-md-1 text-bold q-pr-md">{{ pedidoDato.esp }}</div>
                  <div class="col-4 col-md-2">Gr.</div>
                  <div class="col-8 col-md-2 text-bold">{{ pedidoDato.gr }}</div>
                  <div class="col-4 col-md-2">Lados</div>
                  <div class="col-8 col-md-4 text-bold">{{ pedidoDato.lados }}</div>
                  <div class="col-4 col-md-2">Diseño</div>
                  <div class="col-6 col-md-4 text-bold">{{ pedidoDato.diseno }}</div>
                  <div class="col-4 col-md-2">Descripcion</div>
                  <div class="col-8 col-md-10 border-round">{{ pedidoDato.descripcion }}</div>
                </div>
              </q-tab-panel>
              <q-tab-panel style="height: 300px;width: 650px" name="taller">
                <div class="row">
                  <div class="col-4 col-md-2">Terminacion</div>
                  <div class="col-8 col-md-6 text-bold">{{ pedidoDato.terminacion }}</div>
                  <div class="col-4 col-md-2">Envio</div>
                  <div class="col-8 col-md-2 text-bold">{{ pedidoDato.envio }}</div>
                  <div class="col-12 col-md-6">
                    <div class="row">
                      <div class="col-4">Descripcion</div>
                      <div class="col-8 text-bold border-round">{{ pedidoDato.especificaciones }}</div>
                    </div>
                  </div>
                  <div class="col-12 col-md-6">
                    <div :class="`row ${$q.screen.lt.md ? '' : 'q-ml-md'}`">
                      <div class="col-4">Direccion</div>
                      <div class="col-8 text-bold" v-if="pedidoDato.direccion">{{ pedidoDato.direccion.direccion }}</div>
                      <div class="col-4">Localidad</div>
                      <div class="col-8 text-bold" v-if="pedidoDato.direccion">{{ pedidoDato.direccion.localidad }}</div>
                      <div class="col-4">CP:</div>
                      <div class="col-8 text-bold" v-if="pedidoDato.direccion">{{ pedidoDato.direccion.codigoPostal }}</div>
                      <div class="col-4">Descripcion:</div>
                      <div class="col-8 text-bold">{{ pedidoDato.descripcion }}</div>
                    </div>
                  </div>
                </div>
              </q-tab-panel>
              <q-tab-panel style="height: 300px;width: 650px" name="$">
                <div class="row">
                  <div class="col-12 col-md-3">
                    <q-card flat bordered>
                      <div class="text-bold text-center">RESUMEN</div>
                      <q-separator/>
                      <div class="q-pa-xs">
                        <div class="row items-center q-px-xs">
                          Producto
                          <q-space />
                          <div class="text-bold">$ {{ pedidoDato.precioProducto }}</div>
                        </div>
                        <div class="row items-center q-px-xs">
                          Diseño
                          <q-space />
                          <div class="text-bold">$ {{ pedidoDato.precioDiseno }}</div>
                        </div>
                        <div class="row items-center q-px-xs">
                          Terminacion
                          <q-space />
                          <div class="text-bold">$ {{ pedidoDato.precioEspecificaciones }}</div>
                        </div>
                        <div class="row items-center q-px-xs">
                          Envio
                          <q-space />
                          <div class="text-bold">$ {{ pedidoDato.precioEnvio }}</div>
                        </div>
                        <div class="row items-center q-px-xs">
                          IVA <span class="text-red">({{pedidoDato.iva}})</span>
                          <q-space />
<!--                          <div class="text-bold">$ {{ $filters.iva(pedidoDato.precioTotal, pedidoDato.iva) }}</div>-->
                          <div class="text-bold">$ {{ precioIva }}</div>
                        </div>
                        <div class="row items-center q-px-xs bg-black text-white">
                          TOTAL
                          <q-space />
                          <div class="text-bold">$ {{ pedidoDato.precioTotal }}</div>
                        </div>
                        <div class="row items-center q-px-xs">
                          Seña
                          <q-space />
                          <div class="text-bold">$ {{ pedidoDato.sena }}</div>
                        </div>
                        <div class="row items-center q-px-xs">
                          Deuda
                          <q-space />
                          <div class="text-bold text-red">$ {{ pedidoDato.deuda }}</div>
                        </div>
                      </div>
                    </q-card>
                  </div>
                  <div class="col-12 col-md-9 q-px-md">
                    <div class="text-h6 row items-center">
                      Pagos
                      <q-space />
                      <q-btn color="green" size="10px" dense icon="add" @click="pagoDialogClick" label="Agregar Pago" no-caps />
                    </div>
                    <q-markup-table dense>
                      <thead>
                        <tr class="bg-black text-white">
                          <th class="text-left">Fecha</th>
                          <th class="text-left">Hs</th>
                          <th class="text-left">Tipo</th>
                          <th class="text-left">Monto</th>
                          <th class="text-left">Met. Pago</th>
                          <th class="text-left">Facturado</th>
                          <th class="text-left">Usuario</th>
                          <th class="text-left">Estado</th>
                        </tr>
                      </thead>
                      <thead>
                      <tr v-for="pago in pedidoDato.pagos" :key="pago.id">
                        <td class="text-caption">{{$filters.datedMy(pago.fecha)}}</td>
                        <td class="text-caption">{{$filters.shortTime(pago.hora)}}</td>
                        <td class="text-caption">{{pago.tipo}}</td>
                        <td class="text-caption">{{$filters.currency(pago.monto)}}</td>
                        <td class="text-caption">{{pago.metodoPago}}</td>
                        <td class="text-caption">{{pago.facturado}}</td>
                        <td class="text-caption">{{pago.user.name}}</td>
                        <td class="text-caption">
                          <q-chip dense size="10px"
                            :color="pago.estado === 'Pendiente' ? 'orange' : pago.estado === 'Aceptado' ? 'green' : 'red'"
                            :label="pago.estado"
                            :icon="pago.estado === 'Pendiente' ? 'schedule' : 'done'"></q-chip>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-caption"/>
                        <td class="text-caption"/>
                        <td class="text-caption">Total:</td>
                        <td class="text-caption text-bold">{{$filters.currencyTotal(pedidoDato.pagos)}}</td>
                        <td class="text-caption"/>
                        <td class="text-caption"/>
                        <td class="text-caption"/>
                      </tr>
                      </thead>
                    </q-markup-table>
<!--                    <pre>{{pedidoDato.pagos}}</pre>-->
                  </div>
                  <div class="col-12 col-md-12 q-mt-md">
                    <q-card flat bordered class="bg-grey-3">
                      <div class="text-bold q-pl-xs">DATOS FACTURACION <span class="text-caption text-grey">{{pedidoDato.facturaA}}</span></div>
                      <q-separator/>
                      <div class="row">
                        <div class="col-12 col-md-4">
                          Cuit/Cui/DNI: <span class="text-bold" v-if="pedidoDato.facturacion"> {{ pedidoDato.facturacion.cuit }}</span>
                        </div>
                        <div class="col-12 col-md-4">
                          Condicional: <span class="text-bold" v-if="pedidoDato.facturacion"> {{ pedidoDato.facturacion.condicional }}</span>
                        </div>
                        <div class="col-12 col-md-4">
                          R. Social: <span class="text-bold" v-if="pedidoDato.facturacion"> {{ pedidoDato.facturacion.razonSocial }}</span>
                        </div>
                        <div class="col-12 col-md-12">
                          Comentario: <span class="text-bold" v-if="pedidoDato.facturacion"> {{ pedidoDato.facturacion.comentario }}</span>
                        </div>
                      </div>
                    </q-card>
                  </div>
                </div>
              </q-tab-panel>
              <q-tab-panel style="height: 300px;width: 650px" name="status">
                <div class="row">
                  <div class="col-12 col-md-12">
                    <q-markup-table wrapCells separator="horizontal" dense>
                      <thead>
                      <tr class="bg-black text-white">
                        <th class="text-left">Fecha</th>
                        <th class="text-left">Hs</th>
                        <th class="text-left">Usuario</th>
                        <th class="text-left">Realizo</th>
                        <th class="text-left">Nota</th>
                      </tr>
                      </thead>
                      <tbody>
                      <tr v-for="statu in pedidoDato.status" :key="statu.id">
                        <td class="text-caption">{{$filters.datedMy(statu.fecha)}}</td>
                        <td class="text-caption">{{$filters.shortTime(statu.hora)}}</td>
                        <td class="text-caption">{{statu.user.name}}</td>
                        <td class="text-caption">{{statu.realizado}}</td>
                        <td class="text-caption">{{statu.nota}}</td>
                      </tr>
                      </tbody>
                    </q-markup-table>
                  </div>
                </div>
              </q-tab-panel>
            </q-tab-panels>
          </q-card>
        </div>
        <div class="row q-mt-md">
          <div class="col-12 col-md-1"/>
          <div class="col-4 col-md-2 text-center q-pa-xs">
            <q-btn no-caps :loading="loading" label="Stand by" color="dark" class="w-100" v-close-popup />
          </div>
          <div class="col-4 col-md-2 text-center q-pa-xs">
            <q-btn no-caps :loading="loading" label="Cancelar" color="red" class="w-100" @click="cancelarClick" />
          </div>
          <div class="col-4 col-md-2 text-center q-pa-xs">
<!--            orange-->
            <q-btn no-caps :loading="loading" label="Corregir" color="grey" class="w-100" :disable="true"/>
          </div>
          <div class="col-4 col-md-2 text-center q-pa-xs">
<!--            blue-->
            <q-btn no-caps :loading="loading" label="Repetir" color="grey" class="w-100" :disable="true"/>
          </div>
          <div class="col-4 col-md-2 text-center q-pa-xs">
            <q-btn no-caps :loading="loading" label="Cerrar" color="grey" class="w-100" v-close-popup />
          </div>
          <div class="col-12 col-md-1"/>
        </div>
<!--        <pre>{{pedido}}</pre>-->
<!--        <pre>{{empresa}}</pre>-->
      </q-form>
    </q-card-section>
    <q-dialog v-model="pagoDialog">
      <q-card>
        <q-card-section class="row items-center q-pb-none">
          <div class="text-subtitle1">Agregar Pago</div>
          <q-space />
          <q-btn flat dense icon="cancel" v-close-popup />
        </q-card-section>
        <q-card-section>
          <q-form>
            <q-input
              filled
              v-model="pago.monto"
              label="Monto"
              type="number"
              color="primary"
              :rules="[val => !!val || 'Campo requerido']"
            />
<!--            Efectivo, Transferencia, Tarjeta, Cheque, Otro');-->
            <q-select
              filled
              v-model="pago.metodoPago"
              label="Metodo de Pago"
              color="primary"
              :options="$metodoPago"
              :rules="[val => !!val || 'Campo requerido']"
            />
            <q-input
              filled
              type="textarea"
              v-model="pago.comentario"
              label="Comentario"
              color="primary"
            />
            <q-btn
              color="primary"
              label="Agregar"
              class="full-width"
              :loading="loading"
              @click="pagoSubmit"
            />
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>
  </q-card>
</template>
<script>

export default {
  name: 'PedidoShowComponent',
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
      pagoDialog: false,
      tab: 'pedido',
      pedidoDato: {},
      loading: false,
      pago: {
        tipo: 'PAGO',
        monto: '0',
        metodoPago: 'EFECTIVO',
        comentario: '',
        pedido_id: this.pedido.id
      }
    }
  },
  mounted () {
    this.pedidoDato = this.pedido
  },
  methods: {
    cancelarClick () {
      this.loading = true
      this.$axios.put(`pedidos/${this.pedido.id}`, { estadoPedido: 'Cancelado' })
        .then(response => {
          this.$alert.success('Pedido cancelado')
          this.pedidoDato = response.data
          this.$emit('empresaSearch', this.empresa)
          this.$emit('closeDialogShowPedido')
        }).catch(error => {
          this.$alert.error(error.response.data.message)
        }).finally(() => {
          this.loading = false
        })
    },
    pagoDialogClick () {
      this.pagoDialog = true
    },
    pagoSubmit () {
      this.loading = true
      this.$axios.post('pagos', this.pago)
        .then(response => {
          this.$alert.success('Pago agregado')
          console.log(response.data)
          this.pedidoDato.pagos.push(response.data)
          this.pedidoDato.pago = parseFloat(this.pedidoDato.pago) + parseFloat(this.pago.monto)
          this.pedidoDato.deuda = parseFloat(this.pedidoDato.deuda) - parseFloat(this.pago.monto)
          this.pago = {
            tipo: 'PAGO',
            monto: '0',
            metodoPago: 'EFECTIVO',
            comentario: '',
            pedido_id: this.pedido.id
          }
          this.pagoDialog = false
        }).catch(error => {
          this.$alert.error(error.response.data.message)
        }).finally(() => {
          this.loading = false
        })
    }
  },
  computed: {
    precioTotal () {
      const precio = parseFloat(this.pedido.precioProducto) + parseFloat(this.pedido.precioDiseno) + parseFloat(this.pedido.precioEnvio) + parseFloat(this.pedido.precioEspecificaciones)
      return Math.round(precio * 100) / 100
    },
    precioIva () {
      // const precio = parseFloat(this.pedido.precioProducto) + parseFloat(this.pedido.precioDiseno) + parseFloat(this.pedido.precioEnvio) + parseFloat(this.pedido.precioEspecificaciones)
      // return Math.round(precio * parseFloat(this.pedido.iva) / 100 * 100) / 100
      if (this.pedido.facturaA === 'Factura ninguna') {
        return 0
      } else if (this.pedido.facturaA === 'Factura pedido') {
        return Math.round(this.precioTotal * parseFloat(this.pedido.iva) / 100 * 100) / 100
      } else if (this.pedido.facturaA === 'Factura seña') {
        return Math.round(this.pedido.pago * parseFloat(this.pedido.iva) / 100 * 100) / 100
      }
      return 0
    }
  }
}
</script>
