<?php
$vue_list_content = "<template>
  <DataListingLayout v-model=\"form\" :baseUrl=\"baseUrl\" searchPlaceholder=\"Search...\" importTemplateFile=\"LF_" . $text['camel']['singular'] . "_import_template.xlsx\" :secondaryNav=\"secondaryNav\" :pagination=\"paginationData\" @update:modelValue=\"updateSearch(baseUrl, queryString)\">
    <template v-slot:filters>$vue_report_filter
      <FilterSelectInput v-model=\"form.trashed\" name=\"trashed\" id=\"active\" label=\"Active\"
        :options=\"[{null: 'Only Active'}, {with: 'Active &amp; Inactive'}, {only: 'Only Inactive'}]\" />
    </template>
    <template v-slot:add-button>
      <Link v-if=\"permissions.can(permissionBase + '." . $text['camel']['plural'] . ".create')\" class=\"button-input btn-dark add ml-4\" :href=\"baseUrl + '/create'\">Add " . $text['spacedUpper']['singular'] . "</Link>
    </template>

    <div v-if=\"sort_columns.length > 0\" class=\"sort-description\">
      Sorted by
      <template v-for=\"(column, index) in sort_columns\" :key=\"index\">{{column}} ({{sort_orders[index]}}); </template>
      <button class=\"text-primary\" type=\"button\" @click=\"sort.resetSort(baseUrl, getFilterQueryString(form))\">Reset Sort</button>
    </div>

    <table>
      <thead>
        <tr>
          <th>Action</th>
$vue_report_header        </tr>
      </thead>
      <tbody>
        <tr v-for=\"(" . $text['camel']['singular'] . ", index) in " . $text['camel']['plural'] . ".data\" :key=\"index\">
$vue_report_line
        </tr>
      </tbody>
    </table>

    <Modal v-if=\"modal" . $text['camelUpper']['singular'] . ".id\" :show=\"show" . $text['camelUpper']['singular'] . "InfoModal\" @close=\"show" . $text['camelUpper']['singular'] . "InfoModal = false\">
      <" . $text['camelUpper']['singular'] . "Info :" . $text['camel']['singular'] . "=\"modal" . $text['camelUpper']['singular'] . "\" @closeModal=\"show" . $text['camelUpper']['singular'] . "InfoModal = false\" />
    </Modal>
  </DataListingLayout>
</template>

<script>
import { ref, inject, computed } from 'vue'
import { Inertia } from '@inertiajs/vue3'
import { Link } from '@inertiajs/vue3'
import NProgress from 'nprogress'
import " . $text['camelUpper']['singular'] . "Info from '@/Components/" . $text['camelUpper']['plural'] . "/" . $text['camelUpper']['singular'] . "Info.vue'
import Modal from '@/Components/Shared/Modal.vue'
import DataListingLayout from '@/Components/Layout/DataListingLayout.vue'
import GridButton from '@/Components/Shared/Grid/GridButton.vue'
import FilterSelectInput from '@/Components/Shared/Forms/FilterSelectInput.vue'

import SoftDeletes from '@/Components/Shared/Grid/SoftDeletes.js'
import Sort from '@/Components/Shared/Grid/Sort.js'
import useQuerystring from '@/composables/useQuerystring.js'

export default {
  components: {
    " . $text['camelUpper']['singular'] . "Info,
    Modal,
    DataListingLayout,
    GridButton,
    FilterSelectInput,
    Link,
  },
  emits: ['updateFlash'],
  props: {
    " . $text['camel']['plural'] . ": {
      type: Object,
      default: () => ({}),
    },
    sort_columns: {
      type: Array,
      required: false,
      default: () => ([]),
    },
    sort_orders: {
      type: Array,
      default: () => ([]),
    },
    filters: {
      type: Object,
      default: () => ({search: null, trashed: null}),
    },
    permissionBase: {
      type: String,
      required: true,
    },
    baseUrl: {
      type: String,
      default: null,
    },
    errors: {
      type: Object,
      default: () => ({}),
    },
  },
  setup(props, {emit}) {
    const flash = (keyIn, value) => {
      emit('updateFlash', [keyIn, value])
    }

    const modal" . $text['camelUpper']['singular'] . " = ref({})
    const show" . $text['camelUpper']['singular'] . "InfoModal = ref(false)
    const form = ref(props.filters)
    const permissions = inject(\"permissions\");
    const secondaryNav = ref({
      links: [
        {href: props.baseUrl + '/edit', label: 'Profile'},
      ]
    })
    const {remove, restore} = SoftDeletes(emit)
    const {getQueryString, getFilterQueryString} = useQuerystring()
    const sort = Sort(emit)
    sort.setSort(props.sort_columns, props.sort_orders)
    const has" . $text['camelUpper']['plural'] . " = computed( () => {
      if (props." . $text['camel']['plural'] . " && props." . $text['camel']['plural'] . ".data.length > 0) return true
      return false
    })

    const paginationData = computed( () => {
      return {
        from: props." . $text['camel']['plural'] . ".from,
        to: props." . $text['camel']['plural'] . ".to,
        perPage: props." . $text['camel']['plural'] . ".per_page,
        links: props." . $text['camel']['plural'] . ".links,
        total: props." . $text['camel']['plural'] . ".total,
      }
    })

    // Soft delete permissions
    const canDeactivate = (" . $text['camel']['singular'] . ") => {
      return permissions.can(props.permissionBase + '." . $text['camel']['plural'] . ".remove') && " . $text['camel']['singular'] . ".deleted_at === null;
    }
    const canRestore = (" . $text['camel']['singular'] . ") => {
      return permissions.can(props.permissionBase + '." . $text['camel']['plural'] . ".restore') && " . $text['camel']['singular'] . ".deleted_at !== null;
    }

    const updateSearch = () => {
      Inertia.get(props.baseUrl, getQueryString(form.value, sort.getSortQuerystring()), { preserveState: true })
    }

    // Modal functions
    const openModal = (" . $text['camel']['singular'] . ") => {
      NProgress.start()

      axios
        .get(props.baseUrl + '/' + " . $text['camel']['singular'] . ".id + '/show')
        .then(response => {
          modal" . $text['camelUpper']['singular'] . ".value = response.data." . $text['camel']['singular'] . "
          show" . $text['camelUpper']['singular'] . "InfoModal.value = true
        })
        .catch((err) => {
          flash('error', 'Sorry, we could not load that " . $text['camel']['singular'] . ".  Please reload the page and try again.')
        })
        .finally(() => {
          NProgress.done()
        })
    }

    return {
      modal" . $text['camelUpper']['singular'] . ", show" . $text['camelUpper']['singular'] . "InfoModal, openModal,
      sort, form, updateSearch, getFilterQueryString,
      secondaryNav, paginationData,
      permissions, has" . $text['camelUpper']['plural'] . ",
      canDeactivate, remove, canRestore, restore,
    }
  }
};
</script>";

if (!is_dir('generated/resources/js/Components/' . $text['camelUpper']['plural'])) {
    mkdir('generated/resources/js/Components/' . $text['camelUpper']['plural'], 0777, true);
}
$file = fopen('generated/resources/js/Components/' . $text['camelUpper']['plural'] . "/" . $text['camelUpper']['plural'] . 'List.vue', "w");
fputs($file, $vue_list_content);
fclose($file);


/*** VUE INDEX PAGE **************************************************************/
$index_content = "<template>
  <AppLayout title=\"" . $text['spacedUpper']['plural'] . "\" :localFlash=\"localFlash\">
    <template #primaryHeaderUtil>
      <Link
        id=\"add-" . $text['kabob']['singular'] . "\"
        class=\"add-record\"
        :href=\"baseUrl + '/create'\">
          Add " . $text['camelUpper']['singular'] . "
      </Link>
    </template>
    <" . $text['camelUpper']['plural'] . "List @updateFlash=\"setFlash\" :" . $text['camel']['plural'] . "=\"" . $text['camel']['plural'] . "\" :baseUrl=\"baseUrl\" :sort_columns=\"sort_columns\" :sort_orders=\"sort_orders\" :filters=\"filters\" :permissionBase=\"permissionBase\" :secondaryNav=\"secondaryNav\" :errors=\"errors\" />
  </AppLayout>
</template>
<script>
import { ref, inject } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3';
import " . $text['camelUpper']['plural'] . "List from '@/Components/" . $text['camelUpper']['plural'] . "/" . $text['camelUpper']['plural'] . "List.vue'

export default {
  components: {
    AppLayout,
    Link,
    " . $text['camelUpper']['plural'] . "List,
  },

  props: {
    " . $text['camel']['plural'] . ": {
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
    errors: {
      type: Object,
      default: () => ({}),
    },
  },

  setup() {
    const permissions = inject('permissions')
    const permissionBase = '{SECTION-camelSingular}'
    const baseUrl = '/{SECTION-kabob}/" . $text['kabob']['plural'] . "'
    const secondaryNav = ref({
      links: [
        {href: baseUrl + '/edit', label: 'Profile'},
      ]
    })
    const localFlash = ref([])
    const setFlash = (value) => {
      localFlash.value.push(value)
    }

    return {
      permissions, permissionBase, secondaryNav, baseUrl,
      localFlash, setFlash,
    }
  }
}
</script>
";

if (!is_dir('generated/resources/js/Pages/' . $text['camelUpper']['plural'])) {
    mkdir('generated/resources/js/Pages/' . $text['camelUpper']['plural'], 0777, true);
}
$file = fopen('generated/resources/js/Pages/' . $text['camelUpper']['plural'] . "/" . $text['camelUpper']['singular'] . 'Index.vue', "w");
fputs($file, $index_content);
fclose($file);
