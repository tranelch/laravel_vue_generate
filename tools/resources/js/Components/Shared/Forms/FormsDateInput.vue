<template>
  <div class="form-input-wrap">
    <div>
      <input
        :id="id+'-date'"
        v-model="dateValue"
        v-bind="$attrs"
        type="date"
        class="form-input"
        :name="name+'-date'"
        @input="$emit('update:modelValue', dateValue)"
      >
    </div>
    <label v-if="label" :class="required">
      {{ label }}
    </label>
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
            modelValue: {
                type: String,
                default: null,
            },
            name: {
                type: String,
                default: null,
            },
            id: {
                type: String,
                default: null,
            },
            label: {
                type: String,
                default: null,
            },
            required: {
                type: String,
                default: null,
            },
            error: {
                type: String,
                default: null,
            },
        },

        emits: ['update:modelValue'],

        setup(props) {
            const dateValue = ref(props.modelValue)

            return {
                dateValue,
            }
        }
    }
</script>

<style scoped>
    .form-input-wrap > div {
        display: flex;
        flex-direction: row;
    }

    .form-input {
        display: inline-block;
    }

    @media print {
        input[type="date"]::-webkit-calendar-picker-indicator
        {
            display: none;
            -webkit-appearance: none;
            background: none;
        }
    }
</style>