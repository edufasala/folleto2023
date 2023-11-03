<template>
  <q-table dense :rows="empresas" :rows-per-page-options="[100]"
           :loading="loading" :separator="null" flat bordered class="bg-blue-1 my-sticky-header-table"
           :columns="empresaColumn" hide-header>
    <template v-slot:top>
      <q-input clearable rounded dense outlined bg-color="white" class="q-ma-xs"
               debounce="500"
               v-model="search" placeholder="Search" :loading="loading" @update:model-value="$emit('empresaFilter', search, filtrarPor);page = 1">
        <template v-slot:prepend>
          <q-icon name="search" />
        </template>
        <template v-slot:after>
          <q-btn flat round dense icon="more_vert">
            <q-menu>
              <q-list dense bordered>
                <q-item clickable v-close-popup @click="filtrarPor = 'numero'">
                  <q-item-section side>
                    <q-icon :name="filtrarPor === 'numero' ? 'check' : ''" />
                  </q-item-section>
                  <q-item-section>
                    <q-item-label>Numero/Nombre de cliente</q-item-label>
                  </q-item-section>
                </q-item>
                <q-item clickable v-close-popup @click="filtrarPor = 'nombre'">
                  <q-item-section side>
                    <q-icon :name="filtrarPor === 'nombre' ? 'check' : ''" />
                  </q-item-section>
                  <q-item-section>
                    <q-item-label>Nombre de personas</q-item-label>
                  </q-item-section>
                </q-item>
                <q-item clickable v-close-popup @click="filtrarPor = 'telefono'">
                  <q-item-section side>
                    <q-icon :name="filtrarPor === 'telefono' ? 'check' : ''" />
                  </q-item-section>
                  <q-item-section>
                    <q-item-label>Telefono</q-item-label>
                  </q-item-section>
                </q-item>
                <q-item clickable v-close-popup @click="filtrarPor = 'email'">
                  <q-item-section side>
                    <q-icon :name="filtrarPor === 'email' ? 'check' : ''" />
                  </q-item-section>
                  <q-item-section>
                    <q-item-label>Email</q-item-label>
                  </q-item-section>
                </q-item>
                <q-item clickable v-close-popup @click="filtrarPor = 'sucursal'">
                  <q-item-section side>
                    <q-icon :name="filtrarPor === 'sucursal' ? 'check' : ''" />
                  </q-item-section>
                  <q-item-section>
                    <q-item-label>Sucursal</q-item-label>
                  </q-item-section>
                </q-item>
              </q-list>
            </q-menu>
          </q-btn>
        </template>
      </q-input>
    </template>
    <template v-slot:bottom>
      <div class="flex flex-center full-width">
        <q-pagination
          v-model="page"
          :max="last_page"
          :max-pages="7"
          outline
          size="10px"
          @update:modelValue="$emit('empresaPage', search, filtrarPor, page)"/>
      </div>
    </template>
<!--    <template v-slot:body-cell-nombre="props">-->
<!--      <q-td @click="$emit('empresaSearch', props.row)" :props="props" class="cursor-pointer">-->
<!--        {{ props.row.nombre }}-->
<!--      </q-td>-->
<!--    </template>-->
<!--    <template v-slot:body-cell-codigo="props">-->
<!--      <q-td @click="$emit('empresaSearch', props.row)" :props="props" class="cursor-pointer">-->
<!--        <q-icon size="20px" name="account_circle" class="q-pa-none q-ma-none"/>-->
<!--        <span class="text-caption text-bold">{{ props.row.codigo }}</span>-->
<!--      </q-td>-->
<!--    </template>-->
    <template v-slot:body="props">
      <q-tr :class="parseInt($store.selectEmpresa) === parseInt(props.pageIndex)?`bg-blue-8 text-white`:``" :props="props"
            @click="$emit('empresaSearch', props.row);$store.selectEmpresa=props.pageIndex">
        <q-td name="codigo" :props="props" class="cursor-pointer" key="codigo">
<!--                    <span>{{$store.selectEmpresa}}-{{props.pageIndex}}</span>-->
          <q-icon size="20px" name="account_circle" class="q-pa-none q-ma-none"/>
          <span class="text-caption text-bold">{{ props.row.codigo }}</span>
        </q-td>
        <q-td name="nombre" :props="props" class="cursor-pointer" key="nombre">
          {{ props.row.nombre }}
<!--          <span>{{props.pageIndex}}</span>-->
        </q-td>
      </q-tr>
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
    },
    last_page: {
      type: Number,
      default: 1
    }
  },
  data () {
    return {
      page: 1,
      search: '',
      filtrarPor: 'numero',
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
<style lang="sass">
.my-sticky-header-table
  /* height or max-height is important */
  //height: 550px

  .q-table__top,
  .q-table__bottom,
  thead tr:first-child th
    /* bg color is important for th; just specify one */
    //background-color: #00b4ff

  thead tr th
    position: sticky
    z-index: 1
  thead tr:first-child th
    top: 0

  /* this is when the loading indicator appears */
  &.q-table--loading thead tr:last-child th
    /* height of all previous header rows */
    top: 48px

  /* prevent scrolling behind sticky top row on focus */
  tbody
    /* height of all previous header rows */
    scroll-margin-top: 48px
</style>
