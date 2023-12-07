<template>
  <div class="form-input-wrap">
    <input :id="id" v-bind="$attrs" type="file" :name="name"
        class="block my-2" @input="$emit('update:modelValue', $event.target.files[0])" />

    <label v-if="label" :for="id" :class="required">
      {{ label }}
    </label>
    <div v-if="error" class="text-red-500">
      {{ error }}
    </div>
  </div>
</template>

<script>
export default {
    inheritAttrs: false,
    props: {
        id: {
            type: String,
            required: true,
        },
        modelValue: {
            type: String,
            default: null,
        },
        label: {
            type: String,
            default: null,
        },
        name: {
            type: String,
            required: true,
        },
        required: {
            type: String,
            default: null,
        },
        error: {
            type: String,
            default: null,
        },
        readonly: {
            type: Boolean,
            default: null
        }
    },
    emits: ['update:modelValue'],
}
</script>

<style scoped>
</style>