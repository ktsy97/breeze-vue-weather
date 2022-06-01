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
        <div class="profile-area">
          <BreezeCard>
            <!-- フラッシュメッセージ -->
            <flash-messages />

            <form @submit.prevent="update">
              <!-- ユーザー名 -->
              <div>
                <BreezeLabel for="name" value="User Name" />
                <BreezeInput
                  class="mt-1 block w-full"
                  id="name"
                  type="text"
                  v-model="form.name"
                />
                <BreezeFormError v-if="form.errors.name">
                  {{ form.errors.name }}
                </BreezeFormError>
              </div>

              <!-- ユーザーメールアドレス -->
              <div class="mt-4">
                <BreezeLabel for="email" value="Email" />
                <BreezeInput
                  class="mt-1 block w-full"
                  id="email"
                  type="email"
                  v-model="form.email"
                />
                <BreezeFormError v-if="form.errors.email">
                  {{ form.errors.email }}
                </BreezeFormError>
              </div>

              <!-- ユーザーパスワード -->
              <div class="mt-4">
                <BreezeLabel for="password" value="Password" />
                <BreezeInput
                  class="mt-1 block w-full"
                  id="password"
                  type="password"
                  v-model="form.password"
                />
                <BreezeFormError v-if="form.errors.password">
                  {{ form.errors.password }}
                </BreezeFormError>
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
          </BreezeCard>
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>

<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import BreezeButton from "@/Components/Button.vue";
import BreezeLabel from "@/Components/Label.vue";
import FlashMessages from "@/Components/FlashMessages.vue";
import BreezeCard from "@/Components/Card.vue";
import BreezeInput from "@/Components/Input.vue";
import BreezeFormError from "@/Components/FormError.vue";

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
