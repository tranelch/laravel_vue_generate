<template>
<div v-if="show_user">
    <InfoModalLayout title="User" @closeModal="$emit('closeModal')">
		<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
			<div>
				<strong class="block">Name</strong>
				<span v-if="show_user.name" class="block">{{ show_user.name }}</span>
			</div>
			<!--<div>
				<strong class="block">Username</strong>
				<span v-if="show_user.username" class="block">{{ show_user.username }}</span>
			</div>-->
			<div>
				<strong class="block">Email</strong>
				<span v-if="show_user.email" class="block">{{ show_user.email }}</span>
			</div>
		</div>
		<hr class="my-3" />
		<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
			<div>
				<strong class="block">SaaS Subscription</strong>
				<span v-if="show_user.saas_subscription" class="block">{{ show_user.saas_subscription.name }}</span>
			</div>
			<div>
				<strong class="block">Carrier</strong>
				<span v-if="show_user.carrier" class="block">{{ show_user.carrier.carrier_name }}</span>
			</div>
		</div>
		<hr class="my-3" />
		<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
			<div>
				<strong class="block">User Groups</strong>
				<span v-if="show_user.acl_groups" class="block"><template v-for="(group, index) in show_user.acl_groups" :key="index">{{ group.name }} </template></span>
			</div>
			<div>
				<strong class="block">Timezone</strong>
				<span v-if="show_user.timezone" class="block">{{ show_user.timezone }}</span>
			</div>
		</div>
		<hr class="my-3" />
		<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
			<div>
				<strong class="block">Ip Address</strong>
				<span v-if="show_user.ip_address" class="block">{{ show_user.ip_address }}</span>
			</div>
			<div><Forms3PositionToggleInputDisplay :value="show_user.accepted_terms" label="Accepted Terms" /></div>
		</div>
    </InfoModalLayout>
</div>
<div v-else>
	No Information Found
</div>
</template>

<script>
import InfoModalLayout from '@/Components/Layout/InfoModalLayout.vue'
import Forms3PositionToggleInputDisplay from '@/Components/Shared/Forms/Forms3PositionToggleInputDisplay.vue'

export default {
    components: {
		InfoModalLayout,
		Forms3PositionToggleInputDisplay,
	},
    props: {
        show_user: {
            type: Object,
            default: () => ({}),
        },
        errors: {
            type: Object,
            default: () => ({}),
        }
    },
}
</script>