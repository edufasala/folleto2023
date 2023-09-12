import { boot } from 'quasar/wrappers'
import axios from 'axios'
import { useCounterStore } from 'stores/example-store'
import { Alert } from 'src/addons/Alert'
import moment from 'moment'
import HighchartsVue from 'highcharts-vue'
// Be careful when using SSR for cross-request state pollution
// due to creating a Singleton instance here;
// If any client changes this (global) instance, it might be a
// good idea to move this instance creation inside of the
// "export default () => {}" function below (which runs individually
// for each client)
const api = axios.create({ baseURL: 'https://api.example.com' })

export default boot(({ app, router }) => {
  // for use inside Vue files (Options API) through this.$axios and this.$api
  app.use(HighchartsVue)
  app.config.globalProperties.$axios = axios.create({ baseURL: import.meta.env.VITE_API_BACK })
  app.config.globalProperties.$url = import.meta.env.VITE_API_BACK
  app.config.globalProperties.$store = useCounterStore()
  app.config.globalProperties.$alert = Alert
  app.config.globalProperties.$roles = ['Administrador', 'Diseñador', 'Entregador', 'Vendedor', 'Gerente de ventas']
  app.config.globalProperties.$cargos = ['Administrador', 'Empleado', 'Dueño', 'Cliente', 'Marketing']
  app.config.globalProperties.$can = (permiso) => {
    if (useCounterStore().permisos.includes(permiso)) {
      return true
    } else {
      return false
    }
  }
  app.config.globalProperties.$filters = {
    dateDmY (fecha) {
      // 30 Set 1972
      fecha = fecha.substring(0, 10)
      const dias = ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado']
      const mes = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre']
      return ` ${dias[moment(String(fecha)).format('d')]} ${moment(String(fecha)).format('DD')} de ${mes[moment(String(fecha)).format('MM') - 1]} del ${moment(String(fecha)).format('YYYY')}`
    },
    shortDate (fecha) {
      // Sab 30 Sep 1972
      fecha = fecha.substring(0, 10)
      const dias = ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab']
      const mes = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic']
      return `${dias[moment(String(fecha)).format('d')]} ${moment(String(fecha)).format('DD')} ${mes[moment(String(fecha)).format('MM') - 1]} ${moment(String(fecha)).format('YYYY')}`
    },
    currency (value) {
      if (!value) {
        value = 0
      }
      return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(value)
    },
    shortTime (time) {
      // 10:10
      const hora = time.substring(0, 2)
      const minuto = time.substring(3, 5)
      return `${hora}:${minuto}`
    },
    datedMy (fecha) {
      // 30 Sep 72
      fecha = fecha.substring(0, 10)
      const mes = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic']
      return `${moment(String(fecha)).format('DD')} ${mes[moment(String(fecha)).format('MM') - 1]} ${moment(String(fecha)).format('YY')}`
    },
    round (value, decimals) {
      if (!value) {
        value = 0
      }
      if (!decimals) {
        decimals = 2
      }
      return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals)
    },
    iva (value, iva) {
      if (!value) {
        value = 0
      }
      if (!iva) {
        iva = 0
      }
      return Number(Math.round(value * iva / 100 + 'e2') + 'e-2')
    }
  }
  // ^ ^ ^ this will allow you to use this.$axios (for Vue Options API form)
  //       so you won't necessarily have to import axios in each vue file

  const token = localStorage.getItem('tokenFolleto')
  if (token) {
    useCounterStore().loading = true
    app.config.globalProperties.$axios.defaults.headers.common.Authorization = `Bearer ${token}`
    app.config.globalProperties.$axios.post('me').then((res) => {
      // console.log(res.data)
      useCounterStore().user = res.data.user
      useCounterStore().permisos = arrayName(res.data.permisos)
      useCounterStore().isLoggedIn = true
      useCounterStore().menus = [
        {
          title: 'Usuarios',
          icon: 'o_people',
          to: '/usuarios',
          color: 'orange',
          visible: arrayName(res.data.permisos).includes('Usuarios')
        },
        {
          title: 'Estadisticas',
          icon: 'insert_chart_outlined',
          to: '/estadisticas',
          color: 'orange',
          visible: arrayName(res.data.permisos).includes('Estadisticas')
        },
        {
          title: 'Central Files',
          icon: 'o_folder',
          to: '/central-files',
          color: 'purple',
          visible: arrayName(res.data.permisos).includes('Central Files')
        },
        {
          title: 'Precios',
          icon: 'attach_money',
          to: '/precios',
          color: 'purple',
          visible: arrayName(res.data.permisos).includes('Precios')
        },
        {
          title: 'Tesoreria',
          icon: 'o_account_balance_wallet',
          to: '/tesoreria',
          color: 'pink',
          visible: arrayName(res.data.permisos).includes('Tesoreria')
        },
        {
          title: 'Facturas',
          icon: 'o_receipt',
          to: '/facturas',
          color: 'pink',
          visible: arrayName(res.data.permisos).includes('Facturas')
        },
        {
          title: 'Diseño',
          icon: 'o_palette',
          to: '/diseno',
          color: 'green',
          visible: arrayName(res.data.permisos).includes('Diseño')
        },
        {
          title: 'Impresion',
          icon: 'o_print',
          to: '/impresion',
          color: 'green',
          visible: arrayName(res.data.permisos).includes('Impresion')
        },
        {
          title: 'Entregas',
          icon: 'o_local_shipping',
          to: '/entregas',
          color: 'grey',
          visible: arrayName(res.data.permisos).includes('Entregas')
        }
        // {
        //   title: 'Nuevo Cliente',
        //   icon: 'o_person_add',
        //   to: '/nuevo-cliente',
        //   color: 'yellow'
        // }
      ]
    }).catch(() => {
      app.config.globalProperties.$axios.defaults.headers.common.Authorization = ''
      useCounterStore().user = {}
      localStorage.removeItem('tokenFolleto')
      useCounterStore().isLoggedIn = false
      router.push('/login')
    }).finally(() => {
      useCounterStore().loading = false
    })
  }
  app.config.globalProperties.$api = api
  // ^ ^ ^ this will allow you to use this.$api (for Vue Options API form)
  //       so you can easily perform requests against your app's API
})
function arrayName (array) {
  const newArray = []
  array.forEach((element) => {
    newArray.push(element.name)
  })
  return newArray
}
export { api }
