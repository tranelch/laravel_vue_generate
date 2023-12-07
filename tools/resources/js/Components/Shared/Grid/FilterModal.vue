<template>
    <GridToolbarModal :maxWidth="maxWidth" :showModal="showModal" @openModal="showModal = true" @closeModal="showModal = false">
        <template #trigger>
            <i class="fas fa-filter text-xl mr-1 hover:cursor-pointer" v-bind="$attrs"></i>
        </template>
        <template #dropdown>
            <div class="mt-2 px-4 py-6 bg-white rounded shadow-xl list-filters">
                <slot />
            </div>
        </template>
    </GridToolbarModal>
</template>

<script>
import GridToolbarModal from '@/Components/Shared/Grid/GridToolbarModal.vue'
import TextInput from '@/Components/Shared/Forms/TextInput.vue'
import { ref } from 'vue'

export default {
    inheritAttrs: false,
    components: {
        TextInput,
        GridToolbarModal,
    },
    props: {
        modelValue: {
            type: Object,
        },
        maxWidth: {
            type: Number,
            default: 300,
        },

    },
    setup (props) {
        const showModal = ref(false)

        return {showModal}
    }
}
</script>

<style>
    .list-filters > div {padding: 1em 0; border-bottom: solid 1px #efefef;}
    .list-filters > div:last-child {border-bottom: none; padding-bottom: 0;}
    .list-filters > div:first-child {padding-top: 0;}
</style>