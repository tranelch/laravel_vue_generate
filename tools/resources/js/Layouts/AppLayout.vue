<template>
  <Head :title="title" />
  <div v-if="$page.props.impersonate" style="height: 36px;">
    <div class="fixed text-sm bg-yellow-100 text-center p-2 z-[51] border-b impersonate">
      You are impersonating {{ $page.props.user.name }}.  <a href="/users/leave-impersonate" title="Stop Impersonation">End impersonation</a>
    </div>
  </div>

  <!-- Mobile Header -->
  <MobileHeader
    :menuOpen="menuOpen"
    :title="title"
    @toggleMenuOpen="toggleMenuOpen"
  />

  <ScheduledMessages :class="menuOpen ? 'menu-open' : ''" :scheduledMessages="$page.props.scheduledMessages" />

  <div id="app-main">
    <div class="print-header hidden"><a class="logo" href="/"><img class="logo" src="/i/logo.png" alt="Logo" width="141" height="55"></a></div>

    <!-- Menu Container -->
    <MainMenu :menuOpen="menuOpen" @toggleMenuOpen="toggleMenuOpen" />
    <MobileMenuUtils />

    <!-- Content Container -->
    <div class="content-container" :class="menuOpen ? 'menu-open' : ''">

      <!-- Primary Header -->
      <div class="primary-header">
        <h1 v-if="title" class="title">
          {{ title }}
        </h1>

        <div class="flex flex-row desktop-header-utils-container">
          <DesktopHeaderUtils class="desktop-header-utils" />

          <div v-if="$slots.primaryHeaderUtil" class="primary-header-util">
            <!-- Primary Header Util -->
            <slot name="primaryHeaderUtil"></slot>
          </div>
        </div>
      </div>

      <FlashMessages :localFlash="localFlash" :pageFlash="$page.props.flash" />

      <!-- Content -->
      <main>
        <slot></slot>
      </main>
    </div>
  </div>
</template>

<script>
    import { ref, onBeforeMount, onBeforeUnmount, } from 'vue'
    import { router } from '@inertiajs/vue3'
    import { Head } from '@inertiajs/vue3'
    import MainMenu from '@/Components/Layout/MainMenu.vue'
    import MobileHeader from '@/Components/Layout/MobileHeader.vue'
    import DesktopHeaderUtils from '@/Components/Layout/DesktopHeaderUtils.vue'
    import FlashMessages from '@/Components/Shared/FlashMessages.vue'
    import ScheduledMessages from '@/Components/Shared/ScheduledMessages.vue'
    import MobileMenuUtils from '@/Components/Layout/MobileMenuUtils.vue'

    export default {

        components: {
            Head,
            MainMenu,
            MobileHeader,
            DesktopHeaderUtils,
            MobileMenuUtils,
            FlashMessages,
            ScheduledMessages,
        },
        props: {
            title: {
                type: String,
                default: null,
            },
            localFlash: {
                type: Array,
                default: () => ([]),
            },
        },

        setup () {
            const menuOpen = ref(false)

            const logout = () => {
                router.post('/logout');
            }
            const toggleMenuOpen = () => {
                menuOpen.value = !menuOpen.value;
            }

            onBeforeMount( () => {
                let expanded = router.restore('menu-expanded')
                menuOpen.value = (window.innerWidth >= 768) ? expanded ?? true : false;
            })

            onBeforeUnmount(() => {
                router.remember(menuOpen.value, 'menu-expanded')
            })

            return {
                menuOpen,
                logout,
                toggleMenuOpen,
            }
        }
    }
</script>

<style scoped>
  .impersonate {width: 100vw;}

  @media print {
      .desktop-header-utils-container, .primary-header-util { display: none;}
      .print-header { display: block; padding: 20px;}
  }
  @media (max-width: 767px) {
      .impersonate {width: 100%; }
  }
</style>
