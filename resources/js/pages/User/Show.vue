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
        <span class="mt-1 text-gray-500 text-xs">上次連線：{{ user.connected_at }}</span>
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
      <ACard title="本週瀏覽網站圖表">
        <ChartBrowseDomains :labels="browseDomainsChart.labels" :data="browseDomainsChart.data" class="h-[300px]" />
      </ACard>

      <ACard title="瀏覽紀錄" class="!mt-6">
        <div class="mb-6 grid grid-cols-3 gap-6">
          <div class="flex">
            <label class="inline-flex justify-end items-center flex-[0_0_120px] max-w-[120px] mr-2">網域:</label>
            <div class="flex-1">
              <ASelect
                v-model:value="historyFilterForm.hostname"
                mode="multiple"
                label-in-value
                placeholder="搜尋網域..."
                :filter-option="false"
                :max-tag-count="1"
                :options="hostnameSelectState.data"
                @search="fetchHostname"
                class="w-full"
              >
                <template v-if="hostnameSelectState.fetching" #notFoundContent>
                  <div class="flex justify-center">
                    <ASpin size="small" />
                  </div>
                </template>
              </ASelect>
            </div>
          </div>
          <div class="flex">
            <label class="inline-flex justify-end items-center flex-[0_0_120px] max-w-[120px] mr-2">網址:</label>
            <div class="flex-1">
              <AInput v-model:value="historyFilterForm.url" class="w-full" />
            </div>
          </div>
          <div class="flex">
            <label class="inline-flex justify-end items-center flex-[0_0_120px] max-w-[120px] mr-2">瀏覽時間:</label>
            <div class="flex-1">
              <ARangePicker v-model:value="historyFilterForm.created_period" class="w-full" />
            </div>
          </div>
          <div></div>
          <div></div>
          <div class="space-x-4 text-right">
            <AButton @click="resetHistoryFilter">重設</AButton>
            <AButton type="primary" :loading="historyFilterForm.processing" @click="submitHistoryFilter">查詢</AButton>
          </div>
        </div>

        <ATable
          :columns="historiesColumns"
          :data-source="histories"
          :pagination="historiesPagination"
          :loading="historiesLoading"
          size="small"
          @change="handleHistoriesTableChange"
        >
          <template #bodyCell="{ column, record }">
            <template v-if="column.key === 'url'">
              <APopover title="完整網址">
                <template #content>
                  <div class="w-[320px] break-all">{{ record.url }}</div>
                </template>
                <span class="inline-block text-truncate max-w-[280px]">{{ record.url }}</span>
              </APopover>
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

        <div v-if="created_token" class="mb-6">
          <AAlert
            message="令牌已產生完成，請立即複製令牌代碼並妥善保管"
            type="success"
            show-icon
          >
            <template #description>
              <div>
                {{ created_token }}
                <div class="absolute top-6.5 right-4">
                  <button
                    class="!p-1 bg-transparent text-[#52c41a] border-0 border-transparent cursor-pointer"
                    @click="copy(created_token)"
                  >
                    <HeroiconsCheckCircle v-if="copied" class="w-5 h-5" />
                    <HeroiconsDocumentDuplicate v-else class="w-5 h-5" />
                  </button>
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
import { message } from 'ant-design-vue/es'
import axios from 'axios'
import dayjs, { type Dayjs } from 'dayjs'
import { debounce, pickBy } from 'lodash-es'
import type { Paginator } from '@/types/pagination'

const props = defineProps<{
  user: {
    id: number
    name: string
    connected_at: string
    connected: boolean
  }
  browseDomainsChart: {
    labels: string[]
    data: number[]
  }
  histories: Paginator<{
    id: number
    url: string
    hostname: string
    created_at: string
  }>
  historyFilters: {
    url: string[] | null
    hostname: string[] | null
    created_period: [string, string] | null
  }
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

const historyFilterForm = useForm({
  url: props.historyFilters.url,
  hostname: props.historyFilters.hostname
    ?.map(hostname => ({ value: hostname })) as Record<string, any>[],
  created_period: props.historyFilters.created_period
    ?.map(date => dayjs(date)) ?? null as [Dayjs, Dayjs] | null,
})

let lastHostnameFetchId = 0
const hostnameSelectState = reactive({
  data: [] as {
    label: string
    value: string
  }[],
  fetching: false,
})

const fetchHostname = debounce(value => {
  lastHostnameFetchId += 1
  const fetchId = lastHostnameFetchId
  hostnameSelectState.data = []
  hostnameSelectState.fetching = true

  axios.post(`/users/${props.user.id}/hostname`, { search: value })
    .then(res => {
      if (fetchId !== lastHostnameFetchId) return

      const data = res.data.results.map((hostname: string) => ({
        label: hostname,
        value: hostname,
      }))
      hostnameSelectState.data = data
      hostnameSelectState.fetching = false
    })
}, 300)

watch(() => historyFilterForm.hostname, () => {
  hostnameSelectState.data = []
  hostnameSelectState.fetching = false
})

function submitHistoryFilter() {
  const form = historyFilterForm.data()
  const data = {
    url: form.url,
    hostname: form.hostname.map(option => option.value),
    created_period: (form.created_period ?? []).map(date => date.format('YYYY-MM-DD')),
  }

  router.get(`/users/${props.user.id}`, pickBy(data, v => Array.isArray(v) ? v.length > 0 : v), {
    preserveScroll: true,
    only: ['histories', 'historyFilters']
  })
}

function resetHistoryFilter() {
  router.get(`/users/${props.user.id}`, {}, {
    preserveScroll: true,
    only: ['histories', 'historyFilters']
  })
}

const {
  collection: histories,
  pagination: historiesPagination,
  loading: historiesLoading,
  handleTableChange: handleHistoriesTableChange,
} = usePagination('histories', props.histories)

const historiesColumns = [
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
