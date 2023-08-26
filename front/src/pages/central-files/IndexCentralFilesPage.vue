<template>
<q-page class="q-pa-xs bg-grey-3">
  <div class="row">
    <div class="col-12 col-md-3 bg-blue-2 full-height">
      <div class="row">
        <div class="col-12 text-uppercase luckiest text-h6 text-center">
          Central Files
        </div>
        <div class="col-12">
          <q-table dense :rows="empresas" :rows-per-page-options="[20]"
                   :loading="loading" :wrap-cells="true" flat bordered
                   :columns="empresaColumn" :filter="search">
            <template v-slot:top-right>
              <q-input clearable rounded dense outlined bg-color="white" class="q-ma-xs"
                       v-model="search" placeholder="Search">
                <template v-slot:prepend>
                  <q-icon name="search" />
                </template>
                <template v-slot:after>
                  <q-btn flat round dense icon="more_vert" />
                </template>
              </q-input>
              <q-separator />
            </template>
          </q-table>
        </div>
        <div class="col-12">
          asa
        </div>
      </div>
    </div>
    <div class="col-12 col-md-9 full-height">
          <div>Central Files</div>
    </div>
  </div>
</q-page>
</template>
<script>
export default {
  name: 'IndexCentralFilesPage',
  data () {
    return {
      search: '',
      loading: false,
      empresas: [],
      empresaColumn: [
        { name: 'name', label: 'Name', field: 'name', align: 'left', sortable: true },
        { name: 'address', label: 'Address', field: 'address', align: 'left', sortable: true },
        { name: 'phone', label: 'Phone', field: 'phone', align: 'left', sortable: true },
        { name: 'email', label: 'Email', field: 'email', align: 'left', sortable: true },
        { name: 'website', label: 'Website', field: 'website', align: 'left', sortable: true },
        { name: 'action', label: 'Action', field: 'action', align: 'left', sortable: true }
      ]
    }
  },
  mounted () {
    this.getEmpresas()
  },
  methods: {
    getEmpresas () {
      this.loading = true
      this.$axios.get('empresas')
        .then(response => {
          this.empresas = response.data
        }).catch(error => {
          this.$alert(error.response.data.message)
        }).finally(() => {
          this.loading = false
        })
    }
  }
}
</script>
