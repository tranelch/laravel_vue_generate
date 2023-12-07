<template>
    <div class="form-input-wrap">
        <div v-if="options.length === 0"><!-- No options were found --></div>
        <div>
            <select
                v-model="selectedObject"
                v-bind="$attrs"
                class="form-input"
                @update:modelValue="$emit('update:modelValue', selectedObject)"
                :disabled="readonly"
            >
                <option v-if="$attrs.placeholder" :value="null">{{ $attrs.placeholder }}</option>
                <option v-for="(option, index) in options" :key="index" :value="Object.keys(option)[0]">
                    <template v-if="displayKey">{{option[displayKey]}}</template>
                    <template v-else>{{option[Object.keys(option)[0]]}}</template>
                </option>
            </select>
        </div>
        <label v-if="label" :for="id" :class="required">{{ label }}</label>
        <div v-if="error" class="text-red-500">
            {{ error }}
        </div>
    </div>
</template>

<script>
    import { ref } from 'vue'

    export default {
        inheritAttrs: false,
        props: {
            id: {
                type: String,
                default: null,
            },
            options: {
                type: [Object, Array],
                default: () => ([]),
            },
            modelValue: {
                type: [Object, Array, String, Number, null],
                default: null
            },
            label: {
                type: String,
                default: null,
            },
            displayKey: {
                type: String,
                default: null,
            },
            error: {
                type: String,
                default: null,
            },
            required: {
                type: String,
                default: null,
            },
            readonly: {
                type: Boolean,
                default: null
            }
        },

        setup(props) {
            const selectedObject = ref(props.modelValue);

            return {
                selectedObject,
            }
        },
    };
</script>