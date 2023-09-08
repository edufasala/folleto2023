<template>
  <q-card class="q-pa-xs" style="max-width: 900px">
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
      tab: 'pedido',
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
