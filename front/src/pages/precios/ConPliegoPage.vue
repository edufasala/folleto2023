<template>
  <div>
    <q-table :filter="filter" dense :rows="datos" :loading="loading" :rows-per-page-options="[0,20,50,100]" :columns="columns" no-data-label="No hay datos">
      <template v-slot:top-right>
        <q-btn color="primary" label="Crear" icon="add_circle_outline" @click="crear" no-caps :loading="loading"/>
        <q-input v-model="filter" outlined dense debounce="500" placeholder="Buscar...">
          <template v-slot:append>
            <q-icon name="search"/>
          </template>
        </q-input>
      </template>
      <template v-slot:body-cell-actions="props">
        <q-td :props="props">
          <q-btn color="primary" flat size="12px" dense rounded icon="edit" @click="editar(props.row)" :loading="loading"/>
          <q-btn color="negative" flat size="12px" dense rounded icon="delete" @click="eliminar(props.row)" :loading="loading"/>
        </q-td>
      </template>
    </q-table>
    <q-dialog v-model="dialog">
      <q-card>
        <q-card-section class="row items-center q-pa-xs">
          <div class="text-h6">{{dialogOption==='create'?'Crear':'Editar'}} Producto/Servicio</div>
          <q-space/>
          <q-btn color="negative" flat round dense icon="close" v-close-popup/>
        </q-card-section>
        <q-card-section class="q-pa-md">
              <q-form @submit="submit">
                <q-select v-model="dato.productoServicio" label="Producto/Servicio" outlined dense
                          :options="['Producto', 'Servicio']"/>
                <q-select v-model="dato.imprime" label="Imprime" outlined dense
                          :options="['Digital', 'Offset', 'Plotter', '-']"/>
                <q-input v-model="dato.nombre" label="Nombre" outlined dense/>
                <q-select v-model="dato.tipoMaterial" label="Tipo de Material" outlined dense
                          :options="['Iman 0,3', 'Ilustracion', 'Lona', 'Lona Black out', 'Autoadhesivo', 'Vinilo', 'Papel Obra', 'Cartulina', '-']"/>
                <q-select v-model="dato.gr" label="Gr" outlined dense
                          :options="['1', '70', '150', '300', '-']"/>
                <q-select v-model="dato.tamano" label="Tamaño" outlined dense
                          :options="['31x46', '100x100', '90x190', '55x74', '102x72', '30x40', '10x15', '10x10']"/>
                <q-select v-model="dato.fracciona" label="Fracciona" outlined dense
                          :options="['1', '0,5', '250', '375', '500', '1000', '-']"/>
                <q-select v-model="dato.porLado" label="Por Lado" outlined dense
                          :options="['1', '0,5']"/>
                <q-input v-model="dato.desde" label="Desde" outlined dense/>
                <q-input v-model="dato.hasta" label="Hasta" outlined dense/>
                <q-input v-model="dato.precio" label="Precio" outlined dense/>
                <q-input v-model="dato.comentario" label="Comentario" outlined dense/>
                <q-card-actions align="right">
                  <q-btn color="primary" type="submit" :label="dialogOption==='create'?'Crear':'Editar'" :loading="loading"/>
                  <q-btn color="negative" label="Cancelar" @click="dialog = false" :loading="loading"/>
                </q-card-actions>
              </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>
    <pre>{{datos}}</pre>
  </div>
</template>
<script>
export default {
  name: 'ConPliegoPage',
  data () {
    return {
      loading: false,
      dialog: false,
      dialogOption: '',
      filter: '',
      datos: [],
      dato: {
        productoServicio: 'Producto', // 'Producto' o 'Servicio'
        imprime: 'Digital', // 'Digital' o 'Offset' o 'Plotter' o '-'
        nombre: '',
        tipoMaterial: 'Iman 0,3', // 'Iman 0,3' 'Ilustracion' 'Lona' 'Lona Black out' o 'Autoadhesivo' o 'Vinilo' o 'Papel Obra' o 'Cartulina' o '-'
        gr: '1', // '1' o '70' o '150' o '300' o '-'
        tamano: '31x46', // '31x46' o '100x100' o '90x190' o '55x74' o '102x72' o '30x40' o '10x15' o '10x10'
        fracciona: '1', // '1' o '0,5' o '250' o '375' o '500' o '1000' o '-'
        porLado: '1', // '1' o '0,5'
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
        { name: 'fracciona', label: 'Fracciona', field: 'fracciona', align: 'center', sortable: true },
        { name: 'porLado', label: 'Por Lado', field: 'porLado', align: 'center', sortable: true },
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
    editar (dato) {
      this.dialogOption = 'edit'
      this.dialog = true
      this.dato = dato
    },
    eliminar (dato) {
      this.$q.dialog({
        title: 'Confirmar',
        message: '¿Está seguro de eliminar este registro?',
        cancel: true,
        persistent: true
      }).onOk(() => {
        this.$axios.delete(`conPliegos/${dato.id}`).then(() => {
          this.datosGet()
        })
      })
    },
    submit () {
      this.loading = true
      if (this.dialogOption === 'create') {
        this.$axios.post('conPliegos', this.dato).then(() => {
          this.datosGet()
          this.dialog = false
        }).finally(() => {
          this.loading = false
        })
      } else {
        this.$axios.put(`conPliegos/${this.dato.id}`, this.dato).then(() => {
          this.datosGet()
          this.dialog = false
        }).finally(() => {
          this.loading = false
        })
      }
    },
    crear () {
      this.dialogOption = 'create'
      this.dialog = true
      this.dato = {
        productoServicio: 'Producto', // 'Producto' o 'Servicio'
        imprime: 'Digital', // 'Digital' o 'Offset' o 'Plotter' o '-'
        nombre: '',
        tipoMaterial: 'Iman 0,3', // 'Iman 0,3' 'Ilustracion' 'Lona' 'Lona Black out' o 'Autoadhesivo' o 'Vinilo' o 'Papel Obra' o 'Cartulina' o '-'
        gr: '1', // '1' o '70' o '150' o '300' o '-'
        tamano: '31x46', // '31x46' o '100x100' o '90x190' o '55x74' o '102x72' o '30x40' o '10x15' o '10x10'
        fracciona: '1', // '1' o '0,5' o '250' o '375' o '500' o '1000' o '-'
        porLado: '1', // '1' o '0,5'
        desde: '',
        hasta: '',
        precio: '',
        comentario: ''
      }
    },
    async datosGet () {
      this.loading = true
      this.datos = (await this.$axios.get('conPliegos')).data
      this.loading = false
      console.log(this.datos)
    }
  }
}
</script>
