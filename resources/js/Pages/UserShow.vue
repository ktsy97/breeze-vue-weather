<template>
  <Head title="プロフィール" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        ユーザー名
        <span> / プロフィール</span>
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="profile-card p-4 rounded-lg">
            <form>
              <div>
                <BreezeLabel for="name" value="User Name" />
                <input
                  class="input"
                  id="name"
                  :value="user.name"
                  type="text"
                />
              </div>
              <div class="mt-4">
                <BreezeLabel for="email" value="Email" />
                <input
                  class="input"
                  id="email"
                  type="email"
                  :value="user.email"
                />
                <div class="mt-4">
                  <BreezeLabel for="password" value="Password" />
                  <input
                    class="input"
                    id="password"
                    value="example-password"
                    type="password"
                  />
                </div>
                <div class="flex items-center justify-between mt-4">
                  <button
                    class="text-red-600 hover:underline"
                    tabindex="-1"
                    type="button"
                  >
                    Delete User
                  </button>
                  <BreezeButton
                    class="ml-4"
                  >
                    update user
                  </BreezeButton>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>

<style scoped>
.profile-card {
  background-color: white;
  box-shadow: 0 2px 5px #ccc;
}
.input {
  border-color: rgb(209 213 219);
  border-radius: 0.375rem;
  box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
  margin-top: 0.25rem;
  display: block;
  width: 100%;
}
.input:focus {
  border-color: rgb(165 180 252);
}
</style>

<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import BreezeButton from "@/Components/Button.vue";
import BreezeLabel from "@/Components/Label.vue";

defineProps({
  user: Object,
});
</script>
