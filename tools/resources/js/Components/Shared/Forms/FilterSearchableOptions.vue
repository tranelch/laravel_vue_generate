/**
 * USAGE: The entire dataset must also
 *        be contained within a root "result" element.
 */

<template>
  <div class="flex">
    <label v-if="label" :for="'lookup-' + $attrs.id" class="w-1/2">{{ label }}:</label>
    <div class="form-input-wrap">
      <input
        :id="$attrs.id + '-search'"
        type="text"
        :class="{ error: error }"
        class="form-input"
        :value="searchquery"
        @input="debounceLookup"
      >
      <div v-if="emptyDataset">No results were found for that search term</div>
      <div v-show="showSelect" class="options-container">
        <select :id="'lookup-' + $attrs.id" v-model="selectValue" class="form-input" @change="handleChange">
          <template v-for="result in dataResults" :key="result.key">
            <option :value="result.id">
              {{ modelDisplayString(result) }}
            </option>
          </template>
        </select>
      </div>
      <div v-if="error" class="text-red-500">
        {{ error }}
      </div>
    </div>
  </div>
</template>

<script>
import { computed, ref, unref } from 'vue'
import NProgress from 'nprogress'
import debounce from 'lodash.debounce'

export default {
props: {
    displayField: {
        type: [Array, Object, String],
        default: `name`,
    },
    searchquery: {
        type: String,
        default: ''
    },
    modelValue: {
        type: [Number, String],
        default: null,
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
emits: ['updateFlash', 'update:searchquery', 'update:modelValue'],

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
    const selectValue = ref(props.modelValue)

    const handleChange = (e) => {
        isSubmitted.value = false
        dataResults.value = []
        context.emit('update:modelValue', selectValue.value)
        context.emit('update:searchquery', e.target.options[e.target.selectedIndex].text)
    }

    const lookUpOptions = async (urlSearchTerm) => {
        NProgress.start()

        let url = props.lookup_url.includes('{search}') ? props.lookup_url.replace('{search}', urlSearchTerm) : props.lookup_url + urlSearchTerm;

        await axios
            .get(url)
            .then(response => {
                dataResults.value = response.data;
                isSubmitted.value = true;
                if (dataResults.value.length === 1 ) {
                    context.emit('update:modelValue', dataResults.value[0].id)
                }
                document.getElementById('lookup-' + context.attrs.id).setAttribute('size', 5)
            })
            .catch((err) => {
                flash('error', 'Sorry, lookup that information.  Please reload the page and try again.')
            })
            .finally(() => {
                NProgress.done()
            })
    }

    const debounceLookup = debounce( (e) => {
        context.emit('update:searchquery', e.target.value)
        dataResults.value = [];

        let urlSearchTerm = e.target.value === '*' ? encodeURIComponent('%') : encodeURIComponent(e.target.value)

        if (urlSearchTerm.length > 2) {
            lookUpOptions(urlSearchTerm)
        }
    }, 500)

    const modelDisplayString = (model) => {
        model = unref(model)
        if (typeof props.displayField === 'object' && props.displayField.length > 0) {
            for (var x in props.displayField) {
                let loopModel = model
                var levels = props.displayField[x].split('.')
                for (var xx in levels) {
                    loopModel = loopModel ? loopModel[levels[xx]] : null
                    if(typeof loopModel === 'undefined' || loopModel == null) break
                }
                if(loopModel) return loopModel
            }
        }
        return model ? model[props.displayField] : null
    }

    return {
        dataResults,
        modelDisplayString,
        isSubmitted,
        emptyDataset,
        showSelect,
        selectValue,
        debounceLookup,
        handleChange,
    }
}
}
</script>

<style scoped>
.form-input-wrap select.form-input { opacity: .99;}
.form-input-wrap .form-input {
    border: none;
    outline: none;
    background-color: #EEEEEE;
    border-radius: 10px;
    font-family: 'Open Sans', sans-serif;
    font-size: 12px;
    color: #666666;}
.options-container { height: 0; overflow: visible; }
</style>
