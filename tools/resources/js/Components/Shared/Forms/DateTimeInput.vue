<template>
  <div class="form-input-wrap">
    <div>
      <input
        :id="id+'-date'"
        ref="dateInput"
        v-model="dateValue"
        v-bind="$attrs"
        :aria-labelledby="id+'-date-time'"
        class="form-input"
        :class="timeValue && !dateValue ? 'required' : ''"
        type="date"
        :name="name+'-date'"
        :required="required || timeValue"
      >
      <input
        v-bind="$attrs"
        :id="id+'-time'"
        ref="timeInput"
        v-model="timeValue"
        :aria-labelledby="id+'-date-time'"
        class="form-input"
        :class="dateValue && !timeValue ? 'suggested' : ''"
        type="time"
        :name="name+'-time'"
        :required="required"
        @focus="setTimeToCurrent"
      >
    </div>
    <label v-if="label" :id="id+'-date-time'" :class="required">
      {{ label }}
    </label>
    <div v-if="error" class="text-red-500">
      {{ error }}
    </div>
  </div>
</template>
<script>
    import { computed } from 'vue'

    export default {
        inheritAttrs: false,

        props: {
            modelValue: {
                type: String,
                default: null,
            },
            name: {
                type: String,
                default: null,
            },
            id: {
                type: String,
                default: null,
            },
            label: {
                type: String,
                default: null,
            },
            required: {
                type: String,
                default: null,
            },
            error: {
                type: String,
                default: null,
            },
        },

        emits: ['update:modelValue'],

        setup(props, { emit }) {
            const dateValue = computed({
                get: () => {
                    // If both date and time are set
                    if (props.modelValue != null && props.modelValue.trim().indexOf(' ') > 0) {
                        var pieces = props.modelValue.split(' ')
                        return pieces[0]
                    // Else if only date is set
                    } else if (props.modelValue != null && props.modelValue.indexOf('-') > 0) {
                        return props.modelValue.trim()
                    }
                    return null;
                },
                set: (value) => {
                    var setTime = ''
                    // If current value has date and time, pull the setTime from value to combine with new date value
                    if (props.modelValue != null && props.modelValue.trim().indexOf(' ') > 0) {
                        setTime = props.modelValue.split(' ')[1]
                   // Else if only time is set, capture that value to combine with new date value
                    } else if (props.modelValue != null && props.modelValue.indexOf(':') > 0){
                        setTime = props.modelValue.trim()
                    }
                    emit('update:modelValue', value.trim() + ' ' + setTime)
                }
            })

            const timeValue = computed({
                get: () => {
                    // If both date and time are set
                    if (props.modelValue != null && props.modelValue.trim().indexOf(' ') > 0) {
                        var pieces = props.modelValue.split(' ')
                        return pieces[1]
                    // Else if only time is set
                    } else if (props.modelValue != null && props.modelValue.indexOf(':') > 0) {
                        return props.modelValue.trim()
                    }

                    return null
                },
                set: (value) => {
                    var setDate = ''
                    // If current value has date and time, pull the setDate from value to combine with new time value
                    if (props.modelValue != null && props.modelValue.indexOf(' ') > 0){
                        setDate = props.modelValue.split(' ')[0]
                   // Else if only date is set, capture that value to combine with new time value
                    } else if (props.modelValue != null && props.modelValue.indexOf('-') > 0) {
                        setDate = props.modelValue.trim()
                    }
                    emit('update:modelValue', setDate + ' ' + value.trim())
                }
            })

            const setTimeToCurrent = () => {
                if (timeValue.value) return
                const d = new Date()
                let hour = d.getHours() + 1
                if (hour < 10) hour = '0' + hour
                emit('update:modelValue', dateValue.value + ' ' + hour + ":00")
            }

            return {
                dateValue,
                timeValue,
                setTimeToCurrent,
            }
        }
    }
</script>

<style scoped>
    .form-input-wrap > div {
        display: flex;
        flex-direction: row;
    }
    .form-input {
        display: inline-block;
    }

    input.required { background-color: #db5959; }
    input.suggested { background-color: #ffffc2; }

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