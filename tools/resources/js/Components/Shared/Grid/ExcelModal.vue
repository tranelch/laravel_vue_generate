<template>
  <GridToolbarModal :maxWidth="300" :showModal="showModal" @openModal="showModal = true" @closeModal="showModal = false">
    <template v-if="showModal">true</template>
    <template #trigger>
      <button type="button" class="button-input btn-grey" v-bind="$attrs">
        <i class="fas fa-file-excel text-xl mr-1" style="color: #046307" />&nbsp; Import/Export
      </button>
    </template>
    <template #dropdown>
      <div class="mt-2 px-4 py-6 w-screen bg-white rounded shadow-xl">
        <h2 class="mb-4 border-b-4">Excel Import/Export</h2>
        <form @submit.prevent="submit">
          <h3 v-if="importTemplateFile">Export Results</h3>
          <div class="my-2"><a href="#" @click="exportExcel()">Export</a></div>
          <template v-if="importTemplateFile">
            <h3>Import File</h3>(<a :href="'/import_templates/' + importTemplateFile" @click="showModal=false">Import Template</a>)
            <input type="file" name="file-import" class="block my-2" required @input="form.fileImport = $event.target.files[0]" />
            <progress v-if="form.progress" :value="form.progress.percentage" max="100" class="block my-2">
              {{ form.progress.percentage }}%
            </progress>
            <button type="submit" class="block btn-red my-2">Submit</button>
          </template>
        </form>
      </div>
    </template>
  </GridToolbarModal>
</template>

<script>
import { ref } from 'vue'
import { useForm, Link } from '@inertiajs/vue3'
import GridToolbarModal from '@/Components/Shared/Grid/GridToolbarModal.vue'

export default {
    components: {
        Link,
        GridToolbarModal,
    },
    inheritAttrs: false,
    props: {
        baseUrl: {
            type: String,
            required: true,
        },
        importTemplateFile: {
            type: String,
            default: null,
        }
    },

    setup (props) {
        const showModal = ref(false)
        const form = useForm({
            fileImport: null,
        })

        function submit() {
            var importUrl = props.baseUrl+'/import'
            form.post(importUrl, {onFinish: () => showModal.value = false})
        }

        const exportExcel = () => {
            var url = props.baseUrl + '/export' + window.location.search
            window.location = url
            showModal.value = false
        }

        return { showModal, form, submit, exportExcel }
    },
}
</script>