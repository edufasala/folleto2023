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
                <q-select v-model="dato.diseno" outlined :options="['Nuevo', 'Correccion']" label="Diseno" :loading="loading"/>
                <q-select v-model="dato.tamano" outlined :options="['9x5', '10x10', '10x15', '20x15', '20x30', '30x40', '40x50', '50x70', '100x70']" label="Tamaño" :loading="loading"/>
                <q-select v-model="dato.lado" outlined :options="['1 Lado', '2 Lado']" label="Lado" :loading="loading"/>
                <q-input v-model="dato.precio" outlined label="Precio" :loading="loading"/>
                <q-input v-model="dato.comentario" outlined label="Comentario" :loading="loading"/>
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
  name: 'DisenoPage',
  data () {
    return {
      loading: false,
      dialog: false,
      dialogOption: '',
      filter: '',
      datos: [],
      dato: {
        diseno: 'Nuevo', // 'Nuevo' o 'Correccion',
        tamano: '9x5', // '9x5' o '10x10' o '10x15' o '20x15' o '20x30' o '30x40' o '40x50' o '50x70' o '100x70'
        lado: '1 Lado', // '1 Lado' o '2 Lado'
        precio: '',
        comentario: ''
      },
      columns: [
        { name: 'actions', label: 'Acciones', field: 'actions', align: 'center', sortable: false },
        { name: 'diseno', label: 'Diseno', field: 'diseno', align: 'center', sortable: true },
        { name: 'tamano', label: 'Tamaño', field: 'tamano', align: 'center', sortable: true },
        { name: 'lado', label: 'Lado', field: 'lado', align: 'center', sortable: true },
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
        this.$axios.delete(`productoDiseno/${dato.id}`).then(() => {
          this.datosGet()
        })
      })
    },
    submit () {
      this.loading = true
      if (this.dialogOption === 'create') {
        this.$axios.post('productoDiseno', this.dato).then(() => {
          this.datosGet()
          this.dialog = false
        }).finally(() => {
          this.loading = false
        })
      } else {
        this.$axios.put(`productoDiseno/${this.dato.id}`, this.dato).then(() => {
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
        diseno: 'Nuevo', // 'Nuevo' o 'Correccion',
        tamano: '9x5', // '9x5' o '10x10' o '10x15' o '20x15' o '20x30' o '30x40' o '40x50' o '50x70' o '100x70'
        lado: '1 Lado', // '1 Lado' o '2 Lado'
        precio: '',
        comentario: ''
      }
    },
    async datosGet () {
      this.loading = true
      this.datos = (await this.$axios.get('productoDiseno')).data
      this.loading = false
      console.log(this.datos)
    }
  }
}
</script>
