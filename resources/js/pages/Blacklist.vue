<template>
  <div>
    <APageHeader
      title="黑名單"
      :ghost="false"
      class="!-mx-6 !-mt-6"
    />

    <ALayoutContent class="mt-6">
      <ACard title="網址過濾設定">
        <p class="text-gray-400 text-sm">這裡可以自訂過濾規則，詳細使用方式可以參考<a href="https://adguard.com/kb/zh-CN/general/ad-filtering/create-own-filters/" target="_blank" rel="noreferrer noopener">過濾器規則導覽</a>。</p>

        <form class="mt-6" @submit.prevent="submit">
          <div>
            <ATextarea v-model:value="form.blacklist" class="font-mono" :rows="6" />
            <div v-if="form.errors.blacklist" class="mt-1 text-red text-sm">
              {{ form.errors.blacklist }}
            </div>
          </div>

          <div class="mt-6 flex justify-end">
            <AButton type="primary" html-type="submit">保存</AButton>
          </div>
        </form>
      </ACard>
    </ALayoutContent>
  </div>
</template>

<script setup lang="ts">
import { message } from 'ant-design-vue/es'

const props = defineProps<{
  blacklist: string
}>()

const form = useForm({
  blacklist: props.blacklist,
})

function submit() {
  form.post('/blacklist', {
    onSuccess: () => message.success('保存成功'),
  })
}
</script>
