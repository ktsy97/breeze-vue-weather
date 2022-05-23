<script setup>
import { Head } from "@inertiajs/inertia-vue3";
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Inertia } from "@inertiajs/inertia";
</script>

<template>
  <Head title="東京都" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">東京都</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="current-area">
          <div class="city-card p-4 rounded-lg">
            <h1 class="text-center text-lg mb-2">現在の天気</h1>
            <div class="grid grid-cols-2 gap-4">
              <div class="col text-center">
                <p>天候:晴れ</p>
                <p class="flex justify-center">
                  <img :src="`http://openweathermap.org/img/wn/01d@2x.png`" />
                </p>
              </div>
              <div class="col text-center flex flex-col justify-center">
                <p>気温:30&deg;C</p>
                <p>体感気温:31&deg;C</p>
                <p>大気圧:1000hPa</p>
                <p>湿度:60%</p>
              </div>
            </div>
          </div>
        </div>
        <div class="chart-area rounded-lg">
          <h1 class="text-center text-lg mb-2">一日の気温</h1>
          <LineChart :chartData="lineData" />
        </div>
        <div class="table-area rounded-lg">
          <h1 class="text-center text-lg mb-2">4日間の天気予想</h1>
          <div class="scroll-table">
            <table class="table">
              <thead>
                <tr>
                  <th class="px-4 py-2">日時</th>
                  <th class="px-4 py-2">気温</th>
                  <th class="px-4 py-2">天候</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="border px-4 py-2">2022-05-22 03:00:00</td>
                  <td class="border px-4 py-2">19.29&deg;C</td>
                  <td class="border px-4 py-2">晴れ</td>
                </tr>
                <tr>
                  <td class="border px-4 py-2">2022-05-22 06:00:00</td>
                  <td class="border px-4 py-2">19.29&deg;C</td>
                  <td class="border px-4 py-2">晴れ</td>
                </tr>
                <tr>
                  <td class="border px-4 py-2">2022-05-22 09:00:00</td>
                  <td class="border px-4 py-2">19.29&deg;C</td>
                  <td class="border px-4 py-2">晴れ</td>
                </tr>
                <tr>
                  <td class="border px-4 py-2">2022-05-22 09:00:00</td>
                  <td class="border px-4 py-2">19.29&deg;C</td>
                  <td class="border px-4 py-2">晴れ</td>
                </tr>
                <tr>
                  <td class="border px-4 py-2">2022-05-22 09:00:00</td>
                  <td class="border px-4 py-2">19.29&deg;C</td>
                  <td class="border px-4 py-2">晴れ</td>
                </tr>
                <tr>
                  <td class="border px-4 py-2">2022-05-22 09:00:00</td>
                  <td class="border px-4 py-2">19.29&deg;C</td>
                  <td class="border px-4 py-2">晴れ</td>
                </tr>
                <tr>
                  <td class="border px-4 py-2">2022-05-22 09:00:00</td>
                  <td class="border px-4 py-2">19.29&deg;C</td>
                  <td class="border px-4 py-2">晴れ</td>
                </tr>
                <tr>
                  <td class="border px-4 py-2">2022-05-22 09:00:00</td>
                  <td class="border px-4 py-2">19.29&deg;C</td>
                  <td class="border px-4 py-2">晴れ</td>
                </tr>
                <tr>
                  <td class="border px-4 py-2">2022-05-22 09:00:00</td>
                  <td class="border px-4 py-2">19.29&deg;C</td>
                  <td class="border px-4 py-2">晴れ</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>

<style scoped>
.city-card {
  background-color: white;
  box-shadow: 0 2px 5px #ccc;
}
.chart-area {
  padding: 1rem;
  margin-top: 1rem;
  background-color: white;
  box-shadow: 0 2px 5px #ccc;
}
.table-area {
  margin-top: 1rem;
  padding: 1rem;
  background-color: white;
  box-shadow: 0 2px 5px #ccc;
}
.scroll-table {
  overflow: auto;
}
.table {
  border-collapse: collapse;
  width: calc(100% - 80px);
  white-space: nowrap;
  border-spacing: 0;
  writing-mode: vertical-lr;
}
.table tr {
  cursor: pointer;
}
table tr:hover {
  background-color: #eee;
}
.table th,
.table td {
  border: 0;
  border-right: solid 1px #eee;
  text-align: center;
  writing-mode: horizontal-tb;
}
</style>

<script>
import { Chart, registerables } from "chart.js";
import { defineComponent } from "vue";
import { PieChart, LineChart } from "vue-chart-3";

Chart.register(...registerables);

export default defineComponent({
  components: {
    PieChart,
    LineChart,
  },
  computed: {
    lineData() {
      return {
        labels: [
          "2022-05-22 03:00:00",
          "2022-05-22 06:00:00",
          "2022-05-22 09:00:00",
          "2022-05-22 12:00:00",
          "2022-05-22 15:00:00",
          "2022-05-22 18:00:00",
          "2022-05-22 21:00:00",
          "2022-05-23 00:00:00",
        ],
        datasets: [
          {
            label: "気温",
            data: [19.29, 21.18, 20.58, 18.35, 17.2, 16.92, 16.77, 19.86],
            fill: true,
            borderColor: "rgb(75, 192, 192)",
            tension: 0.1,
          },
        ],
      };
    },
  },
});
</script>
