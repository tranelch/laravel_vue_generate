
<template>
    <AppLayout title="Edit User">
        <UserEditForm :edit_user="edit_user" :timezones="timezones" :put_url="baseUrl + '/' + edit_user.id" :permissionBase="permissionBase" :secondaryNav="secondaryNav" :errors="errors" />
    </AppLayout>
</template>

<script>
import { ref, inject } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import UserEditForm from '@/Components/Users/UserEditForm.vue'

export default {
    components: {
        AppLayout,
        UserEditForm,
    },

    props: {
        edit_user: {
            type: Object,
            required: true,
        },
        timezones: {
            type: Object,
            required: true,
        },
        errors: {
            type: Object,
            required: true,
        },
    },

    setup (props) {
        const permissions = inject('permissions')
        const permissionBase = 'admin'
        const baseUrl = '/admin/users'// + props.edit_user.id
        const secondaryNav = ref([])

        const previousPage = () => {
            history.back();
        }

        return { permissions, permissionBase, secondaryNav, previousPage, baseUrl, }
    },
}
</script>