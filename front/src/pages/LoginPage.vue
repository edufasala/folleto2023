<template>
  <q-layout>
    <q-page-container>
      <q-page class="bg-grey-4">
        <div class="row">
          <div class="col-12 col-md-4"></div>
          <div class="col-12 col-md-4 q-pa-xs">
            <q-card class="q-mt-md">
              <q-card-section class="text-center">
                <div class="text-h5 text-bold">Iniciar sesión</div>
                <q-img src="/logo1.png" width="150px" />
                <div class="text-h6 text-bold">Arka ́s “Voiparkas” Comunicaciones</div>
                <div class="text-subtitle2 text-bold">
                  <q-icon name="o_location_on" />
                  <span>Nosotros Proveemos Soluciones para tu Negocio!</span>
                </div>
              </q-card-section>
              <q-card-section>
                <q-form @submit="login">
                  <q-input
                    v-model="email"
                    label="email"
                    filled
                    lazy-rules
                    :rules="[val => val.length > 0 || 'El usuario es requerido']"
                  />
                  <q-input
                    :type="passwordVisible ? 'text' : 'password'"
                    v-model="password"
                    label="Contraseña"
                    filled
                    lazy-rules
                    :rules="[val => val.length > 0 || 'La contraseña es requerida']"
                  >
                    <template v-slot:append>
                      <q-icon class="cursor-pointer" @click="passwordVisible = !passwordVisible" :name="passwordVisible ? 'visibility_off' : 'visibility'">
                        <q-tooltip>Contraseña</q-tooltip>
                      </q-icon>
                    </template>
                  </q-input>
                  <q-btn
                    label="Iniciar sesión"
                    color="primary"
                    no-caps
                    rounded
                    icon="o_login"
                    :loading="loading"
                    class="full-width"
                    type="submit"
                  />
                  <q-btn
                    label="Registrate"
                    color="primary"
                    no-caps
                    rounded
                    outline
                    icon="o_person_add"
                    class="full-width q-mt-xs"
                    @click="$router.push('/')"
                  />
                </q-form>
              </q-card-section>
            </q-card>
          </div>
          <div class="col-12 col-md-4"></div>
        </div>
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<script>

export default {
  name: 'LoginPage',
  data () {
    return {
      email: '',
      password: '',
      loading: false,
      passwordVisible: false
    }
  },
  mounted () {
    if (this.$store.isLoggedIn) {
      this.$router.push('/')
    }
  },
  methods: {
    login () {
      this.loading = true
      this.$axios.post('login', {
        email: this.email,
        password: this.password
      })
        .then(res => {
          this.$alert.success(`Bienvenido ${res.data.user.name}!`)
          this.$store.user = res.data.user
          this.$store.permisos = this.arrayName(res.data.permisos)
          this.$store.isLoggedIn = true
          this.$store.menus = [
            {
              title: 'Usuarios',
              icon: 'o_people',
              to: '/usuarios',
              color: 'orange',
              visible: this.arrayName(res.data.permisos).includes('Usuarios')
            },
            {
              title: 'Estadisticas',
              icon: 'insert_chart_outlined',
              to: '/estadisticas',
              color: 'orange',
              visible: this.arrayName(res.data.permisos).includes('Estadisticas')
            },
            {
              title: 'Central Files',
              icon: 'o_folder',
              to: '/central-files',
              color: 'purple',
              visible: this.arrayName(res.data.permisos).includes('Central Files')
            },
            {
              title: 'Cotizaciones',
              icon: 'o_attach_money',
              to: '/cotizaciones',
              color: 'purple',
              visible: this.arrayName(res.data.permisos).includes('Cotizaciones')
            },
            {
              title: 'Precios',
              icon: 'attach_money',
              to: '/precios',
              color: 'purple',
              visible: this.arrayName(res.data.permisos).includes('Precios')
            },
            {
              title: 'Tesoreria',
              icon: 'o_account_balance_wallet',
              to: '/tesoreria',
              color: 'pink',
              visible: this.arrayName(res.data.permisos).includes('Tesoreria')
            },
            {
              title: 'Facturas',
              icon: 'o_receipt',
              to: '/facturas',
              color: 'pink',
              visible: this.arrayName(res.data.permisos).includes('Facturas')
            },
            {
              title: 'Diseño',
              icon: 'o_palette',
              to: '/diseno',
              color: 'green',
              visible: this.arrayName(res.data.permisos).includes('Diseño')
            },
            {
              title: 'Impresion',
              icon: 'o_print',
              to: '/impresion',
              color: 'green',
              visible: this.arrayName(res.data.permisos).includes('Impresion')
            },
            {
              title: 'Entregas',
              icon: 'o_local_shipping',
              to: '/entregas',
              color: 'grey',
              visible: this.arrayName(res.data.permisos).includes('Entregas')
            },
            {
              title: 'Nuevo Cliente',
              icon: 'o_person_add',
              to: '/nuevo-cliente',
              color: 'yellow',
              visible: this.arrayName(res.data.permisos).includes('Usuarios')
            }
          ]
          this.$axios.defaults.headers.common.Authorization = `Bearer ${res.data.token}`
          localStorage.setItem('tokenFolleto', res.data.token)
          this.$router.push('/')
        })
        .catch(error => {
          this.$alert.error(error.response.data.message)
        })
        .finally(() => {
          this.loading = false
        })
    },
    arrayName (array) {
      const permisos = []
      array.forEach(element => {
        permisos.push(element.name)
      })
      return permisos
    }
  }
}
</script>

<style scoped>

</style>
