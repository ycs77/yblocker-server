<template>
  <div>
    <APageHeader
      :title="user.name"
      :ghost="false"
      class="!-mx-6 !-mt-6"
    >
      <template #tags>
        <ATag v-if="user.connected" color="green">連線中</ATag>
        <ATag v-else color="red">未連線</ATag>
      </template>

      <template #breadcrumb>
        <ABreadcrumb :routes="breadcrumbs">
          <template #itemRender="{ route, paths }">
            <span v-if="breadcrumbs.indexOf(route) === breadcrumbs.length - 1">
              {{ route.breadcrumbName }}
            </span>
            <Link v-else :href="`/${paths.join('/')}`">
              {{ route.breadcrumbName }}
            </Link>
          </template>
        </ABreadcrumb>
      </template>
    </APageHeader>

    <ALayoutContent class="mt-6">
      <ACard>
        <div class="flex items-center pb-4">
          <div class="text-lg">瀏覽紀錄</div>
        </div>

        <ATable
          :columns="columns"
          :data-source="collection"
          :pagination="pagination"
          :loading="loading"
          @change="handleTableChange"
        >
          <template #bodyCell="{ column, record }">
            <template v-if="column.key === 'blocked'">
              <ATag v-if="record.blocked" color="red">封鎖</ATag>
              <ATag v-else color="green">通過</ATag>
            </template>
          </template>
        </ATable>
      </ACard>
    </ALayoutContent>
  </div>
</template>

<script setup lang="ts">
import type { Paginator } from '@/types/pagination'

const props = defineProps<{
  user: {
    id: number
    name: string
    connected: boolean
  }
  histories: Paginator<{
    id: number
    url: string
    hostname: string
    blocked: boolean
    created_at: string
  }>
}>()

const {
  collection,
  pagination,
  loading,
  handleTableChange,
} = usePagination('histories', props.histories)

const breadcrumbs = [
  {
    path: 'users',
    breadcrumbName: '客戶端',
  },
  {
    path: '1',
    breadcrumbName: '紅色電腦',
  },
]

const columns = [
  { title: '狀態', dataIndex: 'blocked', key: 'blocked' },
  { title: '網域', dataIndex: 'hostname', key: 'hostname' },
  { title: '網址', dataIndex: 'url', key: 'url' },
  { title: '瀏覽時間', dataIndex: 'created_at', key: 'created_at' },
]
</script>
