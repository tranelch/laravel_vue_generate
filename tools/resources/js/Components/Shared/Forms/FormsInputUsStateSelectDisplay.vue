<template>
  <div :id="id" class="grid grid-cols-11 gap-1 mb-10 p-5 bg-transparent max-w-xl">
    <div class="col-span-2">&nbsp;</div>
    <FormsInputToggleBlockDisplay id="usstates-BC" :checked="selectedValues.indexOf('BC') > -1" value="BC" name="us_states" label="BC" />
    <FormsInputToggleBlockDisplay id="usstates-AB" :checked="selectedValues.indexOf('AB') > -1" value="AB" name="us_states" label="AB" />
    <FormsInputToggleBlockDisplay id="usstates-SK" :checked="selectedValues.indexOf('SK') > -1" value="SK" name="us_states" label="SK" />
    <FormsInputToggleBlockDisplay id="usstates-MB" :checked="selectedValues.indexOf('MB') > -1" value="MB" name="us_states" label="MB" />
    <FormsInputToggleBlockDisplay id="usstates-ON" :checked="selectedValues.indexOf('ON') > -1" value="ON" name="us_states" label="ON" />
    <FormsInputToggleBlockDisplay id="usstates-QC" :checked="selectedValues.indexOf('QC') > -1" value="QC" name="us_states" label="QC" />
    <FormsInputToggleBlockDisplay id="usstates-NB" :checked="selectedValues.indexOf('NB') > -1" value="NB" name="us_states" label="NB" />
    <FormsInputToggleBlockDisplay id="usstates-NS" :checked="selectedValues.indexOf('NS') > -1" value="NS" name="us_states" label="NS" />
    <div>&nbsp;</div>

    <FormsInputToggleBlockDisplay id="usstates-AK" :checked="selectedValues.indexOf('AK') > -1" value="AK" name="us_states" label="AK" />
    <div class="col-span-9">&nbsp;</div>
    <FormsInputToggleBlockDisplay id="usstates-ME" :checked="selectedValues.indexOf('ME') > -1" value="ME" name="us_states" label="ME" />

    <div class="col-span-5">&nbsp;</div>
    <FormsInputToggleBlockDisplay id="usstates-WI" :checked="selectedValues.indexOf('WI') > -1" value="WI" name="us_states" label="WI" />
    <div class="col-span-3">&nbsp;</div>
    <FormsInputToggleBlockDisplay id="usstates-VT" :checked="selectedValues.indexOf('VT') > -1" value="VT" name="us_states" label="VT" />
    <FormsInputToggleBlockDisplay id="usstates-NH" :checked="selectedValues.indexOf('NH') > -1" value="NH" name="us_states" label="NH" />

    <FormsInputToggleBlockDisplay id="usstates-WA" :checked="selectedValues.indexOf('WA') > -1" value="WA" name="us_states" label="WA" />
    <FormsInputToggleBlockDisplay id="usstates-ID" :checked="selectedValues.indexOf('ID') > -1" value="ID" name="us_states" label="ID" />
    <FormsInputToggleBlockDisplay id="usstates-MT" :checked="selectedValues.indexOf('MT') > -1" value="MT" name="us_states" label="MT" />
    <FormsInputToggleBlockDisplay id="usstates-ND" :checked="selectedValues.indexOf('ND') > -1" value="ND" name="us_states" label="ND" />
    <FormsInputToggleBlockDisplay id="usstates-MN" :checked="selectedValues.indexOf('MN') > -1" value="MN" name="us_states" label="MN" />
    <FormsInputToggleBlockDisplay id="usstates-IL" :checked="selectedValues.indexOf('IL') > -1" value="IL" name="us_states" label="IL" />
    <FormsInputToggleBlockDisplay id="usstates-MI" :checked="selectedValues.indexOf('MI') > -1" value="MI" name="us_states" label="MI" />
    <div>&nbsp;</div>
    <FormsInputToggleBlockDisplay id="usstates-NY" :checked="selectedValues.indexOf('NY') > -1" value="NY" name="us_states" label="NY" />
    <FormsInputToggleBlockDisplay id="usstates-MA" :checked="selectedValues.indexOf('MA') > -1" value="MA" name="us_states" label="MA" />
    <div>&nbsp;</div>

    <FormsInputToggleBlockDisplay id="usstates-OR" :checked="selectedValues.indexOf('OR') > -1" value="OR" name="us_states" label="OR" />
    <FormsInputToggleBlockDisplay id="usstates-NV" :checked="selectedValues.indexOf('NV') > -1" value="NV" name="us_states" label="NV" />
    <FormsInputToggleBlockDisplay id="usstates-WY" :checked="selectedValues.indexOf('WY') > -1" value="WY" name="us_states" label="WY" />
    <FormsInputToggleBlockDisplay id="usstates-SD" :checked="selectedValues.indexOf('SD') > -1" value="SD" name="us_states" label="SD" />
    <FormsInputToggleBlockDisplay id="usstates-IA" :checked="selectedValues.indexOf('IA') > -1" value="IA" name="us_states" label="IA" />
    <FormsInputToggleBlockDisplay id="usstates-IN" :checked="selectedValues.indexOf('IN') > -1" value="IN" name="us_states" label="IN" />
    <FormsInputToggleBlockDisplay id="usstates-OH" :checked="selectedValues.indexOf('OH') > -1" value="OH" name="us_states" label="OH" />
    <FormsInputToggleBlockDisplay id="usstates-PA" :checked="selectedValues.indexOf('PA') > -1" value="PA" name="us_states" label="PA" />
    <FormsInputToggleBlockDisplay id="usstates-NJ" :checked="selectedValues.indexOf('NJ') > -1" value="NJ" name="us_states" label="NJ" />
    <FormsInputToggleBlockDisplay id="usstates-CT" :checked="selectedValues.indexOf('CT') > -1" value="CT" name="us_states" label="CT" />
    <FormsInputToggleBlockDisplay id="usstates-RI" :checked="selectedValues.indexOf('RI') > -1" value="RI" name="us_states" label="RI" />

    <FormsInputToggleBlockDisplay id="usstates-CA" :checked="selectedValues.indexOf('CA') > -1" value="CA" name="us_states" label="CA" />
    <FormsInputToggleBlockDisplay id="usstates-UT" :checked="selectedValues.indexOf('UT') > -1" value="UT" name="us_states" label="UT" />
    <FormsInputToggleBlockDisplay id="usstates-CO" :checked="selectedValues.indexOf('CO') > -1" value="CO" name="us_states" label="CO" />
    <FormsInputToggleBlockDisplay id="usstates-NE" :checked="selectedValues.indexOf('NE') > -1" value="NE" name="us_states" label="NE" />
    <FormsInputToggleBlockDisplay id="usstates-MO" :checked="selectedValues.indexOf('MO') > -1" value="MO" name="us_states" label="MO" />
    <FormsInputToggleBlockDisplay id="usstates-KY" :checked="selectedValues.indexOf('KY') > -1" value="KY" name="us_states" label="KY" />
    <FormsInputToggleBlockDisplay id="usstates-WV" :checked="selectedValues.indexOf('WV') > -1" value="WV" name="us_states" label="WV" />
    <FormsInputToggleBlockDisplay id="usstates-VA" :checked="selectedValues.indexOf('VA') > -1" value="VA" name="us_states" label="VA" />
    <FormsInputToggleBlockDisplay id="usstates-MD" :checked="selectedValues.indexOf('MD') > -1" value="MD" name="us_states" label="MD" />
    <FormsInputToggleBlockDisplay id="usstates-DE" :checked="selectedValues.indexOf('DE') > -1" value="DE" name="us_states" label="DE" />
    <div>&nbsp;</div>

    <div>&nbsp;</div>
    <FormsInputToggleBlockDisplay id="usstates-AZ" :checked="selectedValues.indexOf('AZ') > -1" value="AZ" name="us_states" label="AZ" />
    <FormsInputToggleBlockDisplay id="usstates-NM" :checked="selectedValues.indexOf('NM') > -1" value="NM" name="us_states" label="NM" />
    <FormsInputToggleBlockDisplay id="usstates-KS" :checked="selectedValues.indexOf('KS') > -1" value="KS" name="us_states" label="KS" />
    <FormsInputToggleBlockDisplay id="usstates-AR" :checked="selectedValues.indexOf('AR') > -1" value="AR" name="us_states" label="AR" />
    <FormsInputToggleBlockDisplay id="usstates-TN" :checked="selectedValues.indexOf('TN') > -1" value="TN" name="us_states" label="TN" />
    <FormsInputToggleBlockDisplay id="usstates-NC" :checked="selectedValues.indexOf('NC') > -1" value="NC" name="us_states" label="NC" />
    <FormsInputToggleBlockDisplay id="usstates-SC" :checked="selectedValues.indexOf('SC') > -1" value="SC" name="us_states" label="SC" />
    <FormsInputToggleBlockDisplay id="usstates-DC" :checked="selectedValues.indexOf('DC') > -1" value="DC" name="us_states" label="DC" />
    <div class="col-span-2">&nbsp;</div>

    <div class="col-span-3">&nbsp;</div>
    <FormsInputToggleBlockDisplay id="usstates-OK" :checked="selectedValues.indexOf('OK') > -1" value="OK" name="us_states" label="OK" />
    <FormsInputToggleBlockDisplay id="usstates-LA" :checked="selectedValues.indexOf('LA') > -1" value="LA" name="us_states" label="LA" />
    <FormsInputToggleBlockDisplay id="usstates-MS" :checked="selectedValues.indexOf('MS') > -1" value="MS" name="us_states" label="MS" />
    <FormsInputToggleBlockDisplay id="usstates-AL" :checked="selectedValues.indexOf('AL') > -1" value="AL" name="us_states" label="AL" />
    <FormsInputToggleBlockDisplay id="usstates-GA" :checked="selectedValues.indexOf('GA') > -1" value="GA" name="us_states" label="GA" />
    <div class="col-span-3">&nbsp;</div>

    <div class="col-span-3">&nbsp;</div>
    <FormsInputToggleBlockDisplay id="usstates-TX" :checked="selectedValues.indexOf('TX') > -1" value="TX" name="us_states" label="TX" />
    <div class="col-span-4">&nbsp;</div>
    <FormsInputToggleBlockDisplay id="usstates-FL" :checked="selectedValues.indexOf('FL') > -1" value="FL" name="us_states" label="FL" />
    <div class="col-span-2">&nbsp;</div>
  </div>
</template>
<script>
import FormsInputToggleBlockDisplay from '@/Components/Shared/Forms/FormsInputToggleBlockDisplay.vue'
export default {
  components: {
    FormsInputToggleBlockDisplay,
  },
  props: {
    id: {
        type: String,
        required: true,
    },
    selectedValues: {
        type: Array,
        default: () => ([]),
    },
  },
}
</script>