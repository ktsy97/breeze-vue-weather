<script setup>
import { Head, Link } from "@inertiajs/inertia-vue3";
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import BreezeHoverCard from "@/Components/HoverCard.vue";
import { Inertia } from '@inertiajs/inertia'

defineProps({
  data: Array,
});

const select = (e) => {
  const val = e.target.value;
  Inertia.visit(route("city.select"), {
    method: "post", //POSTメソッドで送信
    data: {
      area: val, //送信データを指定
    },
    only: ["data"],
    preserveState: true,
  });
}
</script>

<template>

  <Head title="一覧" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">一覧</h2>
    </template>

    <!-- セレクトボックス -->
    <div class="select-area flex justify-center pb-4">
      <select class="form-select rounded" v-on:change="select">
        <option value="0">お気に入り</option>
        <option value="1">北海道・東北</option>
        <option value="2">関東・甲信</option>
        <option value="3">北陸</option>
        <option value="4">東海</option>
        <option value="5">近畿</option>
        <option value="6">中国</option>
        <option value="7">四国</option>
        <option value="8">九州・沖縄</option>
      </select>
    </div>

    <!-- カード一覧 -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4" v-if="data.length">
      <!-- カード -->
      <div class="col" v-for="(item, index) in data" :key="index">
        <Link :href="route('city.show', { city_id: item.id })">
        <BreezeHoverCard class="text-center">
          <template #title>
            <p>{{ item.name }}</p>
          </template>
          <template #text>
            <p>気温:{{ item.main.temp }}&deg;C</p>
            <p>天候:{{ item.weather[0].description }}</p>
          </template>
          <p class="flex justify-center">
            <img :src="`/img/weather/${item.weather[0].icon}.png`" />
          </p>
        </BreezeHoverCard>
        </Link>
      </div>
    </div>

    <!-- dataが存在しない場合 -->
    <div class="text-center" v-else>
      <p>お気に入りは登録されていません</p>
    </div>
  </BreezeAuthenticatedLayout>
</template>
