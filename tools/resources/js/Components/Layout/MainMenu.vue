<template>
  <div class="menu-container" :class="menuOpen ? 'menu-open' : ''">
    <div class="main-menu-container" :class="menuOpen ? 'menu-open' : ''">
      <div class="header">
        <ApplicationLogo class="logo" :linkToRoot="true" />
        <ArrowRight location="collapsed" class="toggle" @click="toggleMenuOpen" />
      </div>
      <ul class="main-menu p-6 block list-none">
        <li class="collapsed-toggle">
          <ArrowRight location="expanded" class="toggle" @click="toggleMenuOpen" />
        </li>
        <template v-for="item in mainMenuJson" :key="item.title">
          <li v-if="hasPermission(item) /*&& (!item.userCondition || $page.props.user[item.userCondition])*/"
            :class="[item.class, item.size, { 'empty': !item.iconComponent }]">
            <Link :method="item.attributes.method" :as="item.attributes.as" :type="item.attributes.type"
              :href="item.route" class="flex flex-row" :class="activeClass($page.url, item.route)">
            <div :class="[item.iconComponent ? 'inline-block' : 'empty']" class="img-wrap">
              <template v-if="item.iconComponent">
                <component :is="item.iconComponent" location="main-menu"></component>
              </template>
            </div>
            <span class="title pl-4">{{ item.title }}</span>
            </Link>
          </li>
        </template>
      </ul>
    </div>
  </div>
</template>

<script>
import { inject } from 'vue'
import { Link } from '@inertiajs/vue3'
import MainMenuData from '@/Data/MainMenuData.json'
import ApplicationLogo from '@/Components/ApplicationLogo.vue'
import HomeIcon from '@/Icons/HomeIcon.vue'
import LogoutIcon from '@/Icons/LogoutIcon.vue'
import NotificationsIcon from '@/Icons/NotificationsIcon.vue'
import SettingsIcon from '@/Icons/SettingsIcon.vue'
import ArrowRight from '@/Icons/ArrowRight.vue'

export default {
  components: {
    Link,
    ApplicationLogo,
    HomeIcon,
    LogoutIcon,
    NotificationsIcon,
    SettingsIcon,
    ArrowRight
  },

  props: {
    menuOpen: {
      type: Boolean,
      default: false,
    }
  },

  emits: ['toggleMenuOpen'],

  setup(props, { emit }) {
    const permissions = inject("permissions");
    const mainMenuJson = MainMenuData

    const activeClass = (current, linkPath) => {
      if (!current) return ''
      if (current == linkPath) return 'active'
      return current.startsWith(linkPath) && linkPath.length > 3 ? 'active' : ''
    }

    const hasPermission = (item) => {
      if (item.permissions.length === 0) return true
      if (item.permissions.includes('&&')) {
        let allConditions = item.permissions.split('&&').map(element => element.trim())
        let returnVal = true
        allConditions.forEach(perm => { if (!permissions.can(perm)) returnVal = false })
        return returnVal
      }
      if (item.permissions.includes('||')) {
        let anyCondition = item.permissions.split('||').map(element => element.trim())
        let returnVal = false
        anyCondition.forEach(perm => { if (permissions.can(perm)) returnVal = true })
        return returnVal
      }
      if (!Array.isArray(item.permissions)) return permissions.can(item.permissions)

      return false
    }

    const toggleMenuOpen = () => {
      //menuOpen.value = !menuOpen.value
      emit('toggleMenuOpen')
    }

    return {
      //menuOpen,
      toggleMenuOpen,
      permissions,
      mainMenuJson,
      activeClass,
      hasPermission,
    }
  },
}
</script>

<style scoped>
@media print {
  .menu-container {
    display: none;
  }
}
</style>