<script>

import { Line } from 'vue-chartjs'
 
export default {
  extends: Line,
 props : ['label','labels','data', 'background'],
  mounted () {
    // Overwriting base render method with actual data.
    this.renderChart({
      labels: this.labels,
      datasets: [
        {
          label: this.label,
          backgroundColor: this.background , //['#41b883', '#f87979'],
          data:  this.data
        }
      ]
    }, {   responsive: true,
      maintainAspectRatio: false })
  }
}

</script>