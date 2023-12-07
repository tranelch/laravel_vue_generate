<template>
  <ul class="list-none">
    <template v-for="item in desktopHeaderUtilsJson" :key="item.title">
      <li :class="[item.class, item.size, { 'empty' : !item.iconComponent }]" class="text-center inline-block ml-4">
        <Link :href="item.link" :name="item.title" class="flex flex-row">
          <div :class="[item.iconComponent ? 'inline-block' : 'empty']" class="img-wrap text-center">
            <template v-if="item.iconComponent">
              <component :is="item.iconComponent" location="desktop-header-util"></component>
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
    import DesktopHeaderUtilsData from '@/Data/DesktopHeaderUtilsData.json'
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
                desktopHeaderUtilsJson: DesktopHeaderUtilsData,
            }
        },
    })
</script>

<style scoped>
    @media print {
        .menu-container { display: none;}
    }
    @media (max-width: 767px) {
        div {display: none;}
    }
</style>
