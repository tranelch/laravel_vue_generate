<template>
    <div class="checkbox-input-wrap">
        <input
            type="checkbox"
            :id="id"
            v-bind="$attrs"
            :class="{ error: error }"
            class="checkbox-input"
            v-model="checked"
            @change="$emit('change:modelValue', modelValue.checked)"
        />
        <label
            v-if="label"
            :for="id"
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

<script>
export default {
    inheritAttrs: false,
    emits: ['change:modelValue'],
    props: {
        id: {
            type: String
        },
        modelValue: {
            type: [String, Number, Boolean]
        },
        label: {
            type: [String]
        },
        error: {
            type: [String]
        },
        name: {
            type: [String]
        },
        value: {
            type: [String, Number, Boolean]
        },
        checked: {
            type: [Boolean, null]
        }
    },
}
</script>

<style scoped>
.checkbox-input-wrap {
    display: flex;
    flex-direction: row;
    padding: 0.5rem 0px 0.5rem 0px;
    font-size: 12px;
    line-height: 1.5rem;
    align-items: center;
}

.checkbox-input {
    margin-right: 10px;
}

.checkbox-input-wrap label {
    display: inline-block;
    font-size: 16px;
    line-height: 1.5rem;
    padding: 0px 0px 0px 0px;
}
</style>