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
        </q-toolbar-title>

        <div>
          <q-btn flat  color="white" :label="$store.user.name" no-caps icon-right="account_circle">
            <q-menu>
              <q-list>
                <q-item clickable v-ripple>
                  <q-item-section avatar>
                    <q-avatar>
                      <q-icon name="account_circle" />
                    </q-avatar>
                  </q-item-section>
                  <q-item-section>
                    <q-item-label>{{$store.user.role}}</q-item-label>
                    <q-item-section side>
                      <q-item-label caption>{{$store.user.name}}</q-item-label>
                    </q-item-section>
                  </q-item-section>
                </q-item>
                <q-item clickable v-ripple @click="logout">
                  <q-item-section avatar>
                    <q-avatar>
                      <q-icon name="logout" />
                    </q-avatar>
                  </q-item-section>
                  <q-item-section>
                    <q-item-label>Salir</q-item-label>
                  </q-item-section>
                </q-item>
              </q-list>
            </q-menu>
          </q-btn>
          <q-btn icon="o_notifications" flat round color="white">
            <q-badge color="red" floating>
              5
            </q-badge>
          </q-btn>
        </div>
      </q-toolbar>
    </q-header>

    <q-drawer
      v-model="toggle"
      show-if-above
      :width="200"
      class="bg-primary text-white"
    >
      <q-layout>
        <q-header>
          <q-list separator bordered>
            <q-item-label header class="text-bold text-subtitle2 text-uppercase color-menu cursor-pointer" @click="$router.push('/')">
              Menu
            </q-item-label>
<!--            <template v-for="(m,i) in $store.menus">-->
<!--              <q-item  :key="i" clickable :to="m.to" :class="`color-menu left-${m.color}`"-->
<!--                       active-class="text-white" v-if="m.visible">-->
<!--                <q-item-section v-if="m.icon" avatar>-->
<!--                  <q-icon :name="m.icon" />-->
<!--                </q-item-section>-->
<!--                <q-item-section>-->
<!--                  <q-item-label class="text-uppercase text-bold">{{ m.title }}</q-item-label>-->
<!--                  <q-item-label caption class="color-menu">{{ m.caption }}</q-item-label>-->
<!--                </q-item-section>-->
<!--              </q-item>-->
<!--            </template>-->
<!--            menus: [-->
<!--            {-->
<!--            title: 'Usuarios',-->
<!--            icon: 'o_people',-->
<!--            to: '/usuarios',-->
<!--            color: 'orange',-->
<!--            visible: this.$can('Usuarios')-->
<!--            },-->
<!--            {-->
<!--            title: 'Estadisticas',-->
<!--            icon: 'insert_chart_outlined',-->
<!--            to: '/estadisticas',-->
<!--            color: 'orange',-->
<!--            visible: this.$can('Estadisticas')-->
<!--            },-->
<!--            {-->
<!--            title: 'Central Files',-->
<!--            icon: 'o_folder',-->
<!--            to: '/central-files',-->
<!--            color: 'purple',-->
<!--            visible: this.$can('Central Files')-->
<!--            },-->
<!--            {-->
<!--            title: 'Precios',-->
<!--            icon: 'attach_money',-->
<!--            to: '/precios',-->
<!--            color: 'purple',-->
<!--            visible: false-->
<!--            },-->
<!--            {-->
<!--            title: 'Tesoreria',-->
<!--            icon: 'o_account_balance_wallet',-->
<!--            to: '/tesoreria',-->
<!--            color: 'pink',-->
<!--            visible: false-->
<!--            },-->
<!--            {-->
<!--            title: 'Facturas',-->
<!--            icon: 'o_receipt',-->
<!--            to: '/facturas',-->
<!--            color: 'pink',-->
<!--            visible: false-->
<!--            },-->
<!--            {-->
<!--            title: 'Diseño',-->
<!--            icon: 'o_palette',-->
<!--            to: '/diseno',-->
<!--            color: 'green',-->
<!--            visible: false-->
<!--            },-->
<!--            {-->
<!--            title: 'Impresion',-->
<!--            icon: 'o_print',-->
<!--            to: '/impresion',-->
<!--            color: 'green',-->
<!--            visible: false-->
<!--            },-->
<!--            {-->
<!--            title: 'Entregas',-->
<!--            icon: 'o_local_shipping',-->
<!--            to: '/entregas',-->
<!--            color: 'grey',-->
<!--            visible: false-->
<!--            }-->
<!--            // {-->
<!--            //   title: 'Nuevo Cliente',-->
<!--            //   icon: 'o_person_add',-->
<!--            //   to: '/nuevo-cliente',-->
<!--            //   color: 'yellow'-->
<!--            // }-->
<!--            ]-->
            <q-item clickable to="/usuarios" class="color-menu left-orange" active-class="text-white" v-if="$can('Usuarios')">
              <q-item-section avatar><q-icon name="o_people" /></q-item-section>
              <q-item-section>
                <q-item-label class="text-uppercase text-bold">Usuarios</q-item-label>
              </q-item-section>
            </q-item>
            <q-item clickable to="/estadisticas" class="color-menu left-orange" active-class="text-white" v-if="$can('Estadisticas')">
              <q-item-section avatar><q-icon name="insert_chart_outlined" /></q-item-section>
              <q-item-section>
                <q-item-label class="text-uppercase text-bold">Estadisticas</q-item-label>
              </q-item-section>
            </q-item>
            <q-item clickable to="/central-files" class="color-menu left-purple" active-class="text-white" v-if="$can('Central Files')">
              <q-item-section avatar><q-icon name="o_folder" /></q-item-section>
              <q-item-section>
                <q-item-label class="text-uppercase text-bold">Central Files</q-item-label>
              </q-item-section>
            </q-item>
            <q-item clickable to="/precios" class="color-menu left-purple" active-class="text-white" v-if="$can('Precios')">
              <q-item-section avatar><q-icon name="attach_money" /></q-item-section>
              <q-item-section>
                <q-item-label class="text-uppercase text-bold">Precios</q-item-label>
              </q-item-section>
            </q-item>
<!--            <q-item clickable to="/cotizaciones" class="color-menu left-purple" active-class="text-white" v-if="$can('Cotizaciones')">-->
<!--              <q-item-section avatar><q-icon name="attach_money" /></q-item-section>-->
<!--              <q-item-section>-->
<!--                <q-item-label class="text-uppercase text-bold">Cotizaciones</q-item-label>-->
<!--              </q-item-section>-->
<!--            </q-item>-->
            <q-item clickable to="/tesoreria" class="color-menu left-pink" active-class="text-white" v-if="$can('Tesoreria')">
              <q-item-section avatar><q-icon name="o_account_balance_wallet" /></q-item-section>
              <q-item-section>
                <q-item-label class="text-uppercase text-bold">Tesoreria</q-item-label>
              </q-item-section>
            </q-item>
            <q-item clickable to="/facturas" class="color-menu left-pink" active-class="text-white" v-if="$can('Facturas')">
              <q-item-section avatar><q-icon name="o_receipt" /></q-item-section>
              <q-item-section>
                <q-item-label class="text-uppercase text-bold">Facturas</q-item-label>
              </q-item-section>
            </q-item>
            <q-item clickable to="/diseno" class="color-menu left-green" active-class="text-white" v-if="$can('Diseño')">
              <q-item-section avatar><q-icon name="o_palette" /></q-item-section>
              <q-item-section>
                <q-item-label class="text-uppercase text-bold">Diseño</q-item-label>
              </q-item-section>
            </q-item>
            <q-item clickable to="/impresion" class="color-menu left-green" active-class="text-white" v-if="$can('Impresion')">
              <q-item-section avatar><q-icon name="o_print" /></q-item-section>
              <q-item-section>
                <q-item-label class="text-uppercase text-bold">Impresion</q-item-label>
              </q-item-section>
            </q-item>
            <q-item clickable to="/entregas" class="color-menu left-grey" active-class="text-white" v-if="$can('Entregas')">
              <q-item-section avatar><q-icon name="o_local_shipping" /></q-item-section>
              <q-item-section>
                <q-item-label class="text-uppercase text-bold">Entregas</q-item-label>
              </q-item-section>
            </q-item>
<!--            <q-item clickable to="/nuevo-cliente" class="color-menu left-yellow" active-class="text-white" v-if="$can('Nuevo Cliente')">-->
<!--              <q-item-section avatar><q-icon name="o_person_add" /></q-item-section>-->
<!--              <q-item-section>-->
<!--                <q-item-label class="text-uppercase text-bold">Nuevo Cliente</q-item-label>-->
<!--              </q-item-section>-->
<!--            </q-item>-->
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
export default {
  name: 'MainLayout',
  data () {
    return {
      toggle: false,
      menus: [
        {
          title: 'Usuarios',
          icon: 'o_people',
          to: '/usuarios',
          color: 'orange',
          visible: this.$can('Usuarios')
        },
        {
          title: 'Estadisticas',
          icon: 'insert_chart_outlined',
          to: '/estadisticas',
          color: 'orange',
          visible: this.$can('Estadisticas')
        },
        {
          title: 'Central Files',
          icon: 'o_folder',
          to: '/central-files',
          color: 'purple',
          visible: this.$can('Central Files')
        },
        {
          title: 'Precios',
          icon: 'attach_money',
          to: '/precios',
          color: 'purple',
          visible: false
        },
        {
          title: 'Tesoreria',
          icon: 'o_account_balance_wallet',
          to: '/tesoreria',
          color: 'pink',
          visible: false
        },
        {
          title: 'Facturas',
          icon: 'o_receipt',
          to: '/facturas',
          color: 'pink',
          visible: false
        },
        {
          title: 'Diseño',
          icon: 'o_palette',
          to: '/diseno',
          color: 'green',
          visible: false
        },
        {
          title: 'Impresion',
          icon: 'o_print',
          to: '/impresion',
          color: 'green',
          visible: false
        },
        {
          title: 'Entregas',
          icon: 'o_local_shipping',
          to: '/entregas',
          color: 'grey',
          visible: false
        }
        // {
        //   title: 'Nuevo Cliente',
        //   icon: 'o_person_add',
        //   to: '/nuevo-cliente',
        //   color: 'yellow'
        // }
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
