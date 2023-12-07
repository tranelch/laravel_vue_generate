<template>
    <div class="toggle-display">
            <i v-if="value === true" class="fas fa-check color-green" style="color: green;" alt="True" aria-hidden="true" />
            <i v-if="value === false" class="fas fa-times color-red" style="color: red;" alt="False" aria-hidden="true" />
            <!--<i v-if="value === null" class="fas fa-question color-gray" style="color: gray;" alt="Unknown" aria-hidden="true" />-->
            <span v-if="label && value !== null" class="form-label">{{ label }}</span>
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
            },
        },
    };
</script>

<style scoped>
    .form-label {font-weight: 700;}
    i {padding-right: 1em;}
    .fa-check { color: green; }
    .fa-times { color: red; }
</style>