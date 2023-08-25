<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          icon="menu"
          aria-label="Menu"
          @click="toggle = !toggle"
        />

        <q-toolbar-title>
          Quasar App
        </q-toolbar-title>

        <div>Quasar v{{ $q.version }}</div>
      </q-toolbar>
    </q-header>

    <q-drawer
      v-model="toggle"
      show-if-above
      bordered
      class="bg-primary text-white"
    >
      <q-layout>
        <q-header>
          <q-list separator bordered>
            <q-item-label header class="text-bold text-subtitle2 text-uppercase color-menu">
              Menu
            </q-item-label>
            <EssentialLink
              v-for="link in menus"
              :key="link.title"
              v-bind="link"
            />
          </q-list>
        </q-header>
        <q-footer>
          <div class="text-center text-bold">
            <span class="text-blue">100</span>
            <span class="text-yellow"> % </span>
            <span class="text-red">Folletos</span>
          </div>
          <div class="text-center text-bold">
            IMPRENTA DE VOLANTES
          </div>
          <q-list bordered padding class="rounded-borders text-red">
            <q-item clickable v-ripple @click="logout()">
              <q-item-section avatar>
                <q-icon name="o_logout" />
              </q-item-section>
              <q-item-section> Cerrar sesión</q-item-section>
            </q-item>
          </q-list>
        </q-footer>
      </q-layout>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
import EssentialLink from 'components/EssentialLink.vue'
export default {
  name: 'MainLayout',
  components: {
    EssentialLink
  },
  data () {
    return {
      toggle: false,
      menus: [
        {
          title: 'Usuarios',
          icon: 'people',
          to: '/usuarios',
          color: 'orange'
        },
        {
          title: 'Estadisticas',
          icon: 'insert_chart_outlined',
          to: '/estadisticas',
          color: 'orange'
        },
        {
          title: 'Central Files',
          icon: 'o_folder',
          to: '/central-files',
          color: 'purple'
        },
        {
          title: 'Precios',
          icon: 'attach_money',
          to: '/precios',
          color: 'purple'
        },
        {
          title: 'Tesoreria',
          icon: 'o_account_balance_wallet',
          to: '/tesoreria',
          color: 'pink'
        },
        {
          title: 'Facturas',
          icon: 'o_receipt',
          to: '/facturas',
          color: 'pink'
        },
        {
          title: 'Diseño',
          icon: 'o_palette',
          to: '/diseno',
          color: 'green'
        },
        {
          title: 'Impresion',
          icon: 'o_print',
          to: '/impresion',
          color: 'green'
        },
        {
          title: 'Entregas',
          icon: 'o_local_shipping',
          to: '/entregas',
          color: 'grey'
        },
        {
          title: 'Nuevo Cliente',
          icon: 'o_person_add',
          to: '/nuevo-cliente',
          color: 'yellow'
        }
      ]
    }
  },

  methods: {
    logout () {
      this.$q.dialog({
        message: '¿Quieres cerrar sesión?',
        title: 'Salir',
        ok: {
          push: true
        },
        cancel: {
          push: true,
          color: 'negative'
        }
      }).onOk(() => {
        this.$q.loading.show()
        this.$axios.post('logout').then(() => {
          this.$axios.defaults.headers.common.Authorization = ''
          this.$store.user = {}
          localStorage.removeItem('tokenFolleto')
          this.$store.isLoggedIn = false
          this.$q.loading.hide()
          this.$router.push('/login')
        })
      })
    }
  }
}
</script>
