import { createApp, h, type DefineComponent } from 'vue'
import { createInertiaApp, Link } from '@inertiajs/vue3'
import '../css/app.css'

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./pages/**/*.vue')
    return pages[`./pages/${name}.vue`]() as Promise<DefineComponent>
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .component('Link', Link)
      .mount(el)
  },
  progress: {
    color: '#fff',
  },
})
