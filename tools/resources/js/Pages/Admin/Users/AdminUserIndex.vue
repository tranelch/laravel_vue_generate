<template>
  <AppLayout title="Users" :localFlash="localFlash">
    <template #primaryHeaderUtil>
      <Link
        class="mobile-add-load"
        :href="baseUrl + '/create'"
      >
        Add User
      </Link>
    </template>
    <UsersList :users="users" :baseUrl="baseUrl" :sort_columns="sort_columns" :sort_orders="sort_orders" :filters="filters" :permissionBase="permissionBase" :managedGroups="managedGroups" :secondaryNav="secondaryNav" :errors="errors" @updateFlash="setFlash" />
  </AppLayout>
</template>
<script>
import { ref, inject } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3';
import UsersList from '@/Components/Users/UsersList'

export default {
    components: {
        AppLayout,
        Link,
        UsersList,
    },

    props: {
        users: {
            type: Object,
            default: () => ({}),
        },
        sort_columns: {
            type: Array,
            default: () => ([]),
        },
        sort_orders: {
            type: Array,
            default: () => ([]),
        },
        filters: {
            type: Object,
            default: () => ({}),
        },
        managedGroups: {
            type: Array,
            default: () => ([]),
        },
        errors: {
            type: Object,
            default: () => ({}),
        },
    },

    setup() {
        const permissions = inject('permissions')
        const permissionBase = 'admin'
        const baseUrl = '/admin/users'
        const secondaryNav = ref([])
        const localFlash = ref([])
        const setFlash = (value) => {
            localFlash.value.push(value)
        }

        return {
            permissions,
            permissionBase,
            secondaryNav,
            localFlash,
            setFlash,
            baseUrl,
        }
    }
};
</script>
