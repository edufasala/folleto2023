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
            <q-select v-model="dato.nombre" :options="['Doblado Diptico', 'Doblado Triptico', 'Trazado', 'Doblado + Trazado', 'Pegado', 'Agujereado', 'Redondeado', 'Puntillado', 'Numerado', 'Interado', 'Cortado', 'Bolsillos x1', 'Bolsillos x2']" label="Nombre" outlined dense/>
            <q-select v-model="dato.gr" :options="['150', '400', '-']" label="Gr" outlined dense/>
            <q-select v-model="dato.tamanoMaximo" :options="['20x30', '40x60', '20x15', '-', '150 cm']" label="Tamaño Maximo" outlined dense/>
            <q-select v-model="dato.tamanoMinimo" :options="['10x15', '3,5x3,5', '-']" label="Tamaño Minimo" outlined dense/>
            <q-select v-model="dato.desde" :options="['1', '2.5', '5', '10', '20', '-', '']" label="Desde" outlined dense/>
            <q-input v-model="dato.precio" type="number" label="Precio" outlined dense/>
            <q-input v-model="dato.primeros1000" type="number" label="Primeros 1000" outlined dense/>
            <q-input v-model="dato.siguientes1000" type="number" label="Siguientes 1000" outlined dense/>
            <q-input v-model="dato.comentario" label="Comentario" outlined dense/>
            <q-card-actions align="right">
              <q-btn color="primary" type="submit" :label="dialogOption==='create'?'Crear':'Editar'" :loading="loading"/>
              <q-btn color="negative" label="Cancelar" @click="dialog = false" :loading="loading"/>
            </q-card-actions>
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>
  </div>
</template>
<script>
export default {
  name: 'TerminacionesPage',
  data () {
    return {
      loading: false,
      dialog: false,
      dialogOption: '',
      filter: '',
      datos: [],
      dato: {
        nombre: 'Doblado Diptico', // 'Doblado Diptico' o 'Doblado Triptico' o 'Trazado' o 'Doblado + Trazado' o 'Pegado' o 'Agujereado' o 'Redondeado' o 'Puntillado' o 'Numerado' o 'Interado' o 'Cortado' o 'Bolsillos x1' o 'Bolsillos x2'
        gr: '150', // '150' o '400' o '-'
        tamanoMaximo: '20x30', // '20x30' o '40x60' o '20x15' o '-' o '150 cm'
        tamanoMinimo: '', // '10x15' o '3,5x3,5' o '-'
        desde: '', // '1' o '2.5' o '5' o '10' o '20' o '-' o ''
        precio: 0,
        primeros1000: 7,
        siguientes1000: 1,
        comentario: ''
      },
      columns: [
        { name: 'actions', label: 'Acciones', field: 'actions', align: 'center', sortable: false },
        { name: 'nombre', label: 'Nombre', field: 'nombre', align: 'left', sortable: true },
        { name: 'gr', label: 'Gr', field: 'gr', align: 'left', sortable: true },
        { name: 'tamanoMaximo', label: 'Tamaño Maximo', field: 'tamanoMaximo', align: 'left', sortable: true },
        { name: 'tamanoMinimo', label: 'Tamaño Minimo', field: 'tamanoMinimo', align: 'left', sortable: true },
        { name: 'desde', label: 'Desde', field: 'desde', align: 'left', sortable: true },
        { name: 'precio', label: 'Precio', field: 'precio', align: 'left', sortable: true },
        { name: 'primeros1000', label: 'Primeros 1000', field: 'primeros1000', align: 'left', sortable: true },
        { name: 'siguientes1000', label: 'Siguientes 1000', field: 'siguientes1000', align: 'left', sortable: true },
        { name: 'comentario', label: 'Comentario', field: 'comentario', align: 'left', sortable: true }
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
        this.$axios.delete(`productoTerminaciones/${dato.id}`).then(() => {
          this.datosGet()
        })
      })
    },
    submit () {
      this.loading = true
      if (this.dialogOption === 'create') {
        this.$axios.post('productoTerminaciones', this.dato).then(() => {
          this.datosGet()
          this.dialog = false
        }).finally(() => {
          this.loading = false
        })
      } else {
        this.$axios.put(`productoTerminaciones/${this.dato.id}`, this.dato).then(() => {
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
        nombre: 'Doblado Diptico', // 'Doblado Diptico' o 'Doblado Triptico' o 'Trazado' o 'Doblado + Trazado' o 'Pegado' o 'Agujereado' o 'Redondeado' o 'Puntillado' o 'Numerado' o 'Interado' o 'Cortado' o 'Bolsillos x1' o 'Bolsillos x2'
        gr: '150', // '150' o '400' o '-'
        tamanoMaximo: '20x30', // '20x30' o '40x60' o '20x15' o '-' o '150 cm'
        tamanoMinimo: '', // '10x15' o '3,5x3,5' o '-'
        desde: '', // '1' o '2.5' o '5' o '10' o '20' o '-' o ''
        precio: 0,
        primeros1000: 7,
        siguientes1000: 1,
        comentario: ''
      }
    },
    async datosGet () {
      this.loading = true
      this.datos = (await this.$axios.get('productoTerminaciones')).data
      this.loading = false
      console.log(this.datos)
    }
  }
}
</script>
