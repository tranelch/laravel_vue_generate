<template>
    <div class="form-input-wrap">
        <input
            type="email"
            :id="id"
            v-bind="$attrs"
            :class="{ error: error }"
            class="form-input"
            @input="$emit('update:modelValue', modelValue)"
            v-model="modelValue"
            :readonly="readonly"
        />
        <!-- :readonly="[readonly ? true : null]" -->
        <label
            v-if="label"
            :for="id"
            :class="required"
         >
                {{ label }}
        </label>
        <div
            v-if="error"
            class="text-red-500"
        >
            {{ error }}
        </div>
    </div>
</template>

<style scoped>
</style>

<script>
export default {
    inheritAttrs: false,
    emits: ['update:modelValue'],
    props: {
        id: {
            type: String,
        },
        modelValue: {
            type: [String, Number],
        },
        label: {
            type: [String],
        },
        required: {
            type: String,
        },
       error: {
            type: [String],
        },
        readonly: {
            type: Boolean,
            default: null
        }
    },
}
</script>