<template>
      <div class="row">
        <div class="col-12">
              <q-markup-table flat bordered dense>
                <thead class="bg-grey-9">
                <tr>
                  <th colspan="5" class="text-left text-subtitle2 text-white">
                        SUCURSALES
                  </th>
                </tr>
                <tr class="text-white">
                  <th class="text-left">Nombre</th>
                  <th class="text-left">Comentario</th>
                  <th class="text-right">OPciones</th>
                </tr>
                </thead>
                <tbody class="bg-grey-3">
                <tr v-for="sucursal in sucursals" :key="sucursal.id">
                  <td class="text-left">{{ sucursal.nombre }}</td>
                  <td class="text-left">{{ sucursal.comentario }}</td>
                  <td class="text-right">6</td>
                </tr>
                </tbody>
              </q-markup-table>
            </div>
<!--        <q-dialog v-model="personDialog">-->
<!--          <q-card class="q-pa-xs" style="max-width: 400px">-->
<!--            <q-card-section class="q-py-none row items-center">-->
<!--              <div class="text-h6">{{personOption == 'create' ? 'Crear' : 'Editar'}} Persona</div>-->
<!--              <q-space />-->
<!--              <q-btn flat dense icon="cancel" v-close-popup />-->
<!--            </q-card-section>-->
<!--            <q-card-section class="q-py-none">-->
<!--              <q-form @submit="personSubmit">-->
<!--                <div class="row">-->
<!--                  <div class="col-12">-->
<!--                    <q-input dense outlined v-model="person.nombre" label="Nombre"-->
<!--                             :rules="[val => !!val || 'El nombre es requerido']"/>-->
<!--                  </div>-->
<!--                  <div class="col-12">-->
<!--                    <q-select dense outlined v-model="person.cargo" label="Cargo" :options="$cargos"-->
<!--                              :rules="[val => !!val || 'El cargo es requerido']"/>-->
<!--                  </div>-->
<!--                  <div class="col-12">-->
<!--                    <q-input dense outlined v-model="person.dni" label="DNI"-->
<!--                             :rules="[val => !!val || 'El DNI es requerido']"/>-->
<!--                  </div>-->
<!--                </div>-->
<!--                <q-card-actions align="right">-->
<!--                  <q-btn dense no-caps label="Cancelar" v-close-popup color="red" :loading="loading"/>-->
<!--                  <q-btn dense no-caps :loading="loading" type="submit"-->
<!--                         :label="personOption == 'create' ? 'Crear' : 'Editar'"-->
<!--                         :color="personOption == 'create' ? 'blue' : 'orange'" />-->
<!--                </q-card-actions>-->
<!--              </q-form>-->
<!--            </q-card-section>-->
<!--          </q-card>-->
<!--        </q-dialog>-->
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
      personDialog: false,
      personOption: ''
    }
  },
  methods: {
    personSubmit () {
      this.loading = true
      this.$emit('empresaSearch', this.empresa)
      this.loading = false
      this.personDialog = false
    }
  }
}
</script>
