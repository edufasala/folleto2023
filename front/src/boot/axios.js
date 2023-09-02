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
  app.config.globalProperties.$filters = {
    dateDmY (fecha) {
      // 30 Set 1972
      fecha = fecha.substring(0, 10)
      const dias = ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado']
      const mes = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre']
      return ` ${dias[moment(String(fecha)).format('d')]} ${moment(String(fecha)).format('DD')} de ${mes[moment(String(fecha)).format('MM') - 1]} del ${moment(String(fecha)).format('YYYY')}`
    },
    shortDate (fecha) {
      // Sab 30 Set 1972
      fecha = fecha.substring(0, 10)
      const dias = ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab']
      const mes = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Set', 'Oct', 'Nov', 'Dic']
      return `${dias[moment(String(fecha)).format('d')]} ${moment(String(fecha)).format('DD')} ${mes[moment(String(fecha)).format('MM') - 1]} ${moment(String(fecha)).format('YYYY')}`
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
      useCounterStore().permisos = res.data.permisos
      useCounterStore().isLoggedIn = true
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

export { api }
