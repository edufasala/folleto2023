<template>
  <q-card class="q-pa-xs" style="max-width: 900px">
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
              <q-tab name="$" no-caps class="bg-dark text-white">
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
                  <div class="col-4 col-md-2">Producto</div>
                  <div class="col-8 col-md-6 text-bold">{{ pedido.producto }}</div>
                  <div class="col-4 col-md-2">Medida</div>
                  <div class="col-8 col-md-2 text-bold">{{ pedido.medida }}</div>
                  <div class="col-4 col-md-2">Cantidad</div>
                  <div class="col-8 col-md-4 text-bold">{{ pedido.cantidad }}</div>
                  <div class="col-4 col-md-1">Esp.</div>
                  <div class="col-8 col-md-1 text-bold q-pr-md">{{ pedido.esp }}</div>
                  <div class="col-4 col-md-2">Gr.</div>
                  <div class="col-8 col-md-2 text-bold">{{ pedido.gr }}</div>
                  <div class="col-4 col-md-2">Lados</div>
                  <div class="col-8 col-md-4 text-bold">{{ pedido.lados }}</div>
                  <div class="col-4 col-md-2">Diseño</div>
                  <div class="col-6 col-md-4 text-bold">{{ pedido.diseno }}</div>
                  <div class="col-4 col-md-2">Descripcion</div>
                  <div class="col-8 col-md-10 border-round">{{ pedido.descripcion }}</div>
                </div>
              </q-tab-panel>
              <q-tab-panel name="taller">
                <div class="row">
                  <div class="col-4 col-md-2">Terminacion</div>
                  <div class="col-8 col-md-6 text-bold">{{ pedido.terminacion }}</div>
                  <div class="col-4 col-md-2">Envio</div>
                  <div class="col-8 col-md-2 text-bold">{{ pedido.envio }}</div>
                  <div class="col-12 col-md-6">
                    <div class="row">
                      <div class="col-4">Descripcion</div>
                      <div class="col-8 text-bold border-round">{{ pedido.especificaciones }}</div>
                    </div>
                  </div>
                  <div class="col-12 col-md-6">
                    <div :class="`row ${$q.screen.lt.md ? '' : 'q-ml-md'}`">
                      <div class="col-4">Direccion</div>
                      <div class="col-8 text-bold">{{ pedido.direccion.direccion }}</div>
                      <div class="col-4">Localidad</div>
                      <div class="col-8 text-bold">{{ pedido.direccion.localidad }}</div>
                      <div class="col-4">CP:</div>
                      <div class="col-8 text-bold">{{ pedido.direccion.codigoPostal }}</div>
                      <div class="col-4">Descripcion:</div>
                      <div class="col-8 text-bold">{{ pedido.descripcion }}</div>
                    </div>
                  </div>
                </div>
              </q-tab-panel>
              <q-tab-panel name="$">
                <div class="row">
                  <div class="col-12 col-md-4">
                    <q-card flat bordered>
                      <div class="text-bold text-center">RESUMEN</div>
                      <q-separator/>
                      <div class="q-pa-xs">
                        <div class="row items-center q-px-xs">
                          Producto
                          <q-space />
                          <div class="text-bold">$ {{ pedido.precioProducto }}</div>
                        </div>
                        <div class="row items-center q-px-xs">
                          Diseño
                          <q-space />
                          <div class="text-bold">$ {{ pedido.precioDiseno }}</div>
                        </div>
                        <div class="row items-center q-px-xs">
                          Terminacion
                          <q-space />
                          <div class="text-bold">$ {{ pedido.precioEspecificaciones }}</div>
                        </div>
                        <div class="row items-center q-px-xs">
                          Envio
                          <q-space />
                          <div class="text-bold">$ {{ pedido.precioEnvio }}</div>
                        </div>
                        <div class="row items-center q-px-xs">
                          IVA <span class="text-red">({{pedido.iva}})</span>
                          <q-space />
                          <div class="text-bold">$ {{ $filters.iva(pedido.precioTotal, pedido.iva) }}</div>
                        </div>
                        <div class="row items-center q-px-xs bg-black text-white">
                          TOTAL
                          <q-space />
                          <div class="text-bold">$ {{ pedido.precioTotal }}</div>
                        </div>
                        <div class="row items-center q-px-xs">
                          Seña
                          <q-space />
                          <div class="text-bold">$ {{ pedido.pago }}</div>
                        </div>
                        <div class="row items-center q-px-xs">
                          Deuda
                          <q-space />
                          <div class="text-bold text-red">$ {{ pedido.deuda }}</div>
                        </div>
                      </div>
                    </q-card>
                  </div>
                  <div class="col-12 col-md-8 q-px-md">
                    <div class="text-h6">
                      Pagos
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
                        </tr>
                      </thead>
                      <thead>
                      <tr v-for="pago in pedido.pagos" :key="pago.id">
                        <td class="text-caption">{{$filters.datedMy(pago.fecha)}}</td>
                        <td class="text-caption">{{$filters.shortTime(pago.hora)}}</td>
                        <td class="text-caption">{{pago.tipo}}</td>
                        <td class="text-caption">{{$filters.currency(pago.monto)}}</td>
                        <td class="text-caption">{{pago.metodoPago}}</td>
                        <td class="text-caption">{{pago.facturado}}</td>
                        <td class="text-caption">{{pago.user.name}}</td>
                      </tr>
                      </thead>
                    </q-markup-table>
<!--                    <pre>{{pedido.pagos}}</pre>-->
                  </div>
                  <div class="col-12 col-md-12 q-mt-md">
                    <q-card flat bordered class="bg-grey-3">
                      <div class="text-bold q-pl-xs">DATOS FACTURACION</div>
                      <q-separator/>
                      <div class="row">
                        <div class="col-12 col-md-4">
                          Cuit/Cui/DNI: <span class="text-bold"> {{ pedido.facturacion.cuit }}</span>
                        </div>
                        <div class="col-12 col-md-4">
                          Condicional: <span class="text-bold"> {{ pedido.facturacion.condicional }}</span>
                        </div>
                        <div class="col-12 col-md-4">
                          R. Social: <span class="text-bold"> {{ pedido.facturacion.razonSocial }}</span>
                        </div>
                        <div class="col-12 col-md-12">
                          Comentario: <span class="text-bold"> {{ pedido.facturacion.comentario }}</span>
                        </div>
                      </div>
                    </q-card>
                  </div>
                </div>
              </q-tab-panel>
              <q-tab-panel name="status">
                <div class="row">
                  <div class="col-12 col-md-12">
                    <q-markup-table wrapCells separator="horizontal">
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
                      <tr v-for="statu in pedido.status" :key="statu.id">
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
            <q-btn no-caps label="Stand by" color="dark" class="w-100" />
          </div>
          <div class="col-4 col-md-2 text-center q-pa-xs">
            <q-btn no-caps label="Cancelar" color="red" class="w-100" />
          </div>
          <div class="col-4 col-md-2 text-center q-pa-xs">
            <q-btn no-caps label="Corregir" color="orange" class="w-100" />
          </div>
          <div class="col-4 col-md-2 text-center q-pa-xs">
            <q-btn no-caps label="Repetir" color="blue" class="w-100" />
          </div>
          <div class="col-4 col-md-2 text-center q-pa-xs">
            <q-btn no-caps label="Cerrar" color="grey" class="w-100" />
          </div>
          <div class="col-12 col-md-1"/>
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
      loading: false
    }
  },
  mounted () {
    this.pedido = this.pedidoDato
  },
  methods: {
    pedidoSubmit () {
      // this.loading = true
      // this.$emit('pedidoSubmit', this.pedidoDato)
    }
  }
}
</script>
