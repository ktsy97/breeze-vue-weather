<script setup>
import { Head } from "@inertiajs/inertia-vue3";
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Inertia } from "@inertiajs/inertia";
defineProps({
  current: Object,
  forecast: Object,
  date: Array,
  chart_date: Array,
  chart_temp: Array,
  result: Boolean,
  city_id: String,
});
</script>

<template>
  <Head :title="`${current.name}`" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <div class="flex items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ current.name }}
        </h2>
        <button class="btn-true rounded ml-3 text-sm font-semibold" v-on:click="fav" v-if="status">
          <span class="normal">登録中</span>
          <span class="hover">登録解除</span>
        </button>
        <button class="btn-false rounded ml-3 text-sm font-semibold" v-on:click="fav" v-else>
          登録
        </button>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- 現在の天気エリア -->
        <div class="current-area">
          <div class="city-card p-4 rounded-lg">
            <h1 class="text-center text-lg mb-2">現在の天気</h1>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div class="col-span-1 text-center max-w-xs m-auto">
                <p>天候:{{ current.weather[0].description }}</p>
                <p class="flex justify-center">
                  <img
                    :src="`http://openweathermap.org/img/wn/${current.weather[0].icon}@2x.png`"
                  />
                </p>
              </div>
              <div
                class="col-span-1 flex flex-col justify-center max-w-xs m-auto"
              >
                <div class="inline-block">
                  <p>気温:{{ current.main.temp }}&deg;C</p>
                  <p>体感気温:{{ current.main.feels_like }}&deg;C</p>
                  <p>大気圧:{{ current.main.pressure }}hPa</p>
                  <p>湿度:{{ current.main.humidity }}%</p>
                  <p>風速:{{ current.wind.speed }}メートル/秒</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- 24時間の気温エリア -->
        <div class="chart-area rounded-lg">
          <h1 class="text-center text-lg mb-2">24時間の気温</h1>
          <LineChart :chartData="lineData" />
        </div>

        <!-- 5日間の天気予想エリア -->
        <div class="table-area rounded-lg">
          <h1 class="text-center text-lg mb-2">5日間の天気予想</h1>
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
                <tr v-for="(item, index) in forecast.list" :key="index">
                  <td class="border px-4 py-2">{{ date[index] }}</td>
                  <td class="border px-4 py-2">{{ item.main.temp }}&deg;C</td>
                  <td class="border px-4 py-2">
                    {{ item.weather[0].description }}
                  </td>
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
.btn-false {
  color: #1f2937;
  border: 1px solid #bbb;
  width: 6rem;
  padding: 0.25rem 0;
}
.btn-false:hover {
  border: 1px solid #222;
}
.btn-true {
  color: #0990cc;
  border: 1px solid #0990cc;
  width: 6rem;
  padding: 0.25rem 0;
}
.btn-true:hover {
  border: 1px solid #f23e48;
}
.btn-true .hover {
  display: none;
}
.btn-true:hover .normal {
  display: none;
}
.btn-true:hover .hover {
  color: #f23e48;
  display: inline;
}
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
  data() {
    return {
      status: this.result,
    };
  },
  components: {
    PieChart,
    LineChart,
  },
  computed: {
    lineData() {
      return {
        labels: this.chart_date,
        datasets: [
          {
            label: "気温",
            data: this.chart_temp,
            fill: true,
            borderColor: "rgb(75, 192, 192)",
            tension: 0.1,
          },
        ],
      };
    },
  },
  methods: {
    fav: function (e) {
      axios
        .post("/city/fav", {
          status: this.status,
          city_id: this.city_id,
        })
        .then(
          function (res) {
            this.status = res.data;
          }.bind(this)
        )
        .catch(function (error) {
          console.log(error);
        });
    },
  },
});
</script>
