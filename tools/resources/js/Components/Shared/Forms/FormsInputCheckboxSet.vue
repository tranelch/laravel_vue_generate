<template>
  <div v-if="showSelectAll" class="checkbox-input-wrap">
    <input id="selectall" v-model="selectAll" type="checkbox" value="selectAll" class="checkbox-input" @change="toggleSelectAll($event)">
    <label for="selectall" class="label">{{ selectAllLabel }}</label>
  </div>

  <template v-for="(option, index) in options" :key="index">
    <div class="checkbox-input-wrap">
      <input
        :id="id + index"
        v-bind="$attrs"
        v-model="formValue"
        :value="index"
        type="checkbox"
        class="checkbox-input"
        @change="$emit('change:modelValue', formValue)"
      />
      <label v-if="option" :for="id + index" class="label">{{ option }}</label>
    </div>
  </template>
  <div v-if="error" class="text-red-500">{{ error }}</div>
</template>

<script>
import { ref, computed } from 'vue'

export default {
    inheritAttrs: false,
    props: {
      id: {
        type: String,
        default: null,
      },
      modelValue: {
        type: Array,
        default: () => ([])
      },
      options: {
        type: Object,
        required: true,
      },
      showSelectAll: {
        type: Boolean,
        default: false,
      },
      error: {
        type: String,
        default: null,
      },
    },

    emits: ['change:modelValue'],

    setup(props) {
      const formValue = ref(props.modelValue)

      const selectAll = ref(false);
      const toggleSelectAll = () => {
        if (selectAll.value) {
          Object.keys(props.options).forEach(function(key, value) {
            formValue.value.push(key)
          })
        } else {
          formValue.value = []
        }
      }
      const selectAllLabel = computed( () => {
          return selectAll.value ? 'Deselect all' : 'Select all'
        }
      )

      return {
        formValue, toggleSelectAll, selectAll, selectAllLabel,
      }
    }
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
    padding: 0px 0px 0px 0px;
    }
  </style>