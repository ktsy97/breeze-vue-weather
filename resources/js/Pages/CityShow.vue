<template>
  <Head :title="`${current.name}`" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <div class="flex items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ current.name }}
        </h2>
        <BreezeFavoriteButton
          :class="`btn__true`"
          v-on:click="fav"
          v-if="status"
        >
          <template #btn_text__normal>登録中</template>
          <template #btn_text__hover>登録解除</template>
        </BreezeFavoriteButton>
        <BreezeFavoriteButton :class="`btn__false`" v-on:click="fav" v-else>
          登録
        </BreezeFavoriteButton>
      </div>
    </template>

    <!-- 現在の天気エリア -->
    <div class="current-area">
      <BreezeCard>
        <template #card_title>現在の天気</template>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div class="col-span-1 text-center max-w-xs m-auto">
            <p>天候:{{ current.weather[0].description }}</p>
            <p class="flex justify-center">
              <img :src="`/img/weather/${current.weather[0].icon}@2x.png`" />
            </p>
          </div>
          <div class="col-span-1 flex flex-col justify-center max-w-xs m-auto">
            <div class="inline-block">
              <p>気温:{{ current.main.temp }}&deg;C</p>
              <p>体感気温:{{ current.main.feels_like }}&deg;C</p>
              <p>大気圧:{{ current.main.pressure }}hPa</p>
              <p>湿度:{{ current.main.humidity }}%</p>
              <p>風速:{{ current.wind.speed }}メートル/秒</p>
            </div>
          </div>
        </div>
      </BreezeCard>
    </div>

    <!-- 24時間の気温エリア -->
    <div class="chart-area mt-4">
      <BreezeCard>
        <template #card_title>24時間の気温</template>
        <LineChart :chartData="lineData" />
      </BreezeCard>
    </div>

    <!-- 5日間の天気予想エリア -->
    <div class="table-area mt-4">
      <BreezeCard>
        <template #card_title>5日間の天気予想</template>
        <BreezeScrollTable
          :columns="columns"
          :rows="forecast.list"
          :date="date"
        >
        </BreezeScrollTable>
      </BreezeCard>
    </div>
  </BreezeAuthenticatedLayout>
</template>

<script setup>
import { Head } from "@inertiajs/inertia-vue3";
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Inertia } from "@inertiajs/inertia";
import BreezeCard from "@/Components/Card.vue";
import BreezeFavoriteButton from "@/Components/FavoriteButton.vue";
import BreezeScrollTable from "@/Components/ScrollTable.vue";

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

<script>
import { Chart, registerables } from "chart.js";
import { defineComponent } from "vue";
import { PieChart, LineChart } from "vue-chart-3";

Chart.register(...registerables);

export default defineComponent({
  data() {
    return {
      status: this.result,
      columns: ["日時", "気温", "天候"],
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
        .post(route("city.fav"), {
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
