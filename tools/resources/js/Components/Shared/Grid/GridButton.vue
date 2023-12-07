<template>
    <a v-if="$attrs.role === 'download'" class="btn-grid" v-bind="$attrs">
        <span v-if="!icon">{{title}}</span>
        <span class="sr-only">{{title}}</span>
        <i v-if="icon" :class="icon_family + ' fa-' + icon" aria-hidden="true"  />
    </a>
    <button type="button" v-if="!$attrs.href" class="btn-grid" v-bind="$attrs">
        <span v-if="!icon">{{title}}</span>
        <span class="sr-only">{{title}}</span>
        <i v-if="icon" :class="icon_family + ' fa-' + icon" aria-hidden="true"  />
    </button>
    <Link v-if="$attrs.href && $attrs.role !== 'download'" class="btn-grid" v-bind="$attrs">
        <span v-if="!icon">{{title}}</span>
        <span class="sr-only">{{title}}</span>
        <i v-if="icon" :class="icon_family + ' fa-' + icon" aria-hidden="true"  />
    </Link>
</template>

<script>
import { Link } from '@inertiajs/vue3'

export default {
    //root element could be "a" or "link" elements, need to manually add attrs to both
    inheritAttrs: false,
    components: {
        Link,
    },
    props: {
        icon: {
            type: String,
        },
        icon_family: {
            type: String,
            default: 'fa',
        },
        title: {
            type: String,
        },
    },
}
</script>

<style scoped>
    .btn-grid {
        color: var(--primary);
        margin: 0 .8em;
        padding: .5em .7em;
    }
    .sr-only {
        display: inline-block;
        clip: auto;
        top: -15px;
        left: -10px;
        display: inline-block;
        position: relative;
        font-weight: normal;
        opacity: .6;
    }
    a:hover .sr-only, button:hover .sr-only {
        overflow: visible;
    }
</style>