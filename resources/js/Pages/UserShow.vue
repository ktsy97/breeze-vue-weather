<template>
  <Head title="プロフィール" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        プロフィール
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="profile-card p-4 rounded-lg">
            <!-- フラッシュメッセージ -->
            <flash-messages />

            <form @submit.prevent="update">
              <!-- ユーザー名 -->
              <div>
                <BreezeLabel for="name" value="User Name" />
                <input
                  class="input"
                  id="name"
                  type="text"
                  v-model="form.name"
                />
                <div class="form-error" v-if="form.errors.name">
                  {{ form.errors.name }}
                </div>
              </div>

              <!-- ユーザーメールアドレス -->
              <div class="mt-4">
                <BreezeLabel for="email" value="Email" />
                <input
                  class="input"
                  id="email"
                  type="email"
                  v-model="form.email"
                />
                <div class="form-error" v-if="form.errors.email">
                  {{ form.errors.email }}
                </div>
              </div>

              <!-- ユーザーパスワード -->
              <div class="mt-4">
                <BreezeLabel for="password" value="Password" />
                <input
                  class="input"
                  id="password"
                  type="password"
                  v-model="form.password"
                />
                <div class="form-error" v-if="form.errors.password">
                  {{ form.errors.password }}
                </div>
              </div>

              <!-- カードフッター -->
              <div class="flex items-center justify-between mt-4">
                <!-- ユーザー削除 -->
                <button
                  class="text-red-600 hover:underline"
                  tabindex="-1"
                  type="button"
                  @click="destroy"
                >
                  Delete User
                </button>

                <!-- ユーザーアップデート -->
                <BreezeButton
                  :class="{ 'opacity-25': form.processing }"
                  :disabled="form.processing"
                >
                  update user
                </BreezeButton>
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
  border-color: rgb(209, 213, 219);
  border-radius: 0.375rem;
  box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
  margin-top: 0.25rem;
  display: block;
  width: 100%;
}
.input:focus {
  border-color: rgb(165, 180, 252);
}
.form-error {
  font-size: 0.875rem;
  line-height: 1.25rem;
  margin-top: 0.5rem;
  color: rgba(185, 28, 28);
}
</style>

<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import BreezeButton from "@/Components/Button.vue";
import BreezeLabel from "@/Components/Label.vue";
import FlashMessages from "@/Components/FlashMessages.vue";

defineProps({
  user: Object,
});
</script>

<script>
export default {
  data() {
    return {
      form: this.$inertia.form({
        name: this.user.name,
        email: this.user.email,
        password: "",
      }),
    };
  },
  methods: {
    update() {
      this.form.post(route("user.update", { user: this.user.id }), {
        onSuccess: () => this.form.reset("password"),
      });
    },
    destroy() {
      if (confirm("このユーザーを削除してもよろしいですか？")) {
        this.form.delete(route("user.destroy", { user: this.user.id }));
      }
    },
  },
};
</script>
