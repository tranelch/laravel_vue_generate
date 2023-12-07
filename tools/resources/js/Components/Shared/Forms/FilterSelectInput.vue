<template>
    <div class="flex">
        <label v-if="label" :for="id" class="w-1/2">{{ label }}:</label>
        <div v-if="options.length > 0 || Object.keys(options).length > 0">
            <select
                v-model="selectedObject"
                v-bind="$attrs"
                class="form-input"
                @update:modelValue="$emit('update:modelValue', selectedObject)"
            >
                <option v-if="$attrs.placeholder" :value="null">{{ $attrs.placeholder }}</option>
                <option v-for="(option, index) in options" :key="index" :value="Object.keys(option)[0]">
                    {{option[Object.keys(option)[0]]}}
                </option>
            </select>
        </div>
        <div v-else>No options were found</div>
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
                default: () => ({}),
            },
            label: {
                type: String,
                default: ''
            },
        },

        
        setup(props, { emit }) {
            const selectedObject = ref(props.modelValue);

            return {
                selectedObject,
            }
        },
    };
</script>