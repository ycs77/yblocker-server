import { fileURLToPath, URL } from 'node:url'
import { defineConfig } from 'vite'
import Laravel from 'laravel-vite-plugin'
import Vue from '@vitejs/plugin-vue'
import AutoImport from 'unplugin-auto-import/vite'
import Components from 'unplugin-vue-components/vite'
import { AntDesignVueResolver } from 'unplugin-vue-components/resolvers'
import DefineOptions from 'unplugin-vue-define-options/vite'
import Icons from 'unplugin-icons/vite'
import IconsResolver from 'unplugin-icons/resolver'
import Unocss from 'unocss/vite'

export default defineConfig(({ mode }) => ({
  plugins: [
    Laravel({
      input: 'resources/js/app.ts',
      refresh: true,
    }),
    Vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false,
        },
      },
    }),
    AutoImport({
      dirs: [
        'resources/js/composables',
      ],
      imports: [
        'vue',
        {
          '@inertiajs/vue3': ['router', 'useForm', 'usePage'],
        },
      ],
      dts: './resources/js/types/auto-imports.d.ts',
      vueTemplate: true,
    }),
    Components({
      resolvers: [
        AntDesignVueResolver(),
        IconsResolver({ prefix: '' }),
      ],
      dirs: [
        'resources/js/components',
        'resources/js/layouts',
      ],
      dts: './resources/js/types/components.d.ts',
    }),
    DefineOptions(),
    Icons(),
    Unocss(),
  ],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./resources/js', import.meta.url)),
    },
  },
}))
