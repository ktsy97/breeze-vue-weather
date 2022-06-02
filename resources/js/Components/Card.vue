<template>
  <div class="card">
    <div class="card_body">
      <div class="card_title">
        <slot name="card_title" />
      </div>
      <slot />
    </div>
  </div>
</template>

<style scoped>
.card_title {
  color: #333333;
  text-align: center;
  margin-bottom: 0.5rem;
}

.card_body {
  background-color: white;
  box-shadow: 0 2px 5px #ccc;
  padding: 1rem;
  border-radius: 0.5rem;
}
</style>
