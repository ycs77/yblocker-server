export interface Paginator<T> {
  data: T[]
  current_page: number
  per_page: number
  total: number
  first_page_url: string
}
