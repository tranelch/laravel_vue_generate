<template>
  <div v-if="error" class="text-red-500">
    {{ error }}
  </div>
  <div class="grid grid-cols-11 gap-1 mb-10 p-5 bg-transparent max-w-xl">
    <div class="col-span-2">&nbsp;</div>
    <FormsInputToggleBlock id="usstates-BC" :checked="selectedValues.indexOf('BC') > -1" value="BC" name="us_states" label="BC" @update:checked="handleClick" />
    <FormsInputToggleBlock id="usstates-AB" :checked="selectedValues.indexOf('AB') > -1" value="AB" name="us_states" label="AB" @update:checked="handleClick" />
    <FormsInputToggleBlock id="usstates-SK" :checked="selectedValues.indexOf('SK') > -1" value="SK" name="us_states" label="SK" @update:checked="handleClick" />
    <FormsInputToggleBlock id="usstates-MB" :checked="selectedValues.indexOf('MB') > -1" value="MB" name="us_states" label="MB" @update:checked="handleClick" />
    <FormsInputToggleBlock id="usstates-ON" :checked="selectedValues.indexOf('ON') > -1" value="ON" name="us_states" label="ON" @update:checked="handleClick" />
    <FormsInputToggleBlock id="usstates-QC" :checked="selectedValues.indexOf('QC') > -1" value="QC" name="us_states" label="QC" @update:checked="handleClick" />
    <FormsInputToggleBlock id="usstates-NB" :checked="selectedValues.indexOf('NB') > -1" value="NB" name="us_states" label="NB" @update:checked="handleClick" />
    <FormsInputToggleBlock id="usstates-NS" :checked="selectedValues.indexOf('NS') > -1" value="NS" name="us_states" label="NS" @update:checked="handleClick" />
    <div>&nbsp;</div>

    <FormsInputToggleBlock id="usstates-AK" :checked="selectedValues.indexOf('AK') > -1" value="AK" name="us_states" label="AK" @update:checked="handleClick" />
    <div class="col-span-9">&nbsp;</div>
    <FormsInputToggleBlock id="usstates-ME" :checked="selectedValues.indexOf('ME') > -1" value="ME" name="us_states" label="ME" @update:checked="handleClick" />

    <div class="col-span-5">&nbsp;</div>
    <FormsInputToggleBlock id="usstates-WI" :checked="selectedValues.indexOf('WI') > -1" value="WI" name="us_states" label="WI" @update:checked="handleClick" />
    <div class="col-span-3">&nbsp;</div>
    <FormsInputToggleBlock id="usstates-VT" :checked="selectedValues.indexOf('VT') > -1" value="VT" name="us_states" label="VT" @update:checked="handleClick" />
    <FormsInputToggleBlock id="usstates-NH" :checked="selectedValues.indexOf('NH') > -1" value="NH" name="us_states" label="NH" @update:checked="handleClick" />

    <FormsInputToggleBlock id="usstates-WA" :checked="selectedValues.indexOf('WA') > -1" value="WA" name="us_states" label="WA" @update:checked="handleClick" />
    <FormsInputToggleBlock id="usstates-ID" :checked="selectedValues.indexOf('ID') > -1" value="ID" name="us_states" label="ID" @update:checked="handleClick" />
    <FormsInputToggleBlock id="usstates-MT" :checked="selectedValues.indexOf('MT') > -1" value="MT" name="us_states" label="MT" @update:checked="handleClick" />
    <FormsInputToggleBlock id="usstates-ND" :checked="selectedValues.indexOf('ND') > -1" value="ND" name="us_states" label="ND" @update:checked="handleClick" />
    <FormsInputToggleBlock id="usstates-MN" :checked="selectedValues.indexOf('MN') > -1" value="MN" name="us_states" label="MN" @update:checked="handleClick" />
    <FormsInputToggleBlock id="usstates-IL" :checked="selectedValues.indexOf('IL') > -1" value="IL" name="us_states" label="IL" @update:checked="handleClick" />
    <FormsInputToggleBlock id="usstates-MI" :checked="selectedValues.indexOf('MI') > -1" value="MI" name="us_states" label="MI" @update:checked="handleClick" />
    <div>&nbsp;</div>
    <FormsInputToggleBlock id="usstates-NY" :checked="selectedValues.indexOf('NY') > -1" value="NY" name="us_states" label="NY" @update:checked="handleClick" />
    <FormsInputToggleBlock id="usstates-MA" :checked="selectedValues.indexOf('MA') > -1" value="MA" name="us_states" label="MA" @update:checked="handleClick" />
    <div>&nbsp;</div>

    <FormsInputToggleBlock id="usstates-OR" :checked="selectedValues.indexOf('OR') > -1" value="OR" name="us_states" label="OR" @update:checked="handleClick" />
    <FormsInputToggleBlock id="usstates-NV" :checked="selectedValues.indexOf('NV') > -1" value="NV" name="us_states" label="NV" @update:checked="handleClick" />
    <FormsInputToggleBlock id="usstates-WY" :checked="selectedValues.indexOf('WY') > -1" value="WY" name="us_states" label="WY" @update:checked="handleClick" />
    <FormsInputToggleBlock id="usstates-SD" :checked="selectedValues.indexOf('SD') > -1" value="SD" name="us_states" label="SD" @update:checked="handleClick" />
    <FormsInputToggleBlock id="usstates-IA" :checked="selectedValues.indexOf('IA') > -1" value="IA" name="us_states" label="IA" @update:checked="handleClick" />
    <FormsInputToggleBlock id="usstates-IN" :checked="selectedValues.indexOf('IN') > -1" value="IN" name="us_states" label="IN" @update:checked="handleClick" />
    <FormsInputToggleBlock id="usstates-OH" :checked="selectedValues.indexOf('OH') > -1" value="OH" name="us_states" label="OH" @update:checked="handleClick" />
    <FormsInputToggleBlock id="usstates-PA" :checked="selectedValues.indexOf('PA') > -1" value="PA" name="us_states" label="PA" @update:checked="handleClick" />
    <FormsInputToggleBlock id="usstates-NJ" :checked="selectedValues.indexOf('NJ') > -1" value="NJ" name="us_states" label="NJ" @update:checked="handleClick" />
    <FormsInputToggleBlock id="usstates-CT" :checked="selectedValues.indexOf('CT') > -1" value="CT" name="us_states" label="CT" @update:checked="handleClick" />
    <FormsInputToggleBlock id="usstates-RI" :checked="selectedValues.indexOf('RI') > -1" value="RI" name="us_states" label="RI" @update:checked="handleClick" />

    <FormsInputToggleBlock id="usstates-CA" :checked="selectedValues.indexOf('CA') > -1" value="CA" name="us_states" label="CA" @update:checked="handleClick" />
    <FormsInputToggleBlock id="usstates-UT" :checked="selectedValues.indexOf('UT') > -1" value="UT" name="us_states" label="UT" @update:checked="handleClick" />
    <FormsInputToggleBlock id="usstates-CO" :checked="selectedValues.indexOf('CO') > -1" value="CO" name="us_states" label="CO" @update:checked="handleClick" />
    <FormsInputToggleBlock id="usstates-NE" :checked="selectedValues.indexOf('NE') > -1" value="NE" name="us_states" label="NE" @update:checked="handleClick" />
    <FormsInputToggleBlock id="usstates-MO" :checked="selectedValues.indexOf('MO') > -1" value="MO" name="us_states" label="MO" @update:checked="handleClick" />
    <FormsInputToggleBlock id="usstates-KY" :checked="selectedValues.indexOf('KY') > -1" value="KY" name="us_states" label="KY" @update:checked="handleClick" />
    <FormsInputToggleBlock id="usstates-WV" :checked="selectedValues.indexOf('WV') > -1" value="WV" name="us_states" label="WV" @update:checked="handleClick" />
    <FormsInputToggleBlock id="usstates-VA" :checked="selectedValues.indexOf('VA') > -1" value="VA" name="us_states" label="VA" @update:checked="handleClick" />
    <FormsInputToggleBlock id="usstates-MD" :checked="selectedValues.indexOf('MD') > -1" value="MD" name="us_states" label="MD" @update:checked="handleClick" />
    <FormsInputToggleBlock id="usstates-DE" :checked="selectedValues.indexOf('DE') > -1" value="DE" name="us_states" label="DE" @update:checked="handleClick" />
    <div>&nbsp;</div>

    <div>&nbsp;</div>
    <FormsInputToggleBlock id="usstates-AZ" :checked="selectedValues.indexOf('AZ') > -1" value="AZ" name="us_states" label="AZ" @update:checked="handleClick" />
    <FormsInputToggleBlock id="usstates-NM" :checked="selectedValues.indexOf('NM') > -1" value="NM" name="us_states" label="NM" @update:checked="handleClick" />
    <FormsInputToggleBlock id="usstates-KS" :checked="selectedValues.indexOf('KS') > -1" value="KS" name="us_states" label="KS" @update:checked="handleClick" />
    <FormsInputToggleBlock id="usstates-AR" :checked="selectedValues.indexOf('AR') > -1" value="AR" name="us_states" label="AR" @update:checked="handleClick" />
    <FormsInputToggleBlock id="usstates-TN" :checked="selectedValues.indexOf('TN') > -1" value="TN" name="us_states" label="TN" @update:checked="handleClick" />
    <FormsInputToggleBlock id="usstates-NC" :checked="selectedValues.indexOf('NC') > -1" value="NC" name="us_states" label="NC" @update:checked="handleClick" />
    <FormsInputToggleBlock id="usstates-SC" :checked="selectedValues.indexOf('SC') > -1" value="SC" name="us_states" label="SC" @update:checked="handleClick" />
    <FormsInputToggleBlock id="usstates-DC" :checked="selectedValues.indexOf('DC') > -1" value="DC" name="us_states" label="DC" @update:checked="handleClick" />
    <div class="col-span-2">&nbsp;</div>

    <div class="col-span-3">&nbsp;</div>
    <FormsInputToggleBlock id="usstates-OK" :checked="selectedValues.indexOf('OK') > -1" value="OK" name="us_states" label="OK" @update:checked="handleClick" />
    <FormsInputToggleBlock id="usstates-LA" :checked="selectedValues.indexOf('LA') > -1" value="LA" name="us_states" label="LA" @update:checked="handleClick" />
    <FormsInputToggleBlock id="usstates-MS" :checked="selectedValues.indexOf('MS') > -1" value="MS" name="us_states" label="MS" @update:checked="handleClick" />
    <FormsInputToggleBlock id="usstates-AL" :checked="selectedValues.indexOf('AL') > -1" value="AL" name="us_states" label="AL" @update:checked="handleClick" />
    <FormsInputToggleBlock id="usstates-GA" :checked="selectedValues.indexOf('GA') > -1" value="GA" name="us_states" label="GA" @update:checked="handleClick" />
    <div class="col-span-3">&nbsp;</div>

    <div class="col-span-3">&nbsp;</div>
    <FormsInputToggleBlock id="usstates-TX" :checked="selectedValues.indexOf('TX') > -1" value="TX" name="us_states" label="TX" @update:checked="handleClick" />
    <div class="col-span-4">&nbsp;</div>
    <FormsInputToggleBlock id="usstates-FL" :checked="selectedValues.indexOf('FL') > -1" value="FL" name="us_states" label="FL" @update:checked="handleClick" />
    <div class="col-span-2">&nbsp;</div>
  </div>
</template>
<script>
import { ref } from 'vue'
import FormsInputToggleBlock from '@/Components/Shared/Forms/FormsInputToggleBlock.vue'
export default {
  components: {
    FormsInputToggleBlock,
  },
  props: {
    id: {
        type: String,
        required: true,
    },
    label: {
        type: String,
        required: true,
    },
    modelValue: {
        type: Array,
        default: () => ([]),
    },
    error: {
        type: String,
        default: null,
    },
  },
  setup (props) {
      const selectedValues = ref(props.modelValue)

      const handleClick = (ev) => {
        if (ev.target.checked) selectedValues.value.push(ev.target.value)
        else {
          let idx = selectedValues.value.indexOf(ev.target.value)
          selectedValues.value.splice(idx, 1)
        }
      }

      return {
          selectedValues, handleClick,
      }
  },
}
</script>