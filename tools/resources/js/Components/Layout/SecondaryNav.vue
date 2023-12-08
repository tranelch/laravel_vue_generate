<template>
  <div class="datalist-secondary-nav-wrap">
    <ul class="datalist-secondary-nav text-left">
      <template v-for="(link, index) in secondaryNav.links" :key="index">
        <li v-if="hasPermission(link.permissions)">
          <Link :href="link.href" :class="activeClass($page.url, link.href)">{{ link.label }}</Link>
        </li>
      </template>
    </ul>
  </div>
</template>

<script>
import { ref, inject } from 'vue'
import { router } from '@inertiajs/vue3'
import { Link } from '@inertiajs/vue3'

export default {
    components: {
        Link,
    },
    props: {
        secondaryNav: {
            type: Object,
            default: () => ({}),
        },
    },
    setup(props) {
        const permissions = inject("permissions");
        const hasPermission = (permission) => {
            if (typeof permission === 'undefined') return true
            return permission.length === 0 || permissions.can(permission)
        }
        const activeClass = (current, linkPath) => {
            let currentUrlSections = current.split('?');
            let linkUrlSections = linkPath.split('?');

            if (currentUrlSections[0].endsWith('/loads')) {
                let currentParams = Array.from(new URLSearchParams(currentUrlSections[1]).entries());
                let linkParams = Array.from(new URLSearchParams(linkUrlSections[1]).entries());
                let intersect = linkParams.filter(value => currentParams.some(function(v) {return JSON.stringify(value) == JSON.stringify(v);}))
                let linkOnly = linkParams.filter(value => !currentParams.some(function(v) {return JSON.stringify(value) == JSON.stringify(v);}))

                if (
                    currentUrlSections[0] === linkUrlSections[0] &&
                    intersect.length === linkParams.length &&
                    linkParams.length <= currentParams.length &&
                    linkOnly.length == 0
                ) {
                    const currentStatusParams = Array.from(new URLSearchParams(currentUrlSections[1] ?? '').getAll('status[]'));
                    const linkStatusParams = Array.from(new URLSearchParams(linkUrlSections[1] ?? '').getAll('status[]'));
                    let intersectStatus = currentStatusParams.filter(value => linkStatusParams.some(function(v) {return JSON.stringify(value) == JSON.stringify(v);}))
                    if (intersectStatus.length == currentStatusParams.length) {
                        return 'active'
                    }
                    // Return active if neither url has statuses, else empty string
                    return currentStatusParams.length === 0 && linkStatusParams.length === 0 ? 'active' : ''
                }

                return ''
            }
            if (currentUrlSections[0] == linkUrlSections[0]) {
                return 'active'
            }

            return ''
        }

        return { hasPermission, activeClass, }
    }
}
</script>

<style scoped>
    .datalist-secondary-nav {
        text-align: left;
    }

    .datalist-secondary-nav li {
        display: inline-block;
        margin-right: 30px;
    }

    .datalist-secondary-nav li a {
        font-family: 'Open Sans', sans-serif;
        font-weight: 500;
        font-size: 12px;
        line-height: 12px;
        border-bottom: 2px solid #FFFFFF;
    }

    .datalist-secondary-nav li a:hover,
    .datalist-secondary-nav li.active a,
    .datalist-secondary-nav li a.active {
        color: var(--primary);
        border-bottom-color: var(--primary);
    }


    @media (max-width: 767px) {
        .datalist-secondary-nav-wrap {
            overflow-x: scroll;
            margin-bottom: 5px;
            margin-right: -30px;
            padding: 5px 0px 5px 0px;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .datalist-secondary-nav-wrap::-webkit-scrollbar {
            display: none;
        }

        .datalist-secondary-nav {
            width: max-content;
            white-space: nowrap;
        }
    }
</style>