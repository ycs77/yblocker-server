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

interface SidebarItem {
  icon: Component
  label: string
  href: string
  active?: () => boolean
}

const selectedKeys = ref(['/users'])

const sidebar = [
  {
    icon: HeroiconsComputerDesktop,
    label: '客戶端',
    href: '/users',
  },
] satisfies SidebarItem[] as SidebarItem[]

function onClickMenuItem(url: string) {
  router.get(url)
}
</script>
