<template>
  <ul class="mobile-menu-utils list-none">
    <template v-for="item in mobileMenuUtilsJson" :key="item.title">
      <li :class="[item.size, { 'empty' : !item.iconComponent }]" class="text-center inline-block">
        <Link :method="item.attributes.method" :as="item.attributes.as" :type="item.attributes.type" :href="item.link" :name="item.title" class="flex flex-row">
          <div :class="[item.iconComponent ? 'inline-block' : 'empty']" class="img-wrap text-center">
            <template v-if="item.iconComponent">
              <component :is="item.iconComponent" location="mobile-header-util"></component>
            </template>
          </div>
        </Link>
      </li>
    </template>
  </ul>
</template>

<script>
    import { defineComponent } from 'vue'
    import { Link } from '@inertiajs/vue3'
    import MainMenuData from '@/Data/MainMenuData.json'
    import MainMenuUtilsData from '@/Data/MainMenuUtilsData.json'
    import MobileMenuUtilsData from '@/Data/MobileMenuUtilsData.json'
    import ApplicationLogo from '@/Components/ApplicationLogo.vue'
    import HomeIcon from '@/Icons/HomeIcon.vue'
    import LogoutIcon from '@/Icons/LogoutIcon.vue'
    import NotificationsIcon from '@/Icons/NotificationsIcon.vue'
    import SettingsIcon from '@/Icons/SettingsIcon.vue'
    import AccountIcon from '@/Icons/AccountIcon.vue'
    import ArrowRight from '@/Icons/ArrowRight.vue'

    export default defineComponent({
        components: {
            Link,
            ApplicationLogo,
            HomeIcon,
            LogoutIcon,
            NotificationsIcon,
            SettingsIcon,
            AccountIcon,
            ArrowRight
        },

        data() {
            return {
                mainMenuJson: MainMenuData,
                mainMenuUtilsJson: MainMenuUtilsData,
                mobileMenuUtilsJson: MobileMenuUtilsData,
            }
        },
    })
</script>

<style scoped>
@media print {
    .mobile-menu-utils {display: none}
}
</style>