<template>
  <div class="wrapper">
    <div class="hover-card">
      <div class="hover-card_title mt-2 mb-3">
        <slot name="title" />
      </div>
      <div class="hover-card_text">
        <slot name="text" />
      </div>
      <slot />
    </div>
  </div>
</template>

<style scoped>
.wrapper {
  margin: 1rem auto;
  width: 100%;
  max-width: 32rem;
}

.wrapper:hover {
  transform: translateY(-5px);
  box-shadow: 0 7px 34px rgba(50, 50, 93, 0.1), 0 3px 6px rgba(0, 0, 0, 0.08);
  transition: all 0.5s;
}

.hover-card {
  background-color: white;
  box-shadow: 0 2px 5px #ccc;
  padding: 1rem;
  border-radius: 0.5rem;
}

.hover-card:hover {
  color: #495057;
}

.hover-card_title {
  font-size: 1.2rem;
  font-weight: 600;
  color: #212529;
}

.hover-card_text {
  color: #5b6268;
}
</style>
