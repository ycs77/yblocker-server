<template>
  <ALayout class="min-h-screen">
    <ALayoutHeader class="h-12">
      <div class="h-full flex items-center text-white text-xl font-bold select-none">
        yBlocker
      </div>
    </ALayoutHeader>

    <ALayout>
      <ALayoutSider class="bg-white">
        <AMenu v-model:selectedKeys="selectedKeys" mode="inline">
          <AMenuItem v-for="item in sidebar" :key="item.href" @click="onClickMenuItem(item.href)">
            <template #icon>
              <component :is="item.icon" />
            </template>
            <span>{{ item.label }}</span>
          </AMenuItem>
        </AMenu>
      </ALayoutSider>

      <ALayout class="p-6">
        <slot />
      </ALayout>
    </ALayout>
  </ALayout>
</template>

<script setup lang="ts">
import HeroiconsComputerDesktop from '~icons/heroicons/computer-desktop'
import HeroiconsDocumentText from '~icons/heroicons/document-text'

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
