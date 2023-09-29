<template>
      <div class="row">
        <div class="col-12">
              <q-markup-table flat bordered dense wrap-cells>
                <thead class="bg-grey-9">
                <tr>
                  <th colspan="3" class="text-left text-subtitle2 text-white">
                    <div class="row items-center">
                      SUCURSALES
                      <q-space />
                      <q-btn size="10px" flat dense icon="add_circle_outline" no-caps
                             color="blue" :loading="loading"
                             @click="sucursalAdd">
                        <q-tooltip>Crear Sucursal</q-tooltip>
                      </q-btn>
                    </div>
                  </th>
                </tr>
                <tr class="text-white">
                  <th class="text-left">Nombre</th>
                  <th class="text-left">Comentario</th>
                  <th class="text-right">Opciones</th>
                </tr>
                </thead>
                <tbody class="bg-grey-3">
                <tr v-for="sucursal in sucursals" :key="sucursal.id">
                  <td class="text-left">{{ sucursal.nombre }}</td>
                  <td class="text-left" >
                    {{ sucursal.comentario }}
                  </td>
                  <td class="text-right">
                    <q-btn-group flat dense>
                      <q-btn :loading="loading" dense size="10px" flat icon="o_edit" color="orange" @click="sucursalEdit(sucursal)">
                        <q-tooltip>Editar Sucursal</q-tooltip>
                      </q-btn>
                      <q-btn :loading="loading" dense size="10px" flat icon="cancel" color="grey" @click="sucursalDelete(sucursal)">
                        <q-tooltip>Eliminar Sucursal</q-tooltip>
                      </q-btn>
                    </q-btn-group>
                  </td>
                </tr>
                </tbody>
              </q-markup-table>
            </div>
        <q-dialog v-model="sucursalDialog">
          <q-card class="q-pa-xs" style="max-width: 400px">
            <q-card-section class="q-py-none row items-center">
              <div class="text-h6">{{sucursalOption == 'create' ? 'Crear' : 'Editar'}} Sucursal</div>
              <q-space />
              <q-btn flat dense icon="cancel" v-close-popup />
            </q-card-section>
            <q-card-section class="q-py-none">
              <q-form @submit="sucursalSubmit">
                <div class="row">
                  <div class="col-12">
                    <q-input dense outlined v-model="sucursal.nombre" label="Nombre"
                             :rules="[val => !!val || 'El nombre es requerido']"/>
                  </div>
                  <div class="col-12">
                    <q-input dense outlined v-model="sucursal.comentario" label="Comentario"
                              :rules="[val => !!val || 'El comentario es requerido']"/>
                  </div>
                </div>
                <q-card-actions align="right">
                  <q-btn dense no-caps label="Cancelar" v-close-popup color="red" :loading="loading"/>
                  <q-btn dense no-caps :loading="loading" type="submit"
                         :label="sucursalOption == 'create' ? 'Crear' : 'Editar'"
                         :color="sucursalOption == 'create' ? 'blue' : 'orange'" />
                </q-card-actions>
              </q-form>
            </q-card-section>
          </q-card>
        </q-dialog>
      </div>
</template>
<script>
export default {
  name: 'SucursalComponent',
  props: {
    empresa: {
      type: Object,
      default: () => {}
    },
    sucursals: {
      type: Array,
      default: () => []
    }
  },
  data () {
    return {
      loading: false,
      sucursalDialog: false,
      sucursalOption: '',
      sucursal: {
        nombre: '',
        comentario: ''
      }
    }
  },
  methods: {
    sucursalAdd () {
      this.sucursalOption = 'create'
      this.sucursalDialog = true
      this.sucursal = {
        nombre: '',
        comentario: ''
      }
    },
    sucursalEdit (sucursal) {
      this.sucursalOption = 'edit'
      this.sucursal = sucursal
      this.sucursalDialog = true
    },
    sucursalDelete (sucursal) {
      this.$q.dialog({
        title: 'Confirmar',
        message: '¿Está seguro de eliminar la sucursal?',
        cancel: true,
        persistent: true
      }).onOk(() => {
        this.loading = true
        this.$axios.delete('sucursal/' + sucursal.id)
          .then(response => {
            this.$emit('empresaSearch', this.empresa)
          }).catch(error => {
            this.$alert(error.response.data.message)
          }).finally(() => {
            this.loading = false
          })
      })
    },
    sucursalSubmit () {
      this.loading = true
      if (this.sucursalOption === 'create') {
        this.$axios.post('sucursal', {
          nombre: this.sucursal.nombre,
          comentario: this.sucursal.comentario,
          empresa_id: this.empresa.id
        }).then(response => {
          this.sucursalDialog = false
          this.$emit('empresaSearch', this.empresa)
        }).catch(error => {
          this.$alert(error.response.data.message)
        }).finally(() => {
          this.loading = false
        })
      } else {
        this.$axios.put('sucursal/' + this.sucursal.id, {
          nombre: this.sucursal.nombre,
          comentario: this.sucursal.comentario,
          empresa_id: this.empresa.id
        }).then(response => {
          this.sucursalDialog = false
          this.$emit('empresaSearch', this.empresa)
        }).catch(error => {
          this.$alert(error.response.data.message)
        }).finally(() => {
          this.loading = false
        })
      }
    }
  }
}
</script>
