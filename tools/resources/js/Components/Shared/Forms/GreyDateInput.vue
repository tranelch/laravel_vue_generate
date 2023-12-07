<template>
    <div class="date-input-wrap">
        <input
            type="text"
            id="date-filter"
            placeholder="Filter by Date"
            class="date-input"
            :name="name"
            v-model="modelValue"
            onfocus="(this.type='date')"
            @blur="handleDateBlur"
        >
    </div>
    <button type="button" class="button-input btn-grey" @click="setDate">Today</button>
</template>

<script>
export default {
    props: {
        name: {
            type: String
        },
        modelValue: {
            type: [Object, String]
        }
    },

    setup(props, {emit}) {
        const handleDateBlur = (event) => {
            if(event.target.value) {
                var date_regex = /^(19|20)\d{2}-(0[1-9]|1[0-2])-(0[1-9]|1\d|2\d|3[01])$/
                if(date_regex.test(event.target.value)) {
                    emit('update:modelValue', props.modelValue);
                }
            }
        },
        setDate = () => {
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0');
            var yyyy = today.getFullYear();

            emit('update:modelValue', yyyy + '-' + mm + '-' + dd);
        }

        return {
            handleDateBlur, setDate,
        }
    },
}
</script>

<style scoped>
    .date-input-wrap {
        display: inline-block;
        position: relative;
    }

    .date-input {
        width: 120px;
        max-width: 150px;
    }

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
