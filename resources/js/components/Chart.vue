<script>
  import { Pie } from 'vue-chartjs'

  export default {
    extends: Pie,
    data () {
      return {
        chartData: {
          labels: ["Italy", "India", "Japan", "USA",],
          datasets: [{
              borderWidth: 1,
              backgroundColor: [
              'red',
              'black',
              'blue',
              'green',                
              ],
              data: [1000,	500,	1500,	1000]
            }]
        },
        options: {
          legend: {
            display: true
          },
          responsive: true,
          maintainAspectRatio: false
        }
      }
    },
    methods:{
        colors(){
            var r = Math.floor(Math.random() * 255);
            var g = Math.floor(Math.random() * 255);
            var b = Math.floor(Math.random() * 255);
            return "rgb(" + r + "," + g + "," + b + ")";
        }
    },
    mounted () {
      this.renderChart(this.chartData, this.options)
    }
  }
</script>