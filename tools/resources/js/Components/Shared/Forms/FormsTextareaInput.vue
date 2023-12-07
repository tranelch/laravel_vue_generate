<template>
    <div class="form-input-wrap">
        <textarea
            :id="id"
            v-bind="$attrs"
            :class="{ error: error }"
            :rows="rows"
            class="form-input"
            :name="name"
            v-model="textValue"
        />
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
.form-input {
    /*outline: none;*/
    border: solid 1px #eee;
    border-bottom-color: black;
}
</style>

<script>
export default {
    inheritAttrs: false,
    props: {
        id: String,
        modelValue: String,
        label: String,
        error: String,
        name: String,
        required: String,
        rows: {
            type: Number,
            default: 3,
        }
    },
    setup(props) {
        const textValue = ref(props.modelValue);

        return {
            textValue,
        }
    },
}
</script>