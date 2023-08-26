<template>
  <q-page class="q-pa-xs">
    <div class="row">
      <div class="col-12 text-uppercase luckiest text-h2 text-center">
        Usuarios
      </div>
    </div>
    <div class="col-12">
      <q-btn :loading="loading" label="ACTIVOS" no-caps :class="`text-bold ${tab=='activos'?'text-blue':'text-white bg-grey'} w-150`" size="15px" @click="tab = 'activos'"/>
      <q-btn :loading="loading" label="INACTIVOS" no-caps :class="`text-bold ${tab=='inactivos'?'text-blue':'text-white bg-grey'} w-150`" size="15px" @click="tab = 'inactivos'"/>
      <q-card>
        <q-tab-panels v-model="tab" animated>
          <q-tab-panel name="activos">
            <q-table dense :rows="users" :rows-per-page-options="[0]"
                     :loading="loading" :wrap-cells="true" flat bordered
                     class="table-background"
                     :columns="usersColumn" :filter="userFilterActive">
              <template v-slot:top-right>
                <q-btn color="blue" @click="userAdd" label="Nuevo usuario" no-caps :loading="loading"/>
                <q-btn flat round icon="refresh" @click="usersGet" :loading="loading">
                  <q-tooltip>Actualizar</q-tooltip>
                </q-btn>
                <q-input outlined dense v-model="userFilterActive" debounce="500" placeholder="Buscar" class="bg-white">
                  <template v-slot:append>
                    <q-icon name="search" class="cursor-pointer">
                      <q-tooltip>Buscar</q-tooltip>
                    </q-icon>
                  </template>
                </q-input>
              </template>
              <template v-slot:body-cell-permissions="props">
                <q-td :props="props">
                    <template v-for="permission in props.row.permissions" :key="permission">
                      {{permission.name}}
                      <span v-if="props.row.permissions.length > 1 && props.row.permissions[props.row.permissions.length-1].id != permission.id">
                        ,
                      </span>
                    </template>
                </q-td>
              </template>
              <template v-slot:body-cell-actions="props">
                <q-td :props="props">
                  <q-btn-group flat>
                    <q-btn flat round dense icon="edit" @click="userEdit(props.row)" color="grey" :loading="loading">
                      <q-tooltip>Editar</q-tooltip>
                    </q-btn>
                    <q-btn flat round dense icon="lock_open" @click="userPassword(props.row)" color="grey" :loading="loading">
                      <q-tooltip>Contraseña</q-tooltip>
                    </q-btn>
                  </q-btn-group>
                </q-td>
              </template>
              <template v-slot:body-cell-active="props">
                <q-td :props="props">
                  <q-toggle v-model="props.row.active" @update:model-value="userUpdate(props.row)"
                            keep-color dense
                            false-value="No" true-value="Si" color="green" :label="props.row.active"/>
                </q-td>
              </template>
            </q-table>
          </q-tab-panel>
          <q-tab-panel name="inactivos" class="">
            <div class="text-h6">Alarms</div>
            Lorem ipsum dolor sit amet consectetur adipisicing elit.
          </q-tab-panel>
        </q-tab-panels>
      </q-card>
    </div>
    <q-dialog v-model="userDialog" prevent-close>
      <q-card style="width: 750px">
        <q-card-section class="row items-center q-pb-none">
          <q-icon name="account_circle" size="25px"/>
          <div class="text-h6 text-bold q-pl-xs">{{userOption==='add'?'Nuevo':'Editar'}} usuario</div>
          <q-space/>
          <q-btn flat round icon="close" @click="userDialog = false" color="grey" :loading="loading">
            <q-tooltip>Cerrar</q-tooltip>
          </q-btn>
        </q-card-section>
        <q-card-section>
          <q-form @submit="userUpdate(user)">
            <q-input outlined v-model="user.name" label="Nombre" :loading="loading" required/>
            <q-input outlined v-model="user.email" label="Correo" :loading="loading" required/>
            <q-select outlined required v-model="user.role" label="Rol" :options="$roles"/>
            <pre>{{user}}</pre>
            <q-card-actions align="right">
              <q-btn flat round label="Cancelar" color="grey" @click="userDialog = false"/>
              <q-btn flat round label="Guardar" color="blue" type="submit" :loading="loading"/>
            </q-card-actions>
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>
  </q-page>
</template>
<script>
export default {
  name: 'UsuariosPage',
  data () {
    return {
      modelMultiple: [],
      options: [
        'Google', 'Facebook', 'Twitter', 'Apple', 'Oracle'
      ],
      userDialog: false,
      user: {},
      userOption: '',
      tab: 'activos',
      users: [],
      userFilterActive: '',
      usersColumn: [
        { name: 'actions', label: 'Acciones', field: 'actions', align: 'left', sortable: false },
        { name: 'name', label: 'Nombre', field: 'name', align: 'left', sortable: true },
        { name: 'email', label: 'Correo', field: 'email', align: 'left', sortable: true },
        { name: 'permissions', label: 'Permisos', field: 'permissions', align: 'left', sortable: true, wrapCells: true },
        { name: 'role', label: 'Rol', field: 'role', align: 'left', sortable: true },
        { name: 'active', label: 'Activo', field: 'active', align: 'left', sortable: true }
      ],
      loading: false,
      permissions: []
    }
  },
  mounted () {
    this.usersGet()
    this.permissionsGet()
  },
  methods: {
    permissionsGet () {
      this.$axios.get('permissions').then(res => {
        this.permissions = res.data
      })
    },
    userEdit (user) {
      this.user = user
      this.userDialog = true
      this.userOption = 'edit'
    },
    userUpdate (user) {
      // user.active = user.active === 'Si' ? 'No' : 'Si'
      this.$axios.put(`users/${user.id}`, user).then(() => {
      }).catch((err) => {
        this.$alert.error(err.response.data.message)
      })
    },
    userAdd () {
      this.$router.push('/users/add')
    },
    usersGet () {
      this.loading = true
      this.$axios.get('users').then(res => {
        this.users = res.data
      }).finally(() => {
        this.loading = false
      })
    }
  }
}
</script>
