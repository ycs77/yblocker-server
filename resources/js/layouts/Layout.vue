<template>
  <ALayout class="min-h-screen">
    <ALayoutHeader class="fixed inset-x-0 z-[1] w-full h-12">
      <div class="h-full flex justify-between items-center">
        <div class="h-full flex items-center text-white text-xl font-bold select-none">
          yBlocker
        </div>

        <div class="h-full gap-2">
          <ADropdown>
            <div class="h-full px-3 flex items-center hover:bg-[#252a3d] text-white transition-colors duration-300 cursor-pointer select-none">管理員</div>

            <template #overlay>
              <AMenu>
                <AMenuItem>
                  <Link href="/logout" method="post" as="button" class="flex items-center bg-transparent border-0 cursor-pointer">
                    <LogoutOutlined class="w-3 h-3 mr-2" />
                    <span class="text-sm">登出</span>
                  </Link>
                </AMenuItem>
              </AMenu>
            </template>
          </ADropdown>
        </div>
      </div>
    </ALayoutHeader>

    <ALayout has-sider class="mt-12">
      <ALayoutSider
        class="fixed top-12 bottom-0 z-[1] bg-white"
        style="box-shadow: 2px 0 8px 0 rgba(29,35,41,.05);"
        breakpoint="lg"
        collapsed-width="0"
      >
        <AMenu v-model:selectedKeys="selectedKeys" mode="inline">
          <AMenuItem v-for="item in sidebar" :key="item.href" @click="onClickMenuItem(item.href)">
            <template #icon>
              <component :is="item.icon" />
            </template>
            <span>{{ item.label }}</span>
          </AMenuItem>
        </AMenu>
      </ALayoutSider>

      <ALayout class="p-6 lg:ml-[200px]">
        <slot />
      </ALayout>
    </ALayout>
  </ALayout>
</template>

<script setup lang="ts">
import HeroiconsComputerDesktop from '~icons/heroicons/computer-desktop'
import HeroiconsDocumentText from '~icons/heroicons/document-text'
import { LogoutOutlined } from '@ant-design/icons-vue'

interface SidebarItem {
  icon: Component
  label: string
  href: string
  activeMatch?: RegExp
}

const sidebar = [
  {
    icon: HeroiconsComputerDesktop,
    label: '客戶端',
    href: '/users',
    activeMatch: /^\/users.*$/,
  },
  {
    icon: HeroiconsDocumentText,
    label: '黑名單',
    href: '/blacklist',
  },
  {
    icon: HeroiconsDocumentText,
    label: '後台隱藏名單',
    href: '/hiddenlist',
  },
] satisfies SidebarItem[] as SidebarItem[]

const matchedItem = sidebar.find(item => {
  if (item.activeMatch)
    return item.activeMatch.test(usePage().url)
  return item.href === usePage().url
})

const selectedKeys = ref([matchedItem?.href ?? sidebar[0].href])

function onClickMenuItem(url: string) {
  router.get(url)
}
</script>
