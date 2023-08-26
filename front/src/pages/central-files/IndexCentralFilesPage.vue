<template>
<q-page class="q-pa-xs bg-grey-3">
  <div class="row">
    <div class="col-12 col-md-3 bg-blue-1 full-height">
      <div class="row">
        <div class="col-12 text-uppercase luckiest text-h6 text-center">
          Central Files
        </div>
        <div class="col-12">
          <SearchEmpresaComponent @empresaSearch="empresaSearch" />
        </div>
      </div>
    </div>
    <div class="col-12 col-md-9">
      <div class="row">
        <div class="col-12 col-md-9"></div>
        <div class="col-12 col-md-3">
          <q-btn color="primary" label="Nuevo" icon="add" @click="empresa = null" />
        </div>
      </div>
      <pre>{{empresa}}</pre>
    </div>
  </div>
</q-page>
</template>
<script>
import SearchEmpresaComponent from 'pages/central-files/SearchEmpresaComponent.vue'
export default {
  name: 'IndexCentralFilesPage',
  components: {
    SearchEmpresaComponent
  },
  data () {
    return {
      loading: false,
      empresa: null
    }
  },
  mounted () {
    this.empresaSearch({ id: 1 })
  },
  methods: {
    empresaSearch (empresa) {
      this.empresa = empresa
      this.loading = true
      this.$axios.get('empresas/' + empresa.id)
        .then(response => {
          this.empresa = response.data
        })
        .catch(error => {
          console.log(error)
        }).finally(() => {
          this.loading = false
        })
    }
  }
}
</script>
