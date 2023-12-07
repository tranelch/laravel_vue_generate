<template>
  <div v-if="messages.length > 0" class="fixed top-10 w-4/6 p-2 z-[50] flash-container">
    <template v-for="(message, index) in messages" :key="index">
      <FlashMessage
        v-if="messages[index]"
        :class="messages[index][0]"
        :message="messages[index][1]"
        :canClose="!messages[index][1].includes('Please see the form for specific error')"
        @removeMessage="removeMessage(message)"
      />
    </template>
  </div>
</template>

<script>
import { ref, watchEffect, toRaw, computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import FlashMessage from '@/Components/Shared/FlashMessage.vue'

export default {
    components: {
        FlashMessage,
    },

    props: {
        pageFlash: {
            type: Object,
            default: () => ({}),
        },
        localFlash: {
            type: Array,
            default: () => ([]),
        },
    },
    setup(props) {
        const messageKeys = ['message', 'success', 'warning', 'error']
        const removedMessages = ref([])
        const pageMessages = ref([])

        const messages = computed(() => {
             //let pageMessages = Object.entries(props.pageFlash).filter(([k, v]) => v != null && messageKeys.indexOf(k) >= 0)
            let ErrorLength = Object.keys(usePage().props.value.errors).length
            let formMessages = []
            if ((ErrorLength > 1)) formMessages.push(['error', 'There are ' + ErrorLength + ' form errors.  Please see the form for specific errors.'])
            else if (ErrorLength === 1) formMessages.push(['error', 'There is one form error.  Please see the form for specific error.'])

            let allMessages = props.localFlash.concat(pageMessages.value).concat(formMessages)
            return allMessages.filter(x => !removedMessages.value.includes(toRaw(x)));
        })

        watchEffect(() => {
            pageMessages.value = Object.entries(props.pageFlash).filter(([k, v]) => v != null && messageKeys.indexOf(k) >= 0)
        })

        const removeMessage = (message) => {
            removedMessages.value.push(message)
        }

        return {
            removeMessage, messages
        }
    },
}
</script>
<style scoped>
    .flash-container {width: calc(100vw - 255px);}

    @media (max-width: 767px) {
        .flash-container {width: 100%; }
    }
</style>