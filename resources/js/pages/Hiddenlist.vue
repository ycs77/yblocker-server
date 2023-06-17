<template>
  <div>
    <APageHeader
      title="後台隱藏名單"
      :ghost="false"
      class="!-mx-6 !-mt-6"
    />

    <ALayoutContent class="mt-6">
      <ACard title="後台隱藏網址設定">
        <form @submit.prevent="submit">
          <div>
            <ATextarea v-model:value="form.hiddenlist" class="font-mono" :rows="6" />
            <div v-if="form.errors.hiddenlist" class="mt-1 text-red text-sm">
              {{ form.errors.hiddenlist }}
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
  hiddenlist: string
}>()

const form = useForm({
  hiddenlist: props.hiddenlist,
})

function submit() {
  form.post('/hiddenlist', {
    onSuccess: () => message.success('保存成功'),
  })
}
</script>
