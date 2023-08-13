import axios from 'axios'
import { ref, type Ref } from 'vue'
import { usePage } from '@inertiajs/vue3'
import type { Paginator } from '@/types/pagination'

export function usePagination<T>(key: string) {
  const source = usePage().props[key] as Paginator<T>
  const collection = ref(source.data) as Ref<T[]>
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

      const source = props[key] as Paginator<T>
      collection.value = source.data
      paginationMeta.value = {
        current_page: source.current_page,
        per_page: source.per_page,
        total: source.total,
        first_page_url: source.first_page_url,
      }
    })
  }

  return { collection, pagination, loading, handleTableChange }
}
