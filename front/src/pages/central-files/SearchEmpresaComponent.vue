<template>
  <q-table dense :rows="empresas" :rows-per-page-options="[18]"
           :loading="loading" :separator="null" flat bordered class="bg-blue-1"
           :columns="empresaColumn" :filter="search" hide-header hide-bottom>
    <template v-slot:top>
      <q-input clearable rounded dense outlined bg-color="white" class="q-ma-xs"
               v-model="search" placeholder="Search" :loading="loading">
        <template v-slot:prepend>
          <q-icon name="search" />
        </template>
        <template v-slot:after>
          <q-btn flat round dense icon="more_vert" />
        </template>
      </q-input>
    </template>
    <template v-slot:body-cell-nombre="props">
      <q-td @click="$emit('empresaSearch', props.row)" :props="props" class="cursor-pointer">
        {{ props.row.nombre }}
      </q-td>
    </template>
    <template v-slot:body-cell-codigo="props">
      <q-td @click="$emit('empresaSearch', props.row)" :props="props" class="cursor-pointer">
        <q-icon size="20px" name="account_circle" class="q-pa-none q-ma-none"/>
        <span class="text-caption text-bold">{{ props.row.codigo }}</span>
      </q-td>
    </template>
  </q-table>
</template>

<script>
export default {
  name: 'SearchEmpresaComponent',
  props: {
    empresas: {
      type: Object,
      default: () => ({})
    },
    loading: {
      type: Boolean,
      default: false
    }
  },
  data () {
    return {
      search: '',
      // loading: false,
      // empresas: [],
      empresaColumn: [
        { name: 'codigo', label: 'Código', field: 'codigo', align: 'left', sortable: true, hide: true },
        { name: 'nombre', label: 'Nombre', field: 'nombre', align: 'left', sortable: true }
      ]
    }
  },
  mounted () {
    // this.getEmpresas()
  },
  methods: {
    // getEmpresas () {
    //   this.loading = true
    //   this.$axios.get('empresas')
    //     .then(response => {
    //       this.empresas = response.data
    //     }).catch(error => {
    //       this.$alert(error.response.data.message)
    //     }).finally(() => {
    //       this.loading = false
    //     })
    // }
  }
}
</script>
