
<template>
  <div v-if="secondaryNav?.links?.length > 0" class="secondary-header">
    <div class="form-header">
      <SecondaryNav :secondaryNav="secondaryNav" />
    </div>
  </div>

  <div class="form-wrap" :class="isDirty ? 'dirty' : ''">
    <div v-if="fromListing"><button class="text-primary" type="button" @click="previousPage()">Return to previous</button></div>
    <slot />
  </div>
</template>

<script>
import { watch, onUnmounted } from 'vue'
import { usePage } from '@inertiajs/vue3'
import SecondaryNav from '@/Components/Layout/SecondaryNav.vue'

export default {
  components: {
    SecondaryNav,
  },

  props: {
    secondaryNav: {
      type: Object,
      default: () => ({}),
    },
    isDirty: {
      type: Boolean,
      default: false,
    }
  },

  emits: ['updateFlash'],

  setup(props, { emit }) {
    const previousPage = () => {
      history.back();
    }

    const flash = (keyIn, value) => {
      emit('updateFlash', [keyIn, value])
    }

    const fromListing = usePage().props.value.flash.fromListing

    watch(() => props.isDirty,
      (newValue) => {
        if (newValue) {
          flash('message', 'Data on the form has been edited, but not saved.  Any updates will be lost if you leave the page.')
        }
      }
    )

    return { previousPage, fromListing, flash, }
  }
}
</script>

<style scoped>
  @media print { button, .secondary-header { display: none;} }
  @media (max-width: 767px) { }
  .dirty {box-shadow: 5px 5px 10px gold, -5px -5px 10px gold;}
  .form-wrap {padding: 5px;}
</style>