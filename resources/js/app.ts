import { createApp, h } from 'vue'
import { createInertiaApp, Link } from '@inertiajs/vue3'
import AConfigProvider from 'ant-design-vue/es/config-provider'
import zhTW from 'ant-design-vue/es/locale/zh_TW'
import Layout from './layouts/Layout.vue'
import 'uno.css'
import 'ant-design-vue/es/message/style/index.css'
import '../css/app.css'

createInertiaApp({
  resolve: async name => {
    const pages = import.meta.glob('./pages/**/*.vue')
    const page = await pages[`./pages/${name}.vue`]() as any
    page.default.layout = Layout
    return page
  },
  setup({ el, App, props, plugin }) {
    createApp({
      render: () => h(AConfigProvider, {
        locale: zhTW,
      }, () => h(App, props)),
    })
      .use(plugin)
      .component('Link', Link)
      .mount(el)
  },
  progress: {
    color: '#fff',
  },
})
