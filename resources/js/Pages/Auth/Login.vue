<script setup>
import BreezeButton from "@/Components/Button.vue";
import BreezeCheckbox from "@/Components/Checkbox.vue";
import BreezeGuestLayout from "@/Layouts/Guest.vue";
import BreezeInput from "@/Components/Input.vue";
import BreezeLabel from "@/Components/Label.vue";
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";
import { Head, useForm } from "@inertiajs/inertia-vue3";
import BreezeFormError from "@/Components/FormError.vue";
import FlashMessages from "@/Components/FlashMessages.vue";

defineProps({
  canResetPassword: Boolean,
  status: String,
});

const form = useForm({
  email: "",
  password: "",
  remember: false,
});

const submit = () => {
  form.post(route("login"), {
    onFinish: () => form.reset("password"),
  });
};
</script>

<template>
  <BreezeGuestLayout>

    <Head title="Log in" />

    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
      {{ status }}
    </div>

    <FlashMessages />

    <form @submit.prevent="submit">
      <div>
        <BreezeLabel for="email" value="Email" />
        <BreezeInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus
          autocomplete="username" />
        <BreezeFormError v-if="form.errors.email">
          {{ form.errors.email }}
        </BreezeFormError>
      </div>

      <div class="mt-4">
        <BreezeLabel for="password" value="Password" />
        <BreezeInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required
          autocomplete="current-password" />
        <BreezeFormError v-if="form.errors.password">
          {{ form.errors.password }}
        </BreezeFormError>
      </div>

      <div class="flex items-center justify-end mt-4">
        <BreezeButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
          Log in
        </BreezeButton>
      </div>
    </form>
  </BreezeGuestLayout>
</template>
