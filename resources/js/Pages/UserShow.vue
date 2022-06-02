<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head, useForm } from "@inertiajs/inertia-vue3";
import BreezeButton from "@/Components/Button.vue";
import BreezeLabel from "@/Components/Label.vue";
import FlashMessages from "@/Components/FlashMessages.vue";
import BreezeCard from "@/Components/Card.vue";
import BreezeInput from "@/Components/Input.vue";
import BreezeFormError from "@/Components/FormError.vue";

const props = defineProps({
  user: Object,
});

const form = useForm({
  name: props.user.name,
  email: props.user.email,
  password: "",
});

const update = () => {
  form.post(route("user.update", { user: props.user.id }), {
    onSuccess: () => form.reset("password"),
  });
}

const destroy = () => {
  if (confirm("このユーザーを削除してもよろしいですか？")) {
    form.delete(route("user.destroy", { user: props.user.id }));
  }
}
</script>

<template>

  <Head title="プロフィール" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        プロフィール
      </h2>
    </template>

    <div class="profile-area">
      <BreezeCard>
        <!-- フラッシュメッセージ -->
        <FlashMessages />

        <form @submit.prevent="update">
          <!-- ユーザー名 -->
          <div>
            <BreezeLabel for="name" value="User Name" />
            <BreezeInput class="mt-1 block w-full" id="name" type="text" v-model="form.name" />
            <BreezeFormError v-if="form.errors.name">
              {{ form.errors.name }}
            </BreezeFormError>
          </div>

          <!-- ユーザーメールアドレス -->
          <div class="mt-4">
            <BreezeLabel for="email" value="Email" />
            <BreezeInput class="mt-1 block w-full" id="email" type="email" v-model="form.email" />
            <BreezeFormError v-if="form.errors.email">
              {{ form.errors.email }}
            </BreezeFormError>
          </div>

          <!-- ユーザーパスワード -->
          <div class="mt-4">
            <BreezeLabel for="password" value="Password" />
            <BreezeInput class="mt-1 block w-full" id="password" type="password" v-model="form.password" />
            <BreezeFormError v-if="form.errors.password">
              {{ form.errors.password }}
            </BreezeFormError>
          </div>

          <!-- カードフッター -->
          <div class="flex items-center justify-between mt-4">
            <!-- ユーザー削除 -->
            <button class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">
              Delete User
            </button>

            <!-- ユーザーアップデート -->
            <BreezeButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
              update user
            </BreezeButton>
          </div>
        </form>
      </BreezeCard>
    </div>
  </BreezeAuthenticatedLayout>
</template>
