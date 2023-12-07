<template>
  <div class="toggle-control">
    <div class="toggle-wrap h-full my-auto">
      <label class="container-off" :class="toggleClass" @mouseup="$emit('update:modelValue', false)">
        <span class="switch switch-off" :class="toggleClass">N</span>
      </label>
      <label class="container-null" :class="toggleClass" @mouseup="$emit('update:modelValue', null)">
        <span class="switch switch-null" :class="toggleClass"></span>
      </label>
      <label class="container-on" :class="toggleClass" @mouseup="$emit('update:modelValue', true)">
        <span class="switch switch-on" :class="toggleClass">Y</span>
      </label>
    </div>
    <div class="form-label" :class="required">{{ label }}</div>
    <div v-if="error" class="text-red-500">
      {{ error }}
    </div>
  </div>
</template>

<script>
    import { computed } from 'vue'

    export default {
        name: "ToggleInput",
        inheritAttrs: false,
        props: {
            id: {
                type: String,
                default: null,
            },
            label: {
                type: String,
                required: true,
            },
            required: {
                type: String,
                default: null,
            },
            modelValue: {
                type: Boolean,
                default: null,
            },
            error: {
                type: String,
                default: null,
            },
        },

        setup(props) {
            const toggleClass = computed( () => {
                if (props.modelValue == null) return 'null'
                return props.modelValue ? 'on' : 'off';
            })

            return { toggleClass, }
        }
    };
</script>
<style scoped>
    .container-on, .container-null, .container-off {
        --switch-container-width: 60px;
        --switch-size: calc(var(--switch-container-width) / 3);
        --null-color: #B4B9BF;
        --on-color: #11A925;
        --off-color: #AB2328;

        /* Vertically center the inner circle */
        cursor: pointer;
        display: flex;
        flex-shrink: 0;
        align-items: center;
        position: relative;
        height: var(--switch-size);
        flex-basis: calc(var(--switch-container-width) / 3);
        background-color: var(--null-color);
        transition: background-color 0.25s ease-in-out;
        overflow: visible;
    }

    .toggle-control {
        white-space: nowrap;
        display: flex;
        padding: .5rem 0;
    }

    .container-on span, .container-null span, .container-off span {
        width: 100%;
        text-align: center;
        font-size: 10px;
    }

    /* Round the outside elements of toggle switch */
    .container-off {
        border-top-left-radius: var(--switch-size);
        border-bottom-left-radius: var(--switch-size);
    }
    .container-on {
        border-top-right-radius: var(--switch-size);
        border-bottom-right-radius: var(--switch-size);
    }
    .toggle-wrap {
        display: inline-flex;
        width: 60px;
        vertical-align: middle;
    }

    .form-label {
        display: inline-block;
        font-size: 12px;
        margin-left: 12px;
        white-space: break-spaces;
        width: calc(100% - 60px);
    }

    /* Show the circle switch */
     .switch-on.on::before, .switch-null.null::before, .switch-off.off::before {
        content: "";
        font-size: 10px;
        font-weight: bold;
        text-align: center;
        position: absolute;
        /* Move a little bit the inner circle to the right */
        left: 2px;
        top: 2px;
        height: calc(var(--switch-size) - 4px);
        width: calc(var(--switch-size) - 4px);
        /* Make the inner circle fully rounded */
        border-radius: 9999px;
        background-color: white;
        transition: transform 0.375s ease-in-out;
    }
    .switch-on.on::before {content: "Y"}
    .switch-null.null::before {content: "?"}
    .switch-off.off::before {content: "N"}

    label.on {
        background-color: var(--on-color);
    }
    label.null {
        background-color: var(--null-color);
    }
    label.off {
        background-color: var(--off-color);
    }
</style>
