import axios from 'axios'
import type { Paginator } from '@/types/pagination'

export function usePagination<T>(
  key: string,
  source: Paginator<T>
) {
  const collection = ref(source.data)

  const paginationMeta = ref({
    current_page: source.current_page,
    per_page: source.per_page,
    total: source.total,
    first_page_url: source.first_page_url,
  })

  const pagination = computed(() => ({
    total: paginationMeta.value.total,
    current: paginationMeta.value.current_page,
    pageSize: paginationMeta.value.per_page,
  }))

  const loading = ref(false)

  const handleTableChange = (pagination: any) => {
    const url = paginationMeta.value.first_page_url.replace('page=1', `page=${pagination.current}`)

    loading.value = true

    axios.get(url, {
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'X-Inertia': true,
        'X-Inertia-Version': usePage().version,
        'X-Inertia-Partial-Component': usePage().component,
        'X-Inertia-Partial-Data': key,
      },
    }).then(({ data: { props } }) => {
      loading.value = false

      collection.value = props[key].data
      paginationMeta.value = {
        current_page: props[key].current_page,
        per_page: props[key].per_page,
        total: props[key].total,
        first_page_url: props[key].first_page_url,
      }
    })
  }

  return { collection, pagination, loading, handleTableChange }
}
