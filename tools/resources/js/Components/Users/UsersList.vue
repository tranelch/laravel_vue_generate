<template>
  <DataListingLayout v-model="form" :baseUrl="baseUrl" searchPlaceholder="Search by name, email, timezone and user group" :secondaryNav="secondaryNav" :pagination="paginationData" @update:modelValue="updateSearch(baseUrl, queryString)">
    <template #filters>
      <FilterSearchableOptions
        id="carrier-filter"
        v-model:searchquery="carrierSearchquery" v-model="form.carrier_id"
        label="Carrier" name="carrier" placeholder="Search by Carrier Name, City or Carrier Code" lookup_url="/api/user/carriers/search/{search}"
        :displayField="['label', 'carrier_name']" :error="errors.carrier_id"
        @updateFlash="$emit('updateFlash', $event)"
      />
      <FilterSearchableOptions
        id="saas-subscription-filter"
        v-model:searchquery="saasSubscriptionSearchquery" v-model="form.saas_subscription_id"
        label="Saas Subscription" name="saas_subscription" placeholder="Search by Name" lookup_url="/api/user/saas_subscriptions/search/{search}"
        displayField="name" :error="errors.saas_subscription_id"
        @updateFlash="$emit('updateFlash', $event)"
      />

      <!--<FormsSelectLazyOptions v-model="form.saas_subscription_id" label="SaaS Subscription" id="saas_subscription_id" displayField="name" lookup_url="/api/user/saas_subscriptions/options" :error="errors.saas_subscription_id" placeholder="Select SaaS Subscription" />-->

      <FilterSelectInput
        id="accepted_terms" v-model="form.accepted_terms" name="accepted_terms" label="Accepted Terms"
        :options="[{null: 'All'}, {yes: 'Yes'}, {no: 'No'}]"
      />
      <!--<FilterSelectInput v-model="form.acl_groups" name="acl_groups" id="acl_groups" label="Groups"
				:options="acl_group_options" />-->
      <FilterSelectInput
        id="active" v-model="form.trashed" name="trashed" label="Active"
        :options="[{null: 'Only Active'}, {with: 'Active &amp; Inactive'}, {only: 'Only Inactive'}]"
      />
    </template>
    <template #add-button>
      <Link v-if="permissions.can(permissionBase + '.users.create')" class="button-input btn-red add ml-4" :href="baseUrl + '/create'">Add User</Link>
    </template>

    <div v-if="sort_columns.length > 0" class="sort-description">
      Sorted by
      <template v-for="(column, index) in sort_columns" :key="index">{{ column }} ({{ sort_orders[index] }}); </template>
      <button class="text-primary" type="button" @click="sort.resetSort(baseUrl, getFilterQueryString(form))">Reset Sort</button>
    </div>

    <table>
      <thead>
        <tr>
          <th>Action</th>
          <th class="sortable" :class="sort.sortOrder('name')" @click="sort.addColumnToSort('name', baseUrl, getFilterQueryString(form))">Name</th>
          <th v-if="permissions.can('users.saas-subscriptions.assign')" class="sortable" :class="sort.sortOrder('saas_subscription.name')" @click="sort.addColumnToSort('saas_subscription.name', baseUrl, getFilterQueryString(form))">Subscription Account</th>
          <th v-if="permissions.can('users.carriers.assign')" class="sortable" :class="sort.sortOrder('carrier.carrier_name')" @click="sort.addColumnToSort('carrier.carrier_name', baseUrl, getFilterQueryString(form))">Carrier</th>
          <th class="sortable" :class="sort.sortOrder('acl_groups.name')" @click="sort.addColumnToSort('acl_groups.name', baseUrl, getFilterQueryString(form))">User Group</th>
          <th class="sortable" :class="sort.sortOrder('email')" @click="sort.addColumnToSort('email', baseUrl, getFilterQueryString(form))">Email</th>
          <th class="sortable" :class="sort.sortOrder('accepted_terms')" @click="sort.addColumnToSort('accepted_terms', baseUrl, getFilterQueryString(form))">Accepted Terms</th>
          <th class="sortable" :class="sort.sortOrder('timezone')" @click="sort.addColumnToSort('timezone', baseUrl, getFilterQueryString(form))">Timezone</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(user, index) in users.data" :key="index">
          <td class="actions">
            <GridButton v-if="permissions.can(permissionBase + '.users.view')" icon="eye" title="Show" @click="openModal(user)" />
            <GridButton v-if="permissions.can(permissionBase + '.users.edit')" icon="edit" title="Edit" :href="baseUrl + '/' + user.id + '/edit'" />
            <GridButton v-if="permissions.can(permissionBase + '.users.edit') && user.two_factor_allowed" icon="sync" title="Reset 2FA" @click="reset2fa(user.id)" />
            <GridButton v-if="permissions.can(permissionBase + '.users.edit')" icon="lock" title="Resend Password" @click="resendPassword(user.id, user.email)" />
            <GridButton v-if="canDeactivate(user)" icon="trash" title="Deactivate" @click="remove(baseUrl + '/' + user.id + '/remove', user.name)" />
            <GridButton v-if="canRestore(user)" icon="trash-restore" title="Restore" @click="restore(baseUrl + '/' + user.id + '/restore', user.name)" />
            <GridButton v-if="canImpersonate(user)" icon="user" title="Impersonate" :href="baseUrl + '/' + user.id + '/impersonate'" />
            <GridButton v-if="permissions.can(permissionBase + '.users.create') && !user.accepted_terms" icon="envelope" title="Resend Notification" @click="resendNotification(user)" />
          </td>
          <td>{{ user.name }}</td>
          <td v-if="permissions.can('users.saas-subscriptions.assign')"><template v-if="user.saas_subscription">{{ user.saas_subscription.name }}</template></td>
          <td v-if="permissions.can('users.carriers.assign')"><template v-if="user.carrier">{{ user.carrier.carrier_name }}</template></td>
          <td><template v-if="user.acl_groups"><div v-for="(group, index) in user.acl_groups" :key="index">{{ group.name }} </div></template></td>
          <td>{{ user.email }}</td>
          <td class="boolean"><Grids3PositionToggleDisplay :value="user.accepted_terms" /></td>
          <td>{{ user.timezone }}</td>
        </tr>
      </tbody>
    </table>

    <Modal v-if="modalUser.id" :show="showUserInfoModal" @close="showUserInfoModal = false">
      <UsersInfo :show_user="modalUser" @closeModal="showUserInfoModal = false" />
    </Modal>
  </DataListingLayout>
</template>

<script>
import { ref, inject, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import { Link } from '@inertiajs/vue3'
import NProgress from 'nprogress'
import UsersInfo from '@/Components/Users/UserInfo.vue'
import Modal from '@/Components/Shared/Modal.vue'
import DataListingLayout from '@/Components/Layout/DataListingLayout.vue'
import GridButton from '@/Components/Shared/Grid/GridButton.vue'
import FilterSelectInput from '@/Components/Shared/Forms/FilterSelectInput.vue'
import FilterSearchableOptions from '@/Components/Shared/Forms/FilterSearchableOptions.vue'
import Grids3PositionToggleDisplay from '@/Components/Shared/Grid/Grids3PositionToggleDisplay.vue'

import SoftDeletes from '@/Components/Shared/Grid/SoftDeletes.js'
import Sort from '@/Components/Shared/Grid/Sort.js'
import useQuerystring from '@/composables/useQuerystring.js'

export default {
    components: {
        UsersInfo,
        Modal,
        DataListingLayout,
        GridButton,
        FilterSelectInput,
        FilterSearchableOptions,
        Grids3PositionToggleDisplay,
        Link,
    },
    props: {
        users: {
            type: [Object, null],
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
            default: function () { return {search: null, trashed: null}},
        },
        permissionBase: {
            type: String,
            default: null,
        },
        baseUrl: {
            type: String,
            default: null,
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
    emits: ['updateFlash'],
    setup(props, {emit}) {
        const flash = (keyIn, value) => {
            emit('updateFlash', [keyIn, value])
        }

        const carrierSearchquery = ref('')
        const saasSubscriptionSearchquery = ref('')

        const modalUser = ref({})
        const showUserInfoModal = ref(false)
        const form = ref(props.filters)
        const permissions = inject("permissions");
        const secondaryNav = ref([])
        const {remove, restore} = SoftDeletes(emit)
        const {getQueryString, getFilterQueryString} = useQuerystring()
        const sort = Sort(emit)
        sort.setSort(props.sort_columns, props.sort_orders)

        const hasUsers = computed( () => {
            if (props.users && props.users.data.length > 0) return true
            return false
        })

        const paginationData = computed( () => {
            return {
                from: props.users.from,
                to: props.users.to,
                perPage: props.users.per_page,
                links: props.users.links,
                total: props.users.total,
            }
        })

        // Soft delete permissions
        const canDeactivate = (user) => {
            return permissions.can(props.permissionBase + '.users.remove') && user.deleted_at === null;
        }
        const canRestore = (user) => {
            return permissions.can(props.permissionBase + '.users.restore') && user.deleted_at !== null;
        }

        const updateSearch = () => {
            router.get(props.baseUrl, getQueryString(form.value, sort.getSortQuerystring()), { preserveState: true })
        }

        // Modal functions
        const openModal = (user) => {
            NProgress.start()

            axios
                .get(props.baseUrl + '/' + user.id + '/show')
                .then(response => {
                    modalUser.value = response.data.show_user
                    showUserInfoModal.value = true
                })
                .catch((err) => {
                    flash('error', 'Sorry, we could not load that user.  Please reload the page and try again.')
                })
                .finally(() => {
                    NProgress.done()
                })
        }

        const canImpersonate = (user) => {
            // filter unless the user to impersonate has a group that is not managed by the logged in user, or the user to impersonate is super admin
            var matches = user.acl_groups.filter(obj => { return !props.managedGroups.includes(obj.id) || obj.id === 1 })
            return matches.length === 0 && permissions.can(props.permissionBase + '.users.impersonate')
        }

        const impersonate = (user) => {
            NProgress.start()

            axios
                .get(props.baseUrl + '/' + user.id + '/impersonate')
                .then(response => {
                    router.reload()
                })
                .catch((err) => {
                    flash('error', 'Sorry, we could not impersonate that user.  Please reload the page and try again.')
                })
                .finally(() => {
                    NProgress.done()
                })
        }

        const resendNotification = (user) => {
            NProgress.start()

            axios
                .post(props.baseUrl + '/resend_notification', {user_id: user.id})
                .then(response => {
                    if(response.data.flash?.error) {
                        flash('error', response.data.flash.error)
                    }
                    else {
                        flash('success', 'Notification was resent')
                        router.reload()
                    }
                })
                .catch((err) => {
                    flash('error', 'Sorry, we could not resend the user notification.  Please reload the page and try again.')
                })
                .finally(() => {
                    NProgress.done()
                })
        }

        const resendPassword = (userId, userEmail) => {
            NProgress.start()

            axios
                .post(props.baseUrl + '/resend_password', {user_id: userId, email: userEmail})
                .then(response => {
                    if(response.data.flash?.error) {
                        flash('error', response.data.flash.error)
                    }
                    else {
                        flash('success', 'Reset password email was sent successfully')
                        router.reload()
                    }
                })
                .catch((err) => {
                    flash('error', 'Sorry, we could not resend the user password.  Please reload the page and try again.')
                })
                .finally(() => {
                    NProgress.done()
                })
        }

        const reset2fa = (userId) => {
            NProgress.start()

            axios
                .post(props.baseUrl + '/reset2fa', {user_id: userId})
                .then(response => {
                    if(response.data.flash?.error) {
                        flash('error', response.data.flash.error)
                    }
                    else {
                        flash('success', '2FA credentials were reset successfully')
                        router.reload()
                    }
                })
                .catch((err) => {
                    flash('error', 'Sorry, we could not reset 2FA credentials.  Please reload the page and try again.')
                })
                .finally(() => {
                    NProgress.done()
                })
        }


        return {
            modalUser, showUserInfoModal, openModal,
            sort, form, updateSearch, getFilterQueryString,
            secondaryNav, paginationData,
            permissions, hasUsers,
            canDeactivate, remove, canRestore, restore,
            impersonate, canImpersonate, resendNotification, resendPassword, reset2fa,
            saasSubscriptionSearchquery, carrierSearchquery,
        }
    }
};
</script>