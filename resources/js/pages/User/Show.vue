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
        <span v-if="!user.connected" class="mt-1 text-gray-500 text-xs">上次連線：{{ user.connected_at }}</span>
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
      <ACard title="瀏覽紀錄">
        <ATable
          :columns="historiesColumns"
          :data-source="histories"
          :pagination="historiesPagination"
          :loading="historiesLoading"
          @change="handleHistoriesTableChange"
        >
          <template #bodyCell="{ column, record: history }">
            <template v-if="column.key === 'blocked'">
              <ATag v-if="history.blocked" color="red">封鎖</ATag>
              <ATag v-else color="green">通過</ATag>
            </template>
          </template>
        </ATable>
      </ACard>

      <ACard title="令牌" class="!mt-6">
        <template #extra>
          <AButton type="primary" @click="generateToken">
            產生令牌
          </AButton>
        </template>

        <div class="mb-6">
          <AAlert
            v-if="created_token"
            message="令牌已產生完成，請立即複製令牌代碼並妥善保管"
            type="success"
            show-icon
          >
            <template #description>
              <div>
                {{ created_token }}
                <div class="absolute top-6.5 right-4">
                  <AButton type="link" class="!p-0" @click="copy(created_token)">
                    <HeroiconsCheckCircle v-if="copied" class="w-5 h-5" />
                    <HeroiconsDocumentDuplicate v-else class="w-5 h-5" />
                  </AButton>
                </div>
              </div>
            </template>
          </AAlert>
        </div>

        <ATable :columns="tokensColumns" :data-source="tokens">
          <template #bodyCell="{ column, record: token }">
            <template v-if="column.key === 'action'">
              <AButton type="link" class="!p-0" @click="revokeToken(token.id)">
                撤銷令牌
              </AButton>
            </template>
          </template>
        </ATable>
      </ACard>
    </ALayoutContent>
  </div>
</template>

<script setup lang="ts">
import type { Paginator } from '@/types/pagination'
import { message } from 'ant-design-vue/es'

const props = defineProps<{
  user: {
    id: number
    name: string
    connected_at: string
    connected: boolean
  }
  histories: Paginator<{
    id: number
    url: string
    hostname: string
    blocked: boolean
    created_at: string
  }>
  tokens: {
    id: number
    name: string
  }[]
  created_token: string | null
}>()

const breadcrumbs = [
  { path: 'users', breadcrumbName: '客戶端' },
  { path: props.user.id.toString(), breadcrumbName: props.user.name  },
]

const {
  collection: histories,
  pagination: historiesPagination,
  loading: historiesLoading,
  handleTableChange: handleHistoriesTableChange,
} = usePagination('histories', props.histories)

const historiesColumns = [
  { title: '狀態', dataIndex: 'blocked', key: 'blocked' },
  { title: '網域', dataIndex: 'hostname', key: 'hostname' },
  { title: '網址', dataIndex: 'url', key: 'url' },
  { title: '瀏覽時間', dataIndex: 'created_at', key: 'created_at' },
]

const tokensColumns = [
  { title: '名稱', dataIndex: 'name', key: 'name' },
  { title: '操作', key: 'action' },
]

const { copy, copied } = useClipboard()

function generateToken() {
  router.post(`/users/${props.user.id}/tokens`, {}, {
    preserveScroll: true,
    onSuccess() {
      message.success('令牌已產生')
    },
  })
}

function revokeToken(id: number) {
  if (confirm('確認要撤銷此令牌?')) {
    router.post(`/users/${props.user.id}/tokens/${id}`, {
      _method: 'delete',
    }, {
      preserveScroll: true,
      onSuccess() {
        message.success('令牌已撤銷')
      },
    })
  }
}
</script>
