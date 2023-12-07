<template>
  <div class="mobile-wrapper">
  <div class="mobile-header">
    <ApplicationLogo class="logo" />

    <div class="header-utils">
      <InteractiveHamburgerIcon
        location="mobile-header"
        :menuOpen="menuOpen"
        class="toggle"
        @click="$emit('toggleMenuOpen')"
      />
    </div>
  </div>
  </div>
</template>

<script>
    import ApplicationLogo from '@/Components/ApplicationLogo.vue'
    import InteractiveHamburgerIcon from '@/Icons/InteractiveHamburgerIcon.vue'

    export default {
        components: {
            ApplicationLogo,
            InteractiveHamburgerIcon
        },
        props: {
            menuOpen: {
                type: Boolean,
                default: false,
            },
        },

        emits: ['toggleMenuOpen']
    }
</script>

<style scoped>
  .mobile-header .title {
    font-family: 'Montserrat', sans-serif;
    font-weight: 800;
    font-size: 24px;
    line-height: 24px;
  }

  .mobile-header  {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    border-width: 0px;
    position: fixed;
    background: white;
    width: 100%;
  }

  .mobile-header .logo {
    height: 25px;
    width: auto;
  }

  .mobile-header .toggle {
    height: 25px;
    width: 25px;
  }

  @media screen and (max-width: 767px) {
    .mobile-wrapper {
      height: 50px;
    }
    .mobile-header {
      border-color: rgba(243, 244, 246, 1);
      padding: 0px 15px;
      height: 50px;
      z-index: 9999;
    }

    .mobile-header .title {
      visibility: hidden;
    }
  }
  @media (min-width: 768px) {
    .mobile-header {
        visibility: hidden;
    }
  }
  @media print {
    .mobile-header { display: none;}
  }
</style>