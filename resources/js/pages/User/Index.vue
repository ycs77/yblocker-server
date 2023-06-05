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
        :data-source="users"
        class="mt-6"
      >
        <template #renderItem="{ item: user }">
          <AListItem>
            <AButton v-if="user.action === 'create'" type="dashed" class="!block w-full !h-[117px]">
              <HeroiconsPlus class="w-5 h-5" /> 新增客戶端
            </AButton>
            <ACard v-else>
              <div>
                <Link :href="`/users/${user.id}`">{{ user.name }}</Link>
              </div>
              <div class="mt-6">
                <ATag v-if="user.connected" color="green">連線中</ATag>
                <ATag v-else color="red">未連線</ATag>
                <span v-if="!user.connected" class="mt-1 text-gray-500 text-xs">上次連線：{{ user.connected_at }}</span>
              </div>
            </ACard>
          </AListItem>
        </template>
      </AList>
    </ALayoutContent>
  </div>
</template>

<script setup lang="ts">
defineProps<{
  users: {
    id: number
    name: string
    connected_at: string
    connected: boolean
  }[]
}>()

// const users = computed(() => {
//   return [{ action: 'create' }, ...props.users]
// })
</script>
