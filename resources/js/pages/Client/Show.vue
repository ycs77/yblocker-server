<template>
  <div>
    <APageHeader
      title="紅色電腦"
      :ghost="false"
      class="!-mx-6 !-mt-6"
    >
      <template #tags>
        <ATag color="green">連線中</ATag>
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

        <ATable :columns="columns" :data-source="histories.data">
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
const breadcrumbs = [
  {
    path: 'clients',
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

const histories = {
  data: [
    {
      id: 1,
      url: 'https://laravel.com/',
      hostname: 'laravel.com',
      blocked: false,
      created_at: '2023/05/26 18:39',
    },
    {
      id: 2,
      url: 'https://www.youtube.com/',
      hostname: 'www.youtube.com',
      blocked: true,
      created_at: '2023/05/26 18:39',
    },
    {
      id: 3,
      url: 'https://translate.google.com.tw/',
      hostname: 'translate.google.com.tw',
      blocked: false,
      created_at: '2023/05/26 18:39',
    },
  ],
}
</script>
