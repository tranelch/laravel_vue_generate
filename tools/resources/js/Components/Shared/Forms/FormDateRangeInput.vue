<template>
  <div class="input-wrap">
    <input
      v-model="dateFrom"
      type="date"
      placeholder="From Date"
      class="date-input"
      :name="name + '-from'"
      :min="min_date"
      :max="max_date"
    >
    <span class="text-xs mx-1">to</span>
    <input
      v-model="dateTo"
      type="date"
      placeholder="To Date"
      class="date-input"
      :name="name + '-to'"
      :min="min_date"
      :max="max_date"
    >
    <div v-if="errorMessage" class="text-red-500">{{ errorMessage }}</div>
  </div>
</template>

<script>
import { ref, computed } from 'vue'

export default {
    props: {
        name: {
            type: String,
            default: null,
        },
        min_date: {
            type: String,
            default: null,
        },
        max_date: {
            type: String,
            default: null,
        },
        modelValue: {
            type: [Object, null],
            default: () => ({from: null, to: null}),
        },
        error: {
            type: String,
            default: null,
        },
    },

    emits: ['update:modelValue'],

    setup(props, {emit}) {
      const errorMessage = ref(props.error)
        //null value does not trigger the prop default, so we use computed
        const dateFrom = computed({
          get: () => {
            return props.modelValue ? props.modelValue.from : null
          },
          set: (value) => {
            var date_regex = /^(19|20)\d{2}-(0[1-9]|1[0-2])-(0[1-9]|1\d|2\d|3[01])$/
            if(date_regex.test(value) || value.length === 0) {
              let valueDate = new Date(value)
              let minDate = new Date(props.min_date)
              let maxDate = new Date(props.max_date)
              if(
                (props.min_date !== null && valueDate < minDate) ||
                (props.max_date !== null && valueDate > maxDate)
              ) {
                errorMessage.value = 'Dates must be between ' + (props.min_date ? minDate.toDateString() : '(any date)') + ' and ' + (props.max_date ? maxDate.toDateString() : '(any date)')
              } else {
                emit('update:modelValue', {from: value, to: props.modelValue?.to})
                errorMessage.value = null
              }
            }
          }
        })

        const dateTo = computed({
          get: () => {
            return props.modelValue ? props.modelValue.to : null
          },
          set: (value) => {
            var date_regex = /^(19|20)\d{2}-(0[1-9]|1[0-2])-(0[1-9]|1\d|2\d|3[01])$/
            if(date_regex.test(value) || value.length === 0) {
              let valueDate = new Date(value)
              let minDate = new Date(props.min_date)
              let maxDate = new Date(props.max_date)
              if(
                (props.min_date !== null && valueDate < minDate) ||
                (props.max_date !== null && valueDate > maxDate)
              ) {
                errorMessage.value = 'Dates must be between ' + (props.min_date ? minDate.toDateString() : '(any date)') + ' and ' + (props.max_date ? maxDate.toDateString() : '(any date)')
              } else {
                emit('update:modelValue', {from: props.modelValue?.from, to: value})
                errorMessage.value = null
              }
            }
          }
        })

        return {
            dateFrom, dateTo, errorMessage,
        }
    },
}
</script>

<style scoped>
    @media print {
        input[type="date"]::-webkit-calendar-picker-indicator,
        input[type="time"]::-webkit-calendar-picker-indicator
        {
            display: none;
            -webkit-appearance: none;
            background: none;
        }
    }
</style>