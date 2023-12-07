<template>
    <div class="form-input-wrap">
        <input type="number" :id="id" v-bind="$attrs" :class="{ error: error }" class="form-input number"
            :min="[min >= 0 ? Number(min) : '']" :max="[max >= 0 ? Number(max) : '']" :name="name"
            :step="[float ? '0.01' : '1']" v-model.number="numberValue" @input="$emit('update:modelValue', numberValue)" />
        <label v-if="label" :for="id" :class="required">
            {{ label }}
        </label>
        <div v-if="error" class="text-red-500">
            {{ error }}
        </div>
    </div>
</template>

<style scoped>
.form-input.number {
    min-width: 35px;
    overflow: visible;
}
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
            type: [Number, String],
        },
        label: {
            type: String,
        },
        error: {
            type: String,
        },
        min: {
            type: Number
        },
        max: {
            type: Number
        },
        name: {
            type: String
        },
        float: {
            type: Boolean
        },
        required: {
            type: String
        },
    },
    setup(props) {
        const numberValue = ref(props.modelValue);

        return {
            numberValue,
        }
    },
}
</script>