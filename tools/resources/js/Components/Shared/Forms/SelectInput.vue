<template>
    <div class="form-input-wrap">
        <select
            :id="id"
            ref="input"
            v-model="selected"
            v-bind="$attrs"
            :class="{ error: error }"
            class="form-input"
            :name="name"
        >
            <slot />
        </select>
        <label
            v-if="label"
            class="form-label"
            :for="id"
        >
            {{ label }}
        </label>
        <div
            v-if="error"
            class="form-error"
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
            type: String
        },
        modelValue: [
            String,
            Number,
            Boolean,
            Array
        ],
        label: String,
        error: String,
        name: String

    },
    data() {
        return {
            selected: this.modelValue,
        }
    },
    watch: {
        selected(selected) {
            this.$emit('update:modelValue', selected)
        },
    },
    methods: {
        focus() {
            this.$refs.input.focus()
        },
        select() {
            this.$refs.input.select()
        },
    },
}
</script>