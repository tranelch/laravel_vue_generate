/**
 * USAGE: The entire dataset must also
 *        be contained within a root "result" element.
 */

<template>
  <div class="form-input-wrap">
    <input
      type="text"
      v-bind="$attrs"
      :class="{ error: error }"
      class="form-input"
      :value="searchquery"
      @input="debounceLookup"
      @keyup="keyClick"
      @keydown.enter.prevent
      @focusout="resetSearch"
    >
    <div v-if="emptyDataset">No results were found for that search term</div>
    <div v-show="showSelect" class="options-container">
      <select :id="'api-lookup-' + $attrs.id" :value="modelValue" class="form-input" tabindex="-1" @change="handleChange">
        <option v-if="Object.keys(initialValue).length > 0" selected :value="initialValue">{{ modelDisplayString(initialValue) }}</option>
        <template v-for="result in dataResults" :key="result.key">
          <option v-if="Object.keys(initialValue).length > 0 || initialValue.id !== result.id" :value="result" @click="triggerChange(result)">
            {{ modelDisplayString(result) }}
          </option>
        </template>
      </select>
    </div>
    <label v-if="label">{{ label }}</label>

    <div v-if="error" class="text-red-500">
      {{ error }}
    </div>
  </div>
</template>

<script>
import { computed, ref, unref, watch, } from 'vue'
import NProgress from 'nprogress'
import debounce from 'lodash.debounce'

export default {
inheritAttrs: false,

props: {
    displayField: {
        type: [Array, Object, String],
        default() {
            return `name`;
        },
    },
    searchquery: {
        type: String,
        default: ''
    },
    modelValue: {
        type: Object,
        default() {
            return {};
        },
    },
    label: {
        type: String,
        default: '',
    },
    lookup_url: {
        type: String,
        required: true,
    },
    error: {
        type: String,
        default: null,
    },
},
emits: ['updateFlash', 'update:searchquery', 'changeModelValue'],

setup(props, context) {
    const flash = (keyIn, value) => {
        context.emit('updateFlash', [keyIn, value])
    }
    const dataResults = ref([])
    const isSubmitted = ref(false)
    const emptyDataset = computed( () => {
        return Object.keys(dataResults.value).length === 0 && isSubmitted.value;
    })
    const showSelect = computed( () => {
        return (
            dataResults.value.length > 0
        );
    })
    const initialValue = computed( () => {
        return  !isSubmitted.value ? props.modelValue ?? {} : {};
    })

    const handleChange = (event) => {
        triggerChange(dataResults.value[event.target.selectedIndex])
    }

    const triggerChange = (value) => {
        context.emit('changeModelValue', value)
        context.emit('update:searchquery', modelDisplayString(value))
        isSubmitted.value = false
        dataResults.value = []
    }

    const resetSearch = (e) => {
        //if focus goes to the select element, do nothing
        if(document.getElementById('api-lookup-' + context.attrs.id) === e.relatedTarget) return

        //reset search, and revert to
        isSubmitted.value = false
        dataResults.value = []
        context.emit('update:searchquery', modelDisplayString(props.modelValue))
    }

    const debounceLookup = debounce( (e) => {
        context.emit('update:searchquery', e.target.value)
        dataResults.value = [];

        let urlSearchTerm = e.target.value === '*' ? encodeURIComponent('%') : encodeURIComponent(e.target.value)

        if (urlSearchTerm.length === 0) {
            triggerChange(null)
        }

        if (urlSearchTerm.length > 2) {
            NProgress.start()

            let url = props.lookup_url.includes('{search}') ? props.lookup_url.replace('{search}', urlSearchTerm) : props.lookup_url + urlSearchTerm;

            axios
                .get(url)
                .then(response => {
                    dataResults.value = response.data;
                    isSubmitted.value = true;
                    if (dataResults.value.length === 1 ) {
                        triggerChange(dataResults.value[0])
                    }
                    document.getElementById('api-lookup-' + context.attrs.id).setAttribute('size', 5)
                })
                .catch((err) => {
                    flash('error', 'Sorry, we could not look up that information.  Please reload the page and try again.')
                })
                .finally(() => {
                    NProgress.done()
                })
        }
    }, 500)

    const modelDisplayString = (model) => {
        model = unref(model)
        if (typeof props.displayField === 'object' && props.displayField.length > 0) {
            for (var x in props.displayField) {
                let loopModel = model
                var levels = props.displayField[x].split('.')
                for (var x in levels) {
                    loopModel = loopModel ? loopModel[levels[x]] : null
                    if(typeof loopModel === 'undefined' || loopModel == null) break
                }
                if(loopModel) return loopModel
            }
        }
        return model ? model[props.displayField] : null
    }

    const keyClick = (e) => {
        let selectEl = document.getElementById('api-lookup-' + context.attrs.id)
        if (e.keyCode == 38 && selectEl.selectedIndex > -1) {
            selectEl.selectedIndex--
        } else if (e.keyCode == 40 && selectEl.selectedIndex < selectEl.options.length) {
            selectEl.selectedIndex++
        } else if (e.keyCode == 13) {
            triggerChange(dataResults.value[selectEl.selectedIndex])
        }

    }

    watch(() => props.modelValue,
        (newValue, oldValue) => {
            if (newValue && Object.keys(newValue).length > 0) {
                context.emit('update:searchquery', modelDisplayString(newValue))
            }
        },{immediate:true}
    )

    return {
        dataResults,
        modelDisplayString,
        isSubmitted,
        emptyDataset,
        showSelect,
        initialValue,
        debounceLookup,
        handleChange, triggerChange, keyClick, resetSearch,
    }
}
}
</script>

<style scoped>
    .form-input-wrap select.form-input { background: white; opacity: .99;}
    .options-container { height: 0; overflow: visible; z-index: 20; position: sticky;}
</style>
