<template>
    <div>
        <label class="container">
            <i v-if="value" class="fas fa-check color-green" style="color: green;" alt="True" />
            <i v-else class="fas fa-times color-red" style="color: red;" alt="False" />
            <span class="form-label pl-4">{{ label }}</span>
        </label>
    </div>
</template>

<script>
    export default {
        inheritAttrs: false,
        props: {
            value: {
                type: Boolean,
            },
            label: {
                type: String,
                required: true,
            },
        },
    };
</script>
