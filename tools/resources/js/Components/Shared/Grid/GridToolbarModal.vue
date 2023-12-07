<template>
  <span @click="open">
    <slot name="trigger" />
  </span>
  <teleport to="body">
    <transition leave-active-class="duration-200">
      <div v-show="show" class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-[50]" scroll-region>
        <transition
          enter-active-class="ease-out duration-300"
          enter-from-class="opacity-0"
          enter-to-class="opacity-100"
          leave-active-class="ease-in duration-200"
          leave-from-class="opacity-100"
          leave-to-class="opacity-0"
        >
          <div v-show="show" class="fixed inset-0 transform transition-all" @click="close">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
          </div>
        </transition>

        <transition
          enter-active-class="ease-out duration-300"
          enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          enter-to-class="opacity-100 translate-y-0 sm:scale-100"
          leave-active-class="ease-in duration-200"
          leave-from-class="opacity-100 translate-y-0 sm:scale-100"
          leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        >
          <div
            v-show="show" class="mb-6 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:mx-auto absolute"
            :style="{ maxWidth: maxWidth + 'px', left: triggerX + 'px', top: triggerY + 'px' }"
          >
            <slot v-if="show" name="dropdown"></slot>
          </div>
        </transition>
      </div>
    </transition>
  </teleport>
</template>

<script>
import { onMounted, onUnmounted, ref, computed } from "vue";

export default {
    props: {
        maxWidth: {
            type: Number,
            default: 300,
        },
        showModal: {
            type: Boolean,
            default: false,
        },
    },
    emits: ['openModal', 'closeModal'],

    setup(props, {emit}) {
        const show = computed( () => { return props.showModal })
        const triggerX = ref(0)
        const triggerY = ref(0)

        const open = (event) => {
            var trigger = event.target
            var coords = trigger.getBoundingClientRect()

            triggerX.value = coords.right - props.maxWidth
            triggerY.value = coords.top + trigger.offsetHeight
            emit('openModal')
        }

        const close = () => {
            emit('closeModal')
        }

        const closeOnEscape = (e) => {
            if (e.key === 'Escape' && props.show) {
                close()
            }
        }

        onMounted(() => document.addEventListener('keydown', closeOnEscape))
        onUnmounted(() => {
            document.removeEventListener('keydown', closeOnEscape)
            document.body.style.overflow = null
        })

        /*watch(props.showModal, (newValue, oldValue) => {
            show.value = newValue
        })*/

        return {
            open,
            close,
            show,
            triggerX,
            triggerY,
        }
    },
}
</script>
