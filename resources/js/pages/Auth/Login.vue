<template>
  <div
    class="min-h-screen bg-[length:100%] bg-[#f0f2f5] bg-center bg-no-repeat"
    style="background-image: url('/images/background.svg')"
  >
    <div class="max-w-sm px-4 py-16 mx-auto">
      <div class="text-gray-900 text-4xl text-center font-bold">yBlock</div>

      <form class="mt-16" :form="form" @submit.prevent="form.post('/login')">
        <AAlert
          v-if="form.errors.username ?? form.errors.password"
          type="error"
          showIcon
          class="!mb-6"
          :message="form.errors.username ?? form.errors.password"
        />

        <AFormItem>
          <AInput
            v-model:value="form.username"
            size="large"
            type="text"
            placeholder="帳號"
          >
            <template #prefix>
              <UserOutlined :style="{ color: 'rgba(0,0,0,.25)' }" />
            </template>
          </AInput>
        </AFormItem>

        <AFormItem>
          <AInputPassword
            v-model:value="form.password"
            size="large"
            placeholder="密碼"
          >
            <template #prefix>
              <LockOutlined :style="{ color: 'rgba(0,0,0,.25)' }" />
            </template>
          </AInputPassword>
        </AFormItem>

        <AFormItem style="margin-top:24px">
          <AButton
            size="large"
            type="primary"
            htmlType="submit"
            class="w-full h-[40px]"
            :loading="form.processing"
            :disabled="form.processing"
          >登入</AButton>
        </AFormItem>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { UserOutlined, LockOutlined } from '@ant-design/icons-vue'

defineOptions({ layout: undefined })

const form = useForm({
  username: '',
  password: '',
})
</script>
