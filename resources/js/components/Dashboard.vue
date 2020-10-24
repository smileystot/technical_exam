<template>
  <div>
      <v-row>
        <h2>My Expenses</h2>
        <v-spacer></v-spacer>
        <h2>Dashboard</h2>
      </v-row>
      <v-row>
        <v-col cols="4">
          <v-row>
            <v-col cols="8">
              <h5>Expense Categories</h5>
              <p v-for="(exp,i) in expenses" :key="i">{{exp.CategoryName}}</p>
            </v-col>
            <v-col cols="4">
              <h5>Total</h5>
              <p v-for="(exp,i) in expenses" :key="i">$ {{WithCommas(exp.ExpenseAmount)}}</p>
            </v-col>
          </v-row>
        </v-col>
        <v-spacer></v-spacer>
        <v-col cols="6">
          <apexchart ref="chart" width="500" type="pie" :options="chartOptions" :series="series"></apexchart>
        </v-col>
      </v-row>
  </div>
</template>

<script>

export default {
  data(){
    return {
      expenses:[],
      series: [],
      chartOptions: {
        chart: {
          width: 380,
          type: 'pie',
        },
        labels: [],
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              width: 200
            },
            legend: {
              position: 'bottom'
            }
          }
        }]
      },
      
    }

  },
  created(){
    this.GetChartData()
  },
  methods:{
    WithCommas(x) {
        return x != null ? x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : 0;
    },
    GetChartData(){
        axios.get('api/GetChartData')
        .then(res=>{
          this.expenses = res.data
          var series = [];
          var labels = [];

          res.data.forEach(rec=>{
            this.series.push(parseFloat(rec.ExpenseAmount))
            this.chartOptions.labels.push(rec.CategoryName)
          })
        })

        
    }
  }
}
</script>

<style>

</style>