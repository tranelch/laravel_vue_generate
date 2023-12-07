<template>
  <div :class="{ 'menu-open': menuOpen }" class="interactive-hamburger-button">
    <svg :id="'hamburgerActive' + location" class="svg system-icon hamburger" height="32px" style="enable-background:new 0 0 32 32;" viewBox="0 0 32 32" width="32px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
      <title>Menu</title>
      <path d="M4,10h24c1.104,0,2-0.896,2-2s-0.896-2-2-2H4C2.896,6,2,6.896,2,8S2.896,10,4,10z M28,14H4c-1.104,0-2,0.896-2,2  s0.896,2,2,2h24c1.104,0,2-0.896,2-2S29.104,14,28,14z M28,22H4c-1.104,0-2,0.896-2,2s0.896,2,2,2h24c1.104,0,2-0.896,2-2  S29.104,22,28,22z" fill="#666666" />
    </svg>
    <svg :id="'hamburgerInactive-' + location" class="svg arrow-right" width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
      <title>Click for Menu</title>
      <rect width="25" height="25" fill="#F6F8FA" />
      <path d="M8.94794 17.0208L13.7188 12.2396L8.94794 7.45834L10.4167 5.98959L16.6667 12.2396L10.4167 18.4896L8.94794 17.0208Z" fill="#C2C9D1" />
      <path d="M8.94794 17.0208L13.7188 12.2396L8.94794 7.45834L10.4167 5.98959L16.6667 12.2396L10.4167 18.4896L8.94794 17.0208Z" fill="black" fill-opacity="0.25" />
    </svg>
  </div>
</template>

<script>
    import { ref } from 'vue'

    export default {
        props: {
            menuOpen: {
                type: Boolean,
                default: false,
            },
            location: {
                type: String,
                required: true,
            }
        },

        setup (props) {
            const isMenuOpen = ref(props.menuOpen)

            return {
                isMenuOpen,
            }
        },
    }
</script>

<style scoped>
    div {
        position: relative;
        text-align: center;

        width: 25px;
        height: 25px;

        overflow: hidden;
    }

    svg {
        width: 25px;
        height: 25px;
    }

    .hamburger {
        width: 25px;
        height: 25px;
    }

    .arrow-right {
        /* transform: rotate(180deg); */
        display: none;
    }

    .menu-open .hamburger {
        display: none;
    }

    .menu-open .arrow-right {
        display: block;
    }
</style>
