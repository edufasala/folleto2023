<template>
  <q-table dense :rows="empresas" :rows-per-page-options="[100]"
           :loading="loading" :separator="null" flat bordered class="bg-blue-1"
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
