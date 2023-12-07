<template>
  <div :id="id">
    <label>
      <div class="form-label" :class="checked ? 'checked' : ''">{{ label }}</div>
    </label>
  </div>
</template>
<script>
  export default {
      name: "InputToggleBlock",
      inheritAttrs: false,
      props: {
          id: {
              type: String,
              required: true,
          },
          label: {
              type: String,
              required: true,
          },
          checked: {
              type: Boolean,
              default: false,
          },
      },
  };
</script>
<style scoped>
  .form-label {
    --off-color: #d59194;
    --off-color-dark: #AB2328;
    --on-color: #e9eaf7;
    --on-color-dark: #A7ABDF;
    display: inline-block;
    cursor: pointer;
    padding: 2px;
    border: 1px solid var(--off-color-dark);
    background-color: var(--off-color);
    width: 2.1em;
    height: 2.1em;
    text-align: center;
  }
  .form-label.checked {
    background-color: var(--on-color-dark);
    border: 1px solid var(--off-color-dark);
  }
</style>
