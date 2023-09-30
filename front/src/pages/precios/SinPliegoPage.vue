<template>
  <div>
    <q-table :filter="filter" dense :rows="datos" :loading="loading" :rows-per-page-options="[0,20,50,100]" :columns="columns" no-data-label="No hay datos">
      <template v-slot:top-right>
        <q-btn color="primary" label="Crear" icon="add_circle_outline" @click="crear" no-caps/>
        <q-input v-model="filter" outlined dense debounce="500" placeholder="Buscar...">
          <template v-slot:append>
            <q-icon name="search"/>
          </template>
        </q-input>
      </template>
      <template v-slot:body-cell-actions="props">
        <q-td :props="props">
          <q-btn color="primary" flat size="12px" dense rounded icon="edit" @click="editar(props.row)" />
          <q-btn color="negative" flat size="12px" dense rounded icon="delete" @click="eliminar(props.row)" />
        </q-td>
      </template>
    </q-table>
    <q-dialog v-model="dialog">
      <q-card>
        <q-card-section class="row items-center">
          <div class="text-h6">{{dialogOption==='create'?'Crear':'Editar'}} Producto/Servicio</div>
          <q-space/>
          <q-btn color="negative" flat round dense icon="close" v-close-popup/>
        </q-card-section>
        <q-card-section>
          <q-card>
            <q-card-section>
              <q-form @submit="submit">
                <q-input v-model="dato.productoServicio" label="Producto/Servicio" outlined dense/>
                <q-input v-model="dato.imprime" label="Imprime" outlined dense/>
                <q-input v-model="dato.nombre" label="Nombre" outlined dense/>
                <q-input v-model="dato.tipoMaterial" label="Tipo de Material" outlined dense/>
                <q-input v-model="dato.gr" label="Gr" outlined dense/>
                <q-input v-model="dato.tamano" label="Tamaño" outlined dense/>
                <q-input v-model="dato.seModifica" label="Se Modifica" outlined dense/>
                <q-input v-model="dato.fracciona" label="Fracciona" outlined dense/>
                <q-input v-model="dato.espacios" label="Espacios" outlined dense/>
                <q-input v-model="dato.desde" label="Desde" outlined dense/>
                <q-input v-model="dato.hasta" label="Hasta" outlined dense/>
                <q-input v-model="dato.precio" label="Precio" outlined dense/>
                <q-input v-model="dato.comentario" label="Comentario" outlined dense/>
                <q-card-actions align="right">
                  <q-btn color="primary" label="Guardar" type="submit"/>
                  <q-btn color="negative" label="Cancelar" @click="dialog = false"/>
                </q-card-actions>
              </q-form>
            </q-card-section>
          </q-card>
        </q-card-section>
      </q-card>
    </q-dialog>
    <pre>{{datos}}</pre>
  </div>
</template>
<script>
export default {
  name: 'SinPliegoPage',
  data () {
    return {
      loading: false,
      dialog: false,
      dialogOption: '',
      filter: '',
      datos: [],
      dato: {
        productoServicio: '',
        imprime: '',
        nombre: '',
        tipoMaterial: '',
        gr: '',
        tamano: '',
        seModifica: '',
        fracciona: '',
        espacios: '',
        desde: '',
        hasta: '',
        precio: '',
        comentario: ''
      },
      columns: [
        { name: 'actions', label: 'Acciones', field: 'actions', align: 'center', sortable: false },
        { name: 'productoServicio', label: 'Producto/Servicio', field: 'productoServicio', align: 'center', sortable: true },
        { name: 'imprime', label: 'Imprime', field: 'imprime', align: 'center', sortable: true },
        { name: 'nombre', label: 'Nombre', field: 'nombre', align: 'left', sortable: true },
        { name: 'tipoMaterial', label: 'Tipo de Material', field: 'tipoMaterial', align: 'center', sortable: true },
        { name: 'gr', label: 'Gr', field: 'gr', align: 'center', sortable: true },
        { name: 'tamano', label: 'Tamaño', field: 'tamano', align: 'center', sortable: true },
        { name: 'seModifica', label: 'Se Modifica', field: 'seModifica', align: 'center', sortable: true },
        { name: 'fracciona', label: 'Fracciona', field: 'fracciona', align: 'center', sortable: true },
        { name: 'espacios', label: 'Espacios', field: 'espacios', align: 'center', sortable: true },
        { name: 'desde', label: 'Desde', field: 'desde', align: 'center', sortable: true },
        { name: 'hasta', label: 'Hasta', field: 'hasta', align: 'center', sortable: true },
        { name: 'precio', label: 'Precio', field: 'precio', align: 'center', sortable: true },
        { name: 'comentario', label: 'Comentario', field: 'comentario', align: 'center', sortable: true }
      ]
    }
  },
  mounted () {
    this.datosGet()
  },
  methods: {
    crear () {
      // this.$router.push({name: 'preciosSinPliegoCrear'})
    },
    async datosGet () {
      this.loading = true
      this.datos = (await this.$axios.get('sinPliegos')).data
      this.loading = false
      console.log(this.datos)
    }
  }
}
</script>
