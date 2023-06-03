export interface Paginator<T> {
  data: T[]
  current_page: number
  per_page: number
  total: number
  prev_page_url: string
  next_page_url: string
}
