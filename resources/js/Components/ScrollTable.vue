<script setup>
defineProps({
  columns: Array,
  rows: Object,
  date: Array,
});
</script>

<template>
  <div class="wrapper">
    <table class="table">
      <thead>
        <tr>
          <th class="table_th px-4 py-2" v-for="(col, idx) in columns" :key="idx">
            {{ col }}
          </th>
        </tr>
      </thead>
      <tbody>
        <tr class="table_tr" v-for="(row, idx) in rows" :key="idx">
          <td class="table_td px-4 py-2">{{ date[idx] }}</td>
          <td class="table_td px-4 py-2">{{ row.main.temp }}&deg;C</td>
          <td class="table_td px-4 py-2">
            <p>{{ row.weather[0].description }}</p>
            <p>
              <img class="mx-auto" :src="`/img/weather/${row.weather[0].icon}.png`" />
            </p>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<style scoped>
.wrapper {
  overflow: auto;
}

.table {
  border-collapse: collapse;
  width: calc(100% - 80px);
  white-space: nowrap;
  border-spacing: 0;
  writing-mode: vertical-lr;
}

.table_tr {
  cursor: pointer;
}

.table_tr:hover {
  background-color: #eee;
}

.table_th,
.table_td {
  border: 0;
  border-right: solid 1px #eee;
  text-align: center;
  writing-mode: horizontal-tb;
}
</style>
