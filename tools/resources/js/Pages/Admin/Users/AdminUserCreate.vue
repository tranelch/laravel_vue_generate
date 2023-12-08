
<template>
    <AppLayout title="Create User">
        <UserEditForm :edit_user="edit_user" :post_url="baseUrl" :permissionBase="permissionBase" :secondaryNav="secondaryNav" :errors="errors" />
    </AppLayout>
</template>

<script>
import { ref, inject } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import UserEditForm from '@/Components/Users/UserEditForm.vue'

export default {
    components: {
        AppLayout,
        UsersEditForm,
    },

    props: {
        edit_user: {
            type: Object,
            default: () => ({}),
        },
        errors: {
            type: Object,
            required: true,
        },
    },

    setup () {
        const permissions = inject('permissions')
        const permissionBase = 'admin'
        const secondaryNav = ref([])
        const baseUrl = '/admin/users'

        return { permissions, permissionBase, secondaryNav, baseUrl }
    },
}
</script>
