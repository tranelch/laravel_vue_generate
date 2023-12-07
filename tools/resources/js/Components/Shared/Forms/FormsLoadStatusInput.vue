<template>
  <div class="form-input-wrap">
    <div v-if="options.length === 0"><!-- No options were found --></div>
    <div>
      <select
        :value="modelValue"
        v-bind="$attrs"
        class="form-input"
        :disabled="readonly"
        @change="$emit('update:modelValue', $event.target.value)"
      >
        <option v-if="textValue.length > 0" :value="modelValue" disabled selected hidden>{{ textValue }}</option>
        <option v-if="$attrs.placeholder" :value="null">{{ $attrs.placeholder }}</option>
        <option v-for="(option, index) in options" :key="index" :value="Object.keys(option)[0]">
          <template v-if="displayKey">{{ option[displayKey] }}</template>
          <template v-else>{{ option[Object.keys(option)[0]] }}</template>
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
    import { computed } from 'vue'

    export default {
        inheritAttrs: false,
        props: {
            id: {
                type: String,
                required: true,
            },
            options: {
                type: [Object, Array],
                default: () => ([]),
            },
            modelValue: {
                type: [Object, Array, String, Number, null],
                default: null,
            },
            label: {
                type: String,
                default: '',
            },
            displayKey: {
                type: String,
                default: null,
            },
            load_statuses: {
                type: Object,
                required: true,
            },
            load_status_map: {
                type: Object,
                required: true,
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
        emits: ['update:modelValue'],
        setup (props) {
            const textValue = computed( () => {
                var selectable = []
                Object.values(props.load_statuses).forEach((item) => {selectable.push(Object.keys(item)[0])})
                if (selectable.includes(props.modelValue + '')) return ''
                return props.load_status_map[props.modelValue] ?? ''
            })

            return { textValue, }
        }
    };
</script>