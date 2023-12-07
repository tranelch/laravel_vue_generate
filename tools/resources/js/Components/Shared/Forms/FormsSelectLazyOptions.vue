/**
 * USAGE: The entire dataset returned from the ajax call must
 *        be contained within a root "data" element.
 */

<template>
  <div class="form-input-wrap">
    <div v-if="isEmptyDataset">No options were found</div>
    <div v-if="!isEmptyDataset">
      <select v-model="selectValue" v-bind="$attrs" aria-labelledby="label">
        <option :value="emptyValue">{{ $attrs.placeholder }}</option>
        <option v-for="result in data_results" :key="result.key" :value="result.id">
          {{ result[displayField] }}
        </option>
      </select>
    </div>
    <label v-if="label" :for="id">{{ label }}</label>
    <div v-if="errorMessage" class="text-red-500">
      {{ errorMessage }}
    </div>
  </div>
</template>

<script>
    import { onMounted, watch, computed, ref, useAttrs } from 'vue'
    import NProgress from 'nprogress'

    export default {
        inheritAttrs: false,
        props: {
            id: {
                type: String,
                default: 'api-lookup',
            },
            displayField: {
                type: String,
                default: 'name',
            },
            modelValue: {
                type: [Object, Array, String, Number],
                default: null,
            },
            label: {
                type: String,
                default: null,
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

        emits: ['update:modelValue'],

        setup(props, { emit }) {
            const attrs = useAttrs()
            const data_results = ref([]);
            const isSubmitted = ref(false);
            const componentValue = ref(props.modelValue);
            const errorMessage = ref(props.error)

            const selectValue = computed({
                get() {
                    if ('multiple' in attrs) {
                        if (componentValue.value == null) return [];
                        if (!Array.isArray(componentValue.value)) return[componentValue.value];
                    }
                    return componentValue.value;
                },
                set(value) {
                    if ('multiple' in attrs) {
                        if (value == null) componentValue.value = [];
                        else if (!Array.isArray(value)) componentValue.value = [value];
                        else componentValue.value = value;
                    }
                    else componentValue.value = value;
                }
            })

            const emptyValue = computed(() => {
                if ('multiple' in attrs) return [];
                return null;
            })
            const ajax_url = computed(() => {
                if (props.lookup_url.slice(-1) === '/') return props.lookup_url.slice(0, -1);
                return props.lookup_url;
            })
            const isEmptyDataset = computed(() => {
                return data_results.value?.length === 0 && isSubmitted.value === true;
            })

            const loadOptions = () => {
                data_results.value = [];
                isSubmitted.value = false;
                NProgress.start()

                axios
                    .get(ajax_url.value)
                    .then(response => {
                        data_results.value = response.data.data;
                        isSubmitted.value = true;
                        if (data_results.value?.length === 1 ) {
                            selectValue.value = data_results.value[0].id
                        }

                        errorMessage.value = null;
                        if (response.data.error) {
                            errorMessage.value = response.data.error;
                        }
                    })
                    .catch((err) => {
                        errorMessage.value = 'Sorry, we could not load a list of options.  Please reload the page and try again.';
                    })
                    .finally(() => {
                        NProgress.done()
                    })
            }

            onMounted(() => {
                loadOptions()
            })

            watch(() => props.modelValue, (newValue, oldValue) => {
                //if value does not exist in the lookup, do a new lookup
                if (Array.isArray(data_results.value) && newValue && (!oldValue || newValue.id !== oldValue.id)) {
                    var matches = data_results.value.filter(obj => { return obj.id === newValue.id })
                    if(matches.length === 0) loadOptions()
                }
                if (newValue !== oldValue) {
                    selectValue.value = newValue
                }
            })
            watch(() => selectValue.value, (newValue) => {
                emit('update:modelValue', newValue)
            })

            return {
                data_results,
                isSubmitted,
                ajax_url,
                isEmptyDataset,
                selectValue,
                emptyValue,
                errorMessage,
            }
        },
    };
</script>

<style scoped>
    select {width: 100%;}
</style>