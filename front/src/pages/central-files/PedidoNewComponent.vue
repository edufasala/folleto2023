<template>
  <q-card class="q-pa-xs" style="width: 900px;max-width: 900px">
    <q-card-section class="q-py-xs row items-center">
      <div class="text-h5 text-bold"> Pedido Nuevo </div>
      <q-space />
      <div class="text-right text-red text-h6">
        # {{pedido.codigo}} <span class="text-grey">{{empresa.nombre}}</span>
      </div>
      <q-btn flat dense icon="cancel" v-close-popup />
    </q-card-section>
    <q-card-section class="q-py-none">
      <q-form @submit="pedidoSubmit">
        <div class="row">
          <div class="col-12 col-md-6 q-pa-xs">
            <q-select dense outlined v-model="pedido.person" :options="empresa.person" option-value="id" option-label="nombre">
              <template v-slot:before>
                <span class="text-subtitle1">Quien lo pide</span>
              </template>
            </q-select>
          </div>
          <div class="col-12 col-md-6 q-pa-xs">
            <q-select dense outlined v-model="pedido.sucursal" :options="empresa.sucursals" option-value="id" option-label="nombre">
              <template v-slot:before>
                <span class="text-subtitle1">Sucursal</span>
              </template>
            </q-select>
          </div>
        </div>
        <div class="q-mt-md">
          <q-card>
            <q-tabs
              v-model="tab"
              dense
              class="text-grey"
              indicator-color="blue"
              align="justify"
              narrow-indicator
            >
              <q-tab name="pedido" no-caps class="bg-dark text-white">
                  <span class="text-bold">Pedido</span>
              </q-tab>
              <q-tab name="taller" no-caps class="bg-dark text-white">
                  <span class="text-bold">Diseño y Entrega</span>
              </q-tab>
              <q-tab name="pago" no-caps class="bg-dark text-white">
                  <span class="text-bold">Pago y Facturacion</span>
              </q-tab>
              <q-tab name="status" no-caps class="bg-dark text-white">
                  <span class="text-bold">Confimacion</span>
              </q-tab>
            </q-tabs>
            <q-separator />
            <q-tab-panels v-model="tab" animated class="bg-grey-2">
              <q-tab-panel name="pedido">
                <div class="row">
                  <div class="col-6 col-md-2 flex flex-center">Producto:</div>
                  <div class="col-6 col-md-4"><q-select dense outlined v-model="pedido.producto" :options="productos"/></div>
                  <div class="col-6 col-md-2 flex flex-center">Otra:</div>
                  <div class="col-6 col-md-4"><q-input dense outlined v-model="pedido.producto"/></div>
                  <div class="col-6 col-md-2 flex flex-center">Gr:</div>
                  <div class="col-6 col-md-4"><q-select dense outlined v-model="pedido.gr" :options="[150,90]" /></div>
                  <div class="col-6 col-md-2 flex flex-center">Otra:</div>
                  <div class="col-6 col-md-4"><q-input dense outlined v-model="pedido.gr"/></div>
                  <div class="col-6 col-md-2 flex flex-center">Medida:</div>
                  <div class="col-6 col-md-4"><q-select dense outlined v-model="pedido.medida" :options="medidas" /></div>
                  <div class="col-6 col-md-2 flex flex-center">Otra:</div>
                  <div class="col-6 col-md-4"><q-input dense outlined v-model="pedido.medida"/></div>
                  <div class="col-6 col-md-2 flex flex-center">
                    Cantidad:
                  </div>
                  <div class="col-6 col-md-2">
                    <q-input dense outlined v-model="pedido.cantidad" />
                  </div>
                  <div class="col-6 col-md-1 flex flex-center">
                    esp:
                  </div>
                  <div class="col-6 col-md-1">
                    <q-input dense outlined v-model="pedido.espº" />
                  </div>
                  <div class="col-6 col-md-2 flex flex-center">Termin:</div>
                  <div class="col-6 col-md-4"><q-select dense outlined v-model="pedido.terminacion" :options="['Brillante', 'Mate']" /></div>
                  <div class="col-6 col-md-2 flex flex-center text-red text-bold">F Entrega:</div>
                  <div class="col-6 col-md-4"><q-input type="date" dense outlined v-model="pedido.fechaEntrega"/></div>
                  <div class="col-6 col-md-2 flex flex-center">Otra:</div>
                  <div class="col-6 col-md-4"><q-input dense outlined v-model="pedido.terminacion"/></div>
                  <div class="col-6 col-md-2 flex flex-center">F Especial:</div>
                  <div class="col-6 col-md-4"><q-input type="date" dense outlined v-model="pedido.fechaEspecial"/></div>
                  <div class="col-6 col-md-2 flex flex-center">Descripcion:</div>
                  <div class="col-6 col-md-4"><q-input dense outlined v-model="pedido.descripcion"/></div>
                  <div class="col-6 col-md-2 flex flex-center text-green text-bold">Precio</div>
                  <div class="col-6 col-md-4"><q-input dense outlined v-model="pedido.precioProducto"/></div>
                  <div class="col-6 col-md-2 flex flex-center text-green text-bold">Precio:</div>
                  <div class="col-6 col-md-4"><q-input dense outlined v-model="pedido.precioEspecificaciones"/></div>
                </div>
              </q-tab-panel>
              <q-tab-panel name="taller">
                <div class="row">
                  <div class="col-6 col-md-2 flex flex-center">Diseño:</div>
                  <div class="col-6 col-md-4"><q-select dense outlined v-model="pedido.diseno" :options="disenos"/></div>
                  <div class="col-6 col-md-2 flex flex-center">Envio:</div>
                  <div class="col-6 col-md-4"><q-select dense outlined v-model="pedido.envio" :options="['Si', 'No']"/></div>
                  <div class="col-6 col-md-2 flex flex-center">Lados:</div>
                  <div class="col-6 col-md-4"><q-select dense outlined v-model="pedido.lado" :options="lados"/></div>
                  <div class="col-6 col-md-2 flex flex-center">Direccion:</div>
                  <div class="col-6 col-md-4"><q-select dense outlined v-model="pedido.direccion" :options="empresa.direccion" option-value="id" option-label="direccion"/></div>
                  <div class="col-6 col-md-2 flex flex-center">Especificaciones:</div>
                  <div class="col-6 col-md-4"><q-input type="textarea" dense outlined v-model="pedido.especificaciones"/></div>
                  <div class="col-6">
                    <div class="row">
                      <div class="col-6 col-md-4 flex flex-center">Localidad:</div>
                      <div class="col-6 col-md-8"><q-input dense outlined v-model="pedido.direccion.localidad" readonly v-if="pedido.direccion"/></div>
                      <div class="col-6 col-md-4 flex flex-center">CodigoPostal:</div>
                      <div class="col-6 col-md-8"><q-input dense outlined v-model="pedido.direccion.codigoPostal" readonly v-if="pedido.direccion"/></div>
                      <div class="col-6 col-md-4 flex flex-center">Descripcion:</div>
                      <div class="col-6 col-md-8"><q-input dense outlined v-model="pedido.descripcion"/></div>
                    </div>
                  </div>
                  <div class="col-6 col-md-2 flex flex-center text-green text-bold">Precio Diseño:</div>
                  <div class="col-6 col-md-4"><q-input dense outlined v-model="pedido.precioDiseno" /></div>
                  <div class="col-6 col-md-2 flex flex-center text-green text-bold">Envio:</div>
                  <div class="col-6 col-md-4"><q-input dense outlined v-model="pedido.precioEnvio"/></div>
                </div>
              </q-tab-panel>
              <q-tab-panel name="pago">
                <div class="row">
                  <div class="col-6 col-md-2 flex flex-center">Pago:</div>
                  <div class="col-6 col-md-4"><q-input dense outlined v-model="pedido.pago" /></div>
                  <div class="col-6 col-md-1 flex flex-center">Iva:</div>
                  <div class="col-6 col-md-2"><q-input dense outlined v-model="pedido.iva" /></div>
                  <div class="col-6 col-md-2 flex flex-center">SeFactura:</div>
                  <div class="col-6 col-md-1"><q-select dense outlined v-model="pedido.seFacturo" :options="['Si','No']" /></div>
                  <div class="col-12 col-md-6">
                    <div class="row">
                      <div class="col-6 col-md-4 flex flex-center">Metodo de $:</div>
                      <div class="col-6 col-md-8"><q-select dense outlined v-model="pedido.metodoPago" :options="['Efectivo', 'Tarjeta', 'Transferencia']"/></div>
                      <div class="col-6 col-md-4 flex flex-center">CUIT/DNI:</div>
                      <div class="col-6 col-md-8"><q-select dense outlined v-model="pedido.facturacion" :options="empresa.facturacion" option-value="id" option-label="cuit"/></div>
                      <div class="col-6 col-md-4 flex flex-center">Condicional:</div>
                      <div class="col-6 col-md-8"><q-input dense outlined v-model="pedido.facturacion.condicional" readonly v-if="pedido.facturacion"/></div>
                      <div class="col-6 col-md-4 flex flex-center">Razon social:</div>
                      <div class="col-6 col-md-8"><q-input dense outlined v-model="pedido.facturacion.razonSocial" readonly v-if="pedido.facturacion"/></div>
                      <div class="col-6 col-md-4 flex flex-center">Comentario:</div>
                      <div class="col-6 col-md-8"><q-input dense outlined v-model="pedido.comentarioPago"/></div>
                    </div>
                  </div>
                  <div class="col-12 col-md-6">
                    <q-card>
                      <q-card-section class="row q-pa-lg">
                        <div class="col-6 col-md-6 flex flex-center">Subtotal:</div>
                        <div class="col-6 col-md-6"><div class="text-bold text-right">${{precioTotal}}</div></div>
                        <div class="col-6 col-md-6 flex flex-center">Iva:</div>
                        <div class="col-6 col-md-6"><div class="text-bold text-right">${{precioIva}}</div></div>
                        <div class="col-6 col-md-6 bg-dark text-white flex flex-center">Total:</div>
                        <div class="col-6 col-md-6 bg-dark text-white"><div class="text-bold text-right">${{precioTotal + precioIva}}</div></div>
                        <div class="col-6 col-md-6 flex flex-center">Seña:</div>
                        <div class="col-6 col-md-6"><div class="text-bold text-right">${{pedido.pago}}</div></div>
                        <div class="col-6 col-md-6 flex flex-center">Deuda:</div>
                        <div class="col-6 col-md-6"><div class="text-bold text-right text-red">${{deuda}}</div></div>
                      </q-card-section>
                    </q-card>
                  </div>
                </div>
              </q-tab-panel>
              <q-tab-panel name="status">
                <div class="row">
                  <div class="col-12 col-md-12">
                    <q-markup-table wrapCells separator="horizontal" dense>
                      <thead>
                      <tr class="bg-black text-white">
                        <th class="text-left">Cant.</th>
                        <th class="text-left">Descripcion</th>
                        <th class="text-left">Gr</th>
                        <th class="text-left">Tamaño</th>
                        <th class="text-left">Entrega</th>
                        <th class="text-right">Precio</th>
                      </tr>
                      </thead>
                      <tbody>
                      <tr>
                        <td class="text-left">{{pedido.cantidad}}</td>
                        <td class="text-left">{{pedido.producto}}</td>
                        <td class="text-left">{{pedido.gr}}</td>
                        <td class="text-left">{{pedido.medida}}</td>
                        <td class="text-left">{{pedido.fechaEntrega}}</td>
                        <td class="text-right">${{pedido.precioProducto}}</td>
                      </tr>
                      <tr>
                        <td class="text-left">1</td>
                        <td class="text-left">{{pedido.diseno}}</td>
                        <td class="text-left"></td>
                        <td class="text-left">{{pedido.lado}}</td>
                        <td class="text-left"></td>
                        <td class="text-right">${{pedido.precioDiseno}}</td>
                      </tr>
                      <tr>
                        <td class="text-left">1</td>
                        <td class="text-left">Envio {{pedido.envio}}</td>
                        <td class="text-left">
                          <template v-if="pedido.envio=='Si'">
                            {{pedido.direccion.localidad}}
                          </template>
                        </td>
                        <td class="text-left"></td>
                        <td class="text-left"></td>
                        <td class="text-right">${{pedido.precioEnvio}}</td>
                      </tr>
                      <tr>
                        <td class="text-left">1</td>
                        <td class="text-left">Especificaciones</td>
                        <td class="text-left"></td>
                        <td class="text-left"></td>
                        <td class="text-left"></td>
                        <td class="text-right">${{pedido.precioEspecificaciones}}</td>
                      </tr>
                      <tr>
                        <td class="text-left">1</td>
                        <td class="text-left">Iva {{pedido.iva}}%</td>
                        <td class="text-left"></td>
                        <td class="text-left"></td>
                        <td class="text-left"></td>
                        <td class="text-right">${{precioIva}}</td>
                      </tr>
                      <tr>
                        <td colspan="5" class="text-right text-bold">Total</td>
                        <td class="text-right bg-black text-white text-bold">${{precioTotal + precioIva}}</td>
                      </tr>
                      <tr>
                        <td colspan="5" class="text-right text-bold ">Seña</td>
                        <td class="text-right text-bold ">${{pedido.pago}}</td>
                      </tr>
                      <tr>
                        <td colspan="5" class="text-right text-bold text-red">Deuda</td>
                        <td class="text-right text-bold text-red">${{deuda}}</td>
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
          <div class="col-12 col-md-8"/>
          <div class="col-4 col-md-2 text-center q-pa-xs">
            <q-btn no-caps label="Anterior" color="grey" class="w-100" @click="anterior"/>
          </div>
          <div class="col-4 col-md-2 text-center q-pa-xs">
            <q-btn no-caps label="Siguiente" color="blue" class="w-100" @click="siguiente" v-if="tab!='status'"/>
            <q-btn no-caps label="Confirmar" :loading="loading" color="green" class="w-100" @click="confimar" v-if="tab=='status'"/>
          </div>
        </div>
<!--        <pre>{{pedido}}</pre>-->
<!--        <pre>{{empresa}}</pre>-->
      </q-form>
    </q-card-section>
  </q-card>
</template>
<script>

export default {
  name: 'PedidoNewComponent',
  props: {
    empresa: {
      type: Object,
      required: true
    },
    pedidoDato: {
      type: Object,
      required: true
    }
  },
  data () {
    return {
      tab: 'pedido',
      pedido: {},
      loading: false,
      productos: ['Folletos', 'Tarjetas', 'Afiches', 'Banner', 'Diseño', 'Logo', 'Otros'],
      medidas: ['10x15', '15x21', '21x30', '30x40', '40x50', '50x70', '70x100', '100x140', '140x200', '200x300'],
      cantidades: ['100', '200', '300', '400', '500', '600', '700', '800', '900', '1000'],
      lados: ['1 lado solo', '2 lados iguales', '2 lados diferentes'],
      disenos: ['nuevo', 'envia el cliente', 'correccion', 'mismo diseno']
    }
  },
  mounted () {
    this.pedido = this.pedidoDato
  },
  methods: {
    anterior () {
      if (this.tab === 'status') {
        this.tab = 'pago'
      } else if (this.tab === 'pago') {
        this.tab = 'taller'
      } else if (this.tab === 'taller') {
        this.tab = 'pedido'
      }
    },
    siguiente () {
      if (this.tab === 'pedido') {
        this.tab = 'taller'
      } else if (this.tab === 'taller') {
        this.tab = 'pago'
      } else if (this.tab === 'pago') {
        this.tab = 'status'
      }
    },
    pedidoSubmit () {
      // this.$emit('pedidoSubmit', this.pedido)
    },
    confimar () {
      if (this.precioTotal <= 0) {
        this.$alert.error('El precio total no puede ser menor o igual a 0')
        return false
      }
      this.$q.dialog({
        title: 'Confirmar Pedido',
        message: 'Esta seguro que desea confirmar el pedido?',
        cancel: true,
        persistent: true
      }).onOk(() => {
        this.loading = true
        this.$axios.post('pedidos', this.pedido)
          .then(response => {
            this.loading = false
            this.$alert.success('Pedido confirmado')
            this.$emit('empresaSearch', this.empresa)
            this.$emit('closeDialog')
          })
          .catch(error => {
            this.loading = false
            this.$alert.error(error.response.data.message)
          })
      })
    }
  },
  computed: {
    precioTotal () {
      const precio = parseFloat(this.pedido.precioProducto) + parseFloat(this.pedido.precioDiseno) + parseFloat(this.pedido.precioEnvio) + parseFloat(this.pedido.precioEspecificaciones)
      return Math.round(precio * 100) / 100
    },
    precioIva () {
      const precio = parseFloat(this.pedido.precioProducto) + parseFloat(this.pedido.precioDiseno) + parseFloat(this.pedido.precioEnvio) + parseFloat(this.pedido.precioEspecificaciones)
      return Math.round(precio * parseFloat(this.pedido.iva) / 100 * 100) / 100
    },
    deuda () {
      const precio = parseFloat(this.pedido.precioProducto) + parseFloat(this.pedido.precioDiseno) + parseFloat(this.pedido.precioEnvio) + parseFloat(this.pedido.precioEspecificaciones)
      const iva = precio * parseFloat(this.pedido.iva / 100)
      const deuda = parseFloat(precio) + parseFloat(iva) - parseFloat(this.pedido.pago)
      return Math.round(deuda * 100) / 100
    }
  }
}
</script>
