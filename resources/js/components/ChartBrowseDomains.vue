<template>
  <div>
    <canvas ref="el" class="h-full" />
  </div>
</template>

<script setup lang="ts">
import { Chart, BarController, BarElement, CategoryScale, LinearScale } from 'chart.js'

const props = defineProps<{
  labels: string[]
  data: number[]
}>()

const el = ref(null!) as Ref<HTMLCanvasElement>
let chart = null as Chart | null

Chart.register(BarController, BarElement, CategoryScale, LinearScale)

onMounted(() => {
  chart = new Chart(el.value, {
    type: 'bar',
    data: {
      labels: props.labels,
      datasets: [{
        data: props.data,
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        borderColor: 'rgba(54, 162, 235, 0.2)',
        barThickness: 12,
      }],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      interaction: {
        mode: 'index',
        intersect: false,
      },
      scales: {
        x: {
          grid: {
            display: false,
          },
        },
        y: {
          grid: {
            tickBorderDash: [3],
          },
          border: {
            display: false,
          },
        },
      },
    },
  })
})

onBeforeUnmount(() => {
  chart?.destroy()
})
</script>
