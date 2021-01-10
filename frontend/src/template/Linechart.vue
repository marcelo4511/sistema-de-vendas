
<script>
import { Doughnut } from "vue-chartjs";
import ChartDataLabels  from "chartjs-plugin-datalabels";

export default {
  extends: Doughnut,
  props: {
    chartdata: {
      type: Object,
      default: null
    },
    options: {
      type: Object,
      default: null,
      title: {
            display: true,
            text: 'Total Sales by Country - Top 5',
            fontSize: 15,
            fontStyle: 'bold'
        },
        legend: {
            display: true,
            position: 'bottom',
        },
  
    
    }
  },
  mounted () {
    this.addPlugin(ChartDataLabels);
    this.renderChart(this.chartdata, this.options)
  }
}
</script>
<style>

</style>