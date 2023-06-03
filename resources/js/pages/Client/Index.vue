<template>
  <div>
    <APageHeader
      title="客戶端"
      :ghost="false"
      class="!-mx-6 !-mt-6"
    />

    <ALayoutContent class="mt-6">
      <AList
        :grid="{ gutter: 16, column: 4 }"
        :data-source="[{ action: 'create' }, ...clients.data]"
        class="mt-6"
      >
        <template #renderItem="{ item }">
          <AListItem>
            <AButton v-if="item.action === 'create'" type="dashed" class="!block w-full !h-[117px]">
              <HeroiconsPlus class="w-5 h-5" /> 新增客戶端
            </AButton>
            <ACard v-else>
              <div>
                <Link href="/clients/1">{{ item.title }}</Link>
              </div>
              <div class="mt-6">
                <ATag v-if="item.connected" color="green">連線中</ATag>
                <ATag v-else color="red">未連線</ATag>
              </div>
            </ACard>
          </AListItem>
        </template>
      </AList>
    </ALayoutContent>
  </div>
</template>

<script setup lang="ts">
const clients = {
  data: [
    {
      id: 1,
      title: '紅色電腦',
      connected: true,
    },
    {
      id: 2,
      title: '藍色電腦',
      connected: false,
    },
  ],
}
</script>
