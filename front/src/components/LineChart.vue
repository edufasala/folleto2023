<template>
  <div>
    <div class="row">
      <div class="col-12 col-md-6 text-right">
        <q-select outlined dense label="Usuario" v-model="usuario" :options="usuarios" />
      </div>
      <div class="col-12 col-md-6 text-right">
        <q-btn label="Semana" color="primary" dense class="q-ml-xs" outlined no-caps :loading="loading" @click="consulta('semana')"/>
        <q-btn label="Mes" color="primary" dense class="q-ml-xs" outlined no-caps :loading="loading"/>
        <q-btn label="Año" color="primary" dense class="q-ml-xs" outlined no-caps :loading="loading"/>
      </div>
    </div>
    <highcharts
      :options="chartOptions"
    ></highcharts>
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
      usuarios: [],
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

        // plotOptions: {
        //   series: {
        //     label: {
        //       connectorAllowed: false
        //     },
        //     pointStart: 2010
        //   }
        // },

        series: [
          {
            name: 'Pedidos realizados',
            data: [0]
          }
          // {
          //   name: 'Manufacturing',
          //   data: [24916, 37941, 29742, 29851, 32490, 30282,
          //     38121, 36885, 33726, 34243, 31050]
          // },
          // {
          //   name: 'Sales & Distribution',
          //   data: [11744, 30000, 16005, 19771, 20185, 24377,
          //     32147, 30912, 29243, 29213, 25663]
          // },
          // {
          //   name: 'Operations & Maintenance',
          //   data: [null, null, null, null, null, null, null,
          //     null, 11164, 11218, 10077]
          // },
          // {
          //   name: 'Other',
          //   data: [21908, 5548, 8105, 11248, 8989, 11816, 18274,
          //     17300, 13053, 11906, 10073]
          // }
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
    this.loading = true
    this.chartOptions.subtitle.text = `del ${moment(this.dateIni).format('DD/MM/YYYY')} al ${moment(this.dateFin).format('DD/MM/YYYY')}`
    this.$axios.post('reportBetween', {
      dateIni: this.dateIni,
      dateFin: this.dateFin
    }).then(response => {
      console.log(response.data)
      response.data.forEach((item, index) => {
        this.chartOptions.xAxis.categories[index] = item.fecha
        this.chartOptions.series[0].data[index] = item.cantidad
      })
      this.loading = false
    }).catch(error => {
      console.log(error)
      this.loading = false
    })
  }
  // props: {
  //   chartOptions: {
  //     type: Object,
  //     default: () => {}
  //   }
  // }
}
</script>
