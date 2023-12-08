<template>
  <FormLayout :secondaryNav="secondaryNav">
    <form @submit.prevent="submitForm()">
      <input v-model="form.id" type="hidden" />
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-10">
        <TextInput id="name" v-model="form.name" name="name" label="Name (First and Last)" required="required" :error="errors.name" />
        <FormsSelectLazyOptions v-if="permissions.can('users.groups.assign')" id="groups" v-model="form.acl_groups" label="User Groups" multiple="multiple" displayField="name" lookup_url="/lookup/user/groups/options" :error="errors.groups" placeholder="Select your groups" />
        <TextInput id="email" v-model="form.email" name="email" label="Email" required="required" :error="errors.email" />
        <!--<TextInput v-model="form.profile_photo_path" id="profile_photo_path" name="profile_photo_path" label="Profile Photo Path" :error="errors.profile_photo_path" />-->
      </div>
      <!-- submit -->
      <button type="submit" :disabled="form.processing" class="button-input btn-red">Save</button>
    </form>
  </FormLayout>
</template>

<script>
import { inject } from 'vue'
import { useForm } from '@inertiajs/vue3'
import FormsSelectLazyOptions from '@/Components/Shared/Forms/FormsSelectLazyOptions.vue'
import FormsSelectInput from '@/Components/Shared/Forms/FormsSelectInput.vue'
import TextInput from '@/Components/Shared/Forms/TextInput.vue'
import FormLayout from '@/Components/Layout/FormLayout.vue'

export default {
    components: {
        FormsSelectLazyOptions,
        FormsSelectInput,
        TextInput,
        FormLayout,
    },

    props: {
        post_url: {
            type: String,
            default: null,
        },
        put_url: {
            type: String,
            default: null,
        },
        edit_user: {
            type: Object,
            required: true,
        },
        secondaryNav: {
            type: Object,
            default: () => ({}),
        },
        permissionBase: {
            type: String,
            default: null,
        },
        errors: {
            type: Object,
            default: () => ({}),
        }
    },
    setup (props) {
        const permissions = inject('permissions')

        const form = useForm({
			name: props.edit_user.name,
            acl_groups: props.edit_user.acl_groups ? props.edit_user.acl_groups.map(group => group.id) : [],
			email: props.edit_user.email,
			profile_photo_path: props.edit_user.profile_photo_path,
        })

        const submitForm = () => {
            var submission = form
                .transform((data) => ({
                    ...data,
                }))
            if(props.post_url) submission.post(props.post_url)
            if(props.put_url) submission.put(props.put_url)
        }

        return {
            permissions,
            form,
            submitForm,
        }
    },
}
</script>