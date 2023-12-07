
<template>
  <slot name="add-button-mobile" />

  <div class="secondary-header">
    <SecondaryNav v-if="secondaryNav?.links?.length > 0" :secondaryNav="secondaryNav" class="mb-8" />
    <div class="datalist-header">
      <div v-if="$slots.filters || !hideSearch">
        <div v-if="$slots.filters" class="inline-block">
          <FilterModal v-model="form" :maxWidth="maxWidth" class="ml-4">
            <slot name="filters" />
          </FilterModal>
        </div>
        <form v-if="!hideSearch" class="datalist-search inline-block">
          <div class="search-input-wrap">
            <input v-model="form.search" class="search-input" type="text" name="search" :placeholder="searchPlaceholder">
          </div>
        </form>
        <button class="text-primary" type="button" @click="reset()">Reset Search &amp; Filter</button>
      </div>
    </div>
  </div>

  <div class="datalist-wrap">
    <div class="datalist-utils">
      <div class="flex flex-row">
        <div v-if="bulkActions?.length > 0" class="datalist-bulk-actions">
          <form class="bulk-action-form">
            <template v-if="bulkActions?.length > 1">
              <select v-model="selectedAction" name="bulkAction" class="select-input">
                <option disabled :value="null">Select Action</option>
                <option v-for="(action, index) in bulkActions" :key="index" :value="index">{{ action.label }}</option>
              </select>

              <button type="button" class="button-input btn-red" @click="$emit('bulkAction', bulkActions[selectedAction]?.action, [])">Apply</button>
            </template>
            <template v-else>
              <button type="button" class="button-input btn-red" :value="bulkActions[0].action" @click="$emit('bulkAction', bulkActions[0]?.action, [])">{{ bulkActions[0].label }}</button>
            </template>

          </form>
        </div>

        <div v-if="$slots.premiumFilters" class="datalist-filters">
          <slot name="premiumFilters" />
        </div>
      </div>
      <div v-if="!hideExport || $slots['add-button']" class="datalist-actions">
        <div v-if="!hideExport" class="inline-block">
          <ExcelModal :baseUrl="baseUrl" :importTemplateFile="importTemplateFile" class="ml-4" />
        </div>
        <div class="inline-block">
          <slot name="add-button" />
        </div>
      </div>
    </div>
    <div class="datalist">
      <slot />

      <Pagination
        :from="pagination.from"
        :to="pagination.to"
        :perPage="pagination.per_page"
        :links="pagination.links"
        :total="pagination.total"
        @rowsPerPageChange="changeRowsPerPage"
      />
    </div>
  </div>
</template>

<script>
import { ref, watch, onMounted, onUnmounted } from 'vue'
import { router } from '@inertiajs/vue3'
import FilterModal from '@/Components/Shared/Grid/FilterModal.vue'
import ExcelModal from '@/Components/Shared/Grid/ExcelModal.vue'
import SecondaryNav from '@/Components/Layout/SecondaryNav.vue'
import debounce from 'lodash.debounce'
import Pagination from '@/Components/Shared/Pagination.vue'

export default {
    components: {
        SecondaryNav,
        FilterModal,
        ExcelModal,
        Pagination,
    },

    props: {
        modelValue: {
            type: Object,
            default: function () { return {search: null}},
        },
        baseUrl: {
            type: String,
            default: null,
        },
        maxWidth: {
            type: Number,
            default: 400,
        },
        importTemplateFile: {
            type: String,
            default: null,
        },
        secondaryNav: {
            type: Object,
            default: () => ({}),
        },
        bulkActions: {
            type: Array,
            default: () => ([]),
        },
        pagination: {
            type: Object,
            default: () => ({}),
        },
        searchPlaceholder: {
            type: String,
            default: 'Search...',
        },
        hideExport: {
            type: Boolean,
            default: false,
        },
        hideSearch: {
            type: Boolean,
            default: false,
        },
    },

    emits: ['update:modelValue', 'bulkAction'],

    setup(props, {emit}) {
        const form = ref(props.modelValue)
        const selectedAction = null

        const reset = () => {
            Object.fromEntries(
                Object.entries(form.value).map(([key, value]) => {form.value[key] = typeof value === 'object' ? [] : ''; return [key, typeof value === 'object' ? [] : '']})
            )
        }

        watch(form.value, debounce((newValue) => {
            emit('update:modelValue', form.value)
        }, 500))

        // Pagination
        const changeRowsPerPage = (val) => {
            router.reload({data: {per_page: val}});
        }

        //Reload if returning from another page (most likely load edit) via history.back()
        onMounted(() => {
            window.addEventListener('popstate', () => {
                router.reload()
            }, {once: true})
        })
        onUnmounted(() => {
            window.removeEventListener('popstate', () => {
                router.reload()
            })
        })

        return { form, reset, changeRowsPerPage, selectedAction,}
    }
}
</script>

<style scoped>
    .search-input-wrap {
        display: inline-block;
        position: relative;
    }
    .search-input-wrap:before {
        position: absolute;
        content: url(/i/icons/search.svg);
        height: 100%;
        width: 18px;
        font-size: 18px;
        line-height: 100%;
        z-index: 1;
        display: flex;
        top: 0px;
        bottom: 0px;
        left: 10px;
        align-items: center;
        justify-items: center;
        align-content: center;
        justify-content: center;
    }
    .search-input {
        border: none;
        outline: none;
        background: #EEEEEE;
        border-radius: 30px;
        position: relative;
        padding-left: 35px;
        min-width: 245px;
        font-size: 0.75rem;
    }

    .datalist-header {
        width: 100%;
        display: flex;
        flex-direction: row;
        align-items: right;
        justify-content: flex-end;
    }

    .datalist-header .search-input {
        min-width: 350px;
    }

    .datalist-wrap {
        border: 1px solid #EEEEEE;
        border-radius: 15px;
        padding: 10px;

        position: relative;
    }

    .datalist-utils {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }

    .datalist-bulk-actions,
    .datalist-filters {
        margin-right: 10px;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        column-gap: 30px;
    }

    .datalist-bulk-actions form > *,
    .datalist-filters form > * {
        margin-right: 10px;
        margin-bottom: 15px;
    }

    .datalist-actions > * {
        display: inline-block;
        margin-left: 10px;
        margin-bottom: 15px;
    }

    .datalist {
        margin-top: 15px;
        margin-bottom: 15px;
    }

    .datalist :deep(table) {
        width: 100%;
        max-width: 100%;
        min-width: min-content;
        text-align: left;
        font-family: 'Open Sans', sans-serif;
    }

    .datalist :deep(table thead) {
        font-weight: 800;
        background-color: #F6F6F6;
    }

    .datalist :deep(table tr) {
        border-bottom: 1px solid #efefef;
    }

    .datalist :deep(table tr td.actions) {
        white-space: nowrap;
        padding-left: 0; padding-right: 0;
    }

    .datalist :deep(table tr td.actions *:first-child) {
        margin-left: 0;

    }

    .datalist :deep(table tr td.actions *:last-child) {
        margin-right: 0;
    }

    .datalist :deep(table tr th),
    .datalist :deep(table tr td) {
        padding: 15px 20px 15px 20px;
        font-size: 12px;
        line-height: 12px;
        color: #666666;
    }

    .datalist :deep(table tr td a) {
        color: var(--primary);
        text-decoration: underline;
    }
    .datalist :deep(table tbody tr:nth-child(even)) {
        background-color: #FAFAFA;
    }

    .datalist :deep(table tr .datalist-checkbox),
    .datalist :deep(table tr .datalist-edit) {
        min-width: 20px;
    }

    .datalist :deep(table tr td) {
        font-weight: 500;
    }

    .datalist :deep(table tr td.datalist-id a) {
        text-decoration: underline;
    }

    .datalist :deep(table tr td strong) {
        display: inline-block;
        padding-bottom: 3px;
    }

    .datalist :deep(table tr td.datalist-status) {
        position: relative;
        padding: 15px 20px 15px 35px;
    }

    .datalist :deep(input.bulk-checkbox) {
        border-color: #000;
        background-color: #fff;
    }

    .datalist :deep(input.bulk-checkbox:checked) {
        background-color: currentColor;
    }


    .datalist .status-color {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        position: absolute;
        top: calc(50% - 4px);
        left: 20px;
    }

    /* Sort styles */
    .datalist :deep(.sortable::after) {
        font-family: "Font Awesome 5 Free";
        font-weight: 700;
        content: "  \f0dc";
        white-space: nowrap;
    }
    .datalist :deep(.sortable.asc::after) {
        font-family: "Font Awesome 5 Free";
        font-weight: 700;
        content: "  \f0dd";
    }
    .datalist :deep(.sortable.desc::after) {
        font-family: "Font Awesome 5 Free";
        font-weight: 700;
        content: "  \f0de";
    }
    .datalist :deep(.sort-description) {
        font-size: 12px;
        line-height: 12px;
        color: #666666;
    }

    /* boolean icons */
    .datalist :deep(.boolean) { text-align: center; }
    /*.datalist :deep(i), div :deep(i + strong) { display: inline; } */
    .datalist :deep(.fa-check) { color: green; }
    .datalist :deep(.actions .fa-check) { color: #AB2328; }
    .datalist :deep(.fa-times:not(.close)) { color: red; }


    @media (max-width: 767px) {
        .datalist {
            overflow-x: scroll;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .datalist-header {
            display: block;
        }
    }
</style>