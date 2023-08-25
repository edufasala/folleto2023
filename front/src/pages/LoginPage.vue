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
                <q-img src="/logo.png" width="150px" />
                <div class="text-h6 text-bold">4ta. Jornada Nacional de Neurología</div>
                <div class="text-subtitle2 text-bold">
                  <q-icon name="o_location_on" /> 2do Simposio Internacional de
                  Neurología
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
                    label="Atrás"
                    color="primary"
                    no-caps
                    rounded
                    outline
                    icon="o_arrow_back"
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
      this.$router.push('/menu')
    }
  },
  methods: {
    login () {
      this.loading = true
      this.$axios.post('login', {
        email: this.email,
        password: this.password
      })
        .then(response => {
          this.$alert.success(`Bienvenido ${response.data.user.name}!`)
          this.$store.user = response.data.user
          this.$store.isLoggedIn = true
          this.$axios.defaults.headers.common.Authorization = `Bearer ${response.data.token}`
          localStorage.setItem('tokenNeuro', response.data.token)
          this.$router.push('/menu')
        })
        .catch(error => {
          this.$alert.error(error.response.data.message)
        })
        .finally(() => {
          this.loading = false
        })
    }
  }
}
</script>

<style scoped>

</style>
