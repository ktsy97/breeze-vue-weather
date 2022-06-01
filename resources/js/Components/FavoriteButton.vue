<template>
  <button class="btn rounded ml-3 text-sm font-semibold">
    <div class="btn_text__normal">
      <slot name="btn_text__normal" />
    </div>
    <div class="btn_text__hover">
      <slot name="btn_text__hover" />
    </div>
    <slot />
  </button>
</template>

<style scoped>
.btn {
  width: 6rem;
  padding: 0.25rem 0;
}
.btn__true {
  color: #0990cc;
  border: 1px solid #0990cc;
}
.btn__true:hover {
  border: 1px solid #f23e48;
}
.btn__true .btn_text__hover {
  display: none;
}
.btn__true:hover .btn_text__normal {
  display: none;
}
.btn__true:hover .btn_text__hover {
  color: #f23e48;
  display: inline;
}
.btn__false {
  color: #1f2937;
  border: 1px solid #bbb;
}
.btn__false:hover {
  border: 1px solid #222;
}
</style>
