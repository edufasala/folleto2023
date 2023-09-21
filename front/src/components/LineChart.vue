<template>
  <div>
    <div class="row">
      <div class="col-12 col-md-6 text-right">
        <q-select outlined dense label="Usuario" v-model="usuario" :options="usuarios"
                  emit-value map-options :option-label="item => item.name" :option-value="item => item.id"
                  @update:model-value="dialogFechas=true"
        />
      </div>
      <div class="col-12 col-md-6 text-right">
        <q-btn label="Semana" color="primary" dense class="q-ml-xs" outlined no-caps :loading="loading" @click="consulta('semana')"/>
        <q-btn label="Mes" color="primary" dense class="q-ml-xs" outlined no-caps :loading="loading" @click="consulta('mes')"/>
        <q-btn label="Año" color="primary" dense class="q-ml-xs" outlined no-caps :loading="loading" @click="consulta('año')"/>
      </div>
    </div>
    <highcharts
      :options="chartOptions"
    ></highcharts>
    <q-dialog v-model="dialogFechas">
      <q-card>
        <q-card-section class="q-pb-none">
          <div class="text-bold">Selecciona las fechas</div>
        </q-card-section>
        <q-card-section>
          <q-input outlined dense v-model="dateIni" label="Fecha inicial" type="date" />
          <q-input outlined dense v-model="dateFin" label="Fecha final" type="date" />
        </q-card-section>
        <q-card-actions align="right">
          <q-btn label="Cancelar" color="primary" flat @click="dialogFechas = false" />
          <q-btn label="Aceptar" color="primary" flat @click="reporteEntreFechas" />
        </q-card-actions>
      </q-card>
    </q-dialog>
  </div>
</template>

<script>
import Highcharts from 'highcharts'
import exportingInit from 'highcharts/modules/exporting'
import stockInit from 'highcharts/modules/stock'
import offlineExporting from 'highcharts/modules/offline-exporting'

stockInit(Highcharts)
exportingInit(Highcharts)
offlineExporting(Highcharts)
import moment from 'moment'
export default {
  data () {
    return {
      dialogFechas: false,
      usuarios: [
        {
          id: 0,
          name: 'Todos'
        }
      ],
      usuario: 0,
      loading: false,
      dateIni: moment().startOf('month').format('YYYY-MM-DD'),
      dateFin: moment().endOf('month').format('YYYY-MM-DD'),
      chartOptions: {
        title: {
          text: 'Estadisticas generales',
          align: 'left'
        },
        subtitle: {
          text: '',
          align: 'left'
        },
        yAxis: {
          title: {
            text: 'Numero de pedidos'
          }
        },

        xAxis: {
          categories: []
        },

        legend: {
          layout: 'vertical',
          align: 'right',
          verticalAlign: 'middle'
        },

        series: [
          {
            name: 'Pedidos realizados',
            data: [0]
          }
        ],

        responsive: {
          rules: [{
            condition: {
              maxWidth: 500
            },
            chartOptions: {
              legend: {
                layout: 'horizontal',
                align: 'center',
                verticalAlign: 'bottom'
              }
            }
          }]
        }
      }
    }
  },
  created () {
    this.usuariosGet()
    this.reportBetween()
  },
  methods: {
    reporteEntreFechas () {
      this.dialogFechas = false
      this.reportBetween()
    },
    consulta (type) {
      if (type === 'semana') {
        this.dateIni = moment().startOf('week').format('YYYY-MM-DD')
        this.dateFin = moment().endOf('week').format('YYYY-MM-DD')
      } else if (type === 'mes') {
        this.dateIni = moment().startOf('month').format('YYYY-MM-DD')
        this.dateFin = moment().endOf('month').format('YYYY-MM-DD')
      } else if (type === 'año') {
        this.dateIni = moment().startOf('year').format('YYYY-MM-DD')
        this.dateFin = moment().endOf('year').format('YYYY-MM-DD')
      }
      this.reportBetween()
    },
    reportBetween () {
      this.loading = true
      console.log(this.usuario)
      this.chartOptions.subtitle.text = `del ${moment(this.dateIni).format('DD/MM/YYYY')} al ${moment(this.dateFin).format('DD/MM/YYYY')}`
      this.$axios.post('reportBetween', {
        dateIni: this.dateIni,
        dateFin: this.dateFin,
        usuario: this.usuario
      }).then(response => {
        console.log(response.data)
        this.chartOptions.xAxis.categories = []
        this.chartOptions.series[0].data = []
        response.data.forEach((item, index) => {
          this.chartOptions.xAxis.categories[index] = item.fecha
          this.chartOptions.series[0].data[index] = item.cantidad
        })
        this.loading = false
      }).catch(error => {
        console.log(error)
        this.loading = false
      })
    },
    usuariosGet () {
      this.$axios.get('users').then(response => {
        // this.usuarios = response.data
        response.data.forEach((item, index) => {
          this.usuarios.push(item)
        })
      }).catch(error => {
        console.log(error)
      })
    }
  }
  // props: {
  //   chartOptions: {
  //     type: Object,
  //     default: () => {}
  //   }
  // }
}
</script>
