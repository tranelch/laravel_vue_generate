<template>
  <div class="form-input-wrap">
    <div class="display-only" v-bind="$attrs">{{ value ?? '&nbsp;' }}</div>
    <label v-if="label">
      {{ label }}
    </label>
  </div>
</template>

<script>
export default {
    inheritAttrs: false,
    props: {
        value: {
            type: [String, Number],
            default: null,
        },
        label: {
            type: String,
            default: null,
        },
    },
}
</script>

<style scoped>
    .display-only {border-bottom: 1px solid #eee; padding: .5rem 0; min-height: 24px; color: #666; white-space: pre-line;}
    label {color: #aaa;}
    @media print {
        .display-only {color: black;}
        label {color: black;}
    }

</style>