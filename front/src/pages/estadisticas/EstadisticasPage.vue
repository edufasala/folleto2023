<template>
  <q-page class="container q-pa-md">
    <div class="row">
      <div class="col-12 col-md-12">
        <LineChart :chartOptions="chartOptions"/>
      </div>
      <div class="col-12 col-md-6">
        <PieChart :chartOptions="chartOptions"/>
      </div>
    </div>
  </q-page>
</template>
<script>
import moment from 'moment'
import PieChart from 'components/PieChart.vue'
import LineChart from 'components/LineChart.vue'
export default {
  name: 'EstadisticasPage',
  components: {
    PieChart,
    LineChart
  },
  data () {
    return {
      chartOptions: {
        chart: {
          plotBackgroundColor: null,
          plotBorderWidth: null,
          plotShadow: false,
          type: 'pie'
        },
        title: {
          text: 'Productos Vendidos',
          align: 'center'
        },
        subtitle: {
          text: `del ${moment().startOf('month').format('DD/MM/YYYY')} al ${moment().endOf('month').format('DD/MM/YYYY')}`
        },
        tooltip: {
          pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        accessibility: {
          point: {
            valueSuffix: '%'
          }
        },
        plotOptions: {
          pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
              enabled: true,
              format: '<b>{point.name}</b>: {point.percentage:.1f} %'
            }
          }
        },
        series: [
          {
            name: 'Producto',
            colorByPoint: true,
            data: [
              {
                name: 'Producto 1',
                y: 61.41,
                sliced: true,
                selected: true
              },
              {
                name: 'Producto 2',
                y: 11.84
              },
              {
                name: 'Producto 3',
                y: 10.85
              },
              {
                name: 'Producto 4',
                y: 4.67
              },
              {
                name: 'Producto 5',
                y: 4.18
              },
              {
                name: 'Producto 6',
                y: 1.64
              },
              {
                name: 'Producto 7',
                y: 1.6
              },
              {
                name: 'Producto 8',
                y: 1.2
              },
              {
                name: 'Producto 9',
                y: 2.61
              }
            ]
          }
        ]
      }
    }
  }
}
</script>
