<template>
  <div v-if="scheduledMessages.length > 0 || true" class="scheduled-container">
    <template v-for="(message, index) in scheduledMessages" :key="index">
      <ScheduledMessage
        v-if="scheduledMessages[index]"
        :class="scheduledMessages[index]['style']"
        :message="scheduledMessages[index]['message']"
        :canClose="false"
        @removeMessage="removeMessage(message)"
      />
    </template>
  </div>
</template>

<script>
import { ref } from 'vue'
import ScheduledMessage from '@/Components/Shared/ScheduledMessage.vue'

export default {
    components: {
        ScheduledMessage,
    },

    props: {
        scheduledMessages: {
            type: Object,
            default: () => ({}),
        },
    },
    setup(props) {
        //const messageKeys = ['message', 'success', 'warning', 'error']
        const removedMessages = ref([])
        //const pageMessages = ref([])

        /*const messages = computed(() => {
            //return pageMessages.value.filter(x => !removedMessages.value.includes(toRaw(x)));
        })*/

        /*watchEffect(() => {
            pageMessages.value = Object.entries(props.ScheduledMessages).filter(([k, v]) => v != null && messageKeys.indexOf(k) >= 0)
        })*/

        const removeMessage = (message) => {
            removedMessages.value.push(message)
        }

        return {
            removeMessage, //messages
        }
    },
}
</script>
<style scoped>
    .scheduled-container { width: 100vw; }
    @media screen and (max-width: 767px) {
        .scheduled-container { width: 100%; }
        .scheduled-container.menu-open { display: none; }
    }
</style>