<template>
  <div>
    <label>
      <input
        :id="id"
        type="checkbox"
        v-bind="$attrs"
        class="input sr-only"
        :checked="checked"
        @change="$emit('update:checked', $event)"
      />
      <div class="form-label" :class="required">{{ label }}</div>
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
          required: {
              type: String,
              default: null,
          },
          checked: {
              type: Boolean,
              default: false,
          },
          error: {
              type: String,
              default: null,
          },
      },
      emits: ['update:checked', ],
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
  .input:checked + .form-label {
    background-color: var(--on-color-dark);
    border: 1px solid var(--on-color-dark);
  }
  .input + .form-label:hover {
    background-color: var(--off-color-dark);
  }
  .input:checked + .form-label:hover {
    background-color: var(--on-color);
  }
  .input:focus + .form-label {
    background-color: var(--off-color-dark);
  }
  .input:focus:checked + .form-label {
    background-color: var(--on-color-dark);
  }
</style>
