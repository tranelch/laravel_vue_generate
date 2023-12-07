<template>
  <div class="w-screen scheduled text-center">
    <button v-if="canClose" type="button" class="group p-2 pr-0 inline-block" @click="$emit('removeMessage')">
      <svg class="block w-2 h-2 fill-red-800 group-hover:fill-white" xmlns="http://www.w3.org/2000/svg" width="235.908" height="235.908" viewBox="278.046 126.846 235.908 235.908"><path d="M506.784 134.017c-9.56-9.56-25.06-9.56-34.62 0L396 210.18l-76.164-76.164c-9.56-9.56-25.06-9.56-34.62 0-9.56 9.56-9.56 25.06 0 34.62L361.38 244.8l-76.164 76.165c-9.56 9.56-9.56 25.06 0 34.62 9.56 9.56 25.06 9.56 34.62 0L396 279.42l76.164 76.165c9.56 9.56 25.06 9.56 34.62 0 9.56-9.56 9.56-25.06 0-34.62L430.62 244.8l76.164-76.163c9.56-9.56 9.56-25.06 0-34.62z" /></svg>
    </button>
    <div class="inline-block">
      <div v-if="message" class="p-2 text-sm font-medium" v-html="displayMessage(message)"></div>
      <slot />
    </div>
  </div>
</template>

<script>
export default {
    props: {
        message: {
            type: String,
            default: null
        },
        canClose: {
            type: Boolean,
            default: true,
        }
    },
    emits: ['removeMessage',],
    setup(props) {
        const displayMessage = (message) => {
            // remove all tags, then replace only line returns with <br> so html can be safely displayed
            let div = document.createElement("div")
            div.innerHTML = message
            let text = div.textContent || div.innerText || ""

            return text.replaceAll('\n', '<br>')
        }

        return {
            displayMessage
        }
    },
}
</script>

<style scoped>
    /* Scheduled Messages     .scheduled:after {display: inline-block; content: "\00d7"; cursor: pointer; pointer-events: all;}*/
    .scheduled.message {color: #0A3055; background-color: #c2ddff; border-bottom: solid 2px #0A3055;}
    .scheduled.success {color: #06381b; background-color: #97ffc3; border-bottom: solid 2px #06381b;}
    .scheduled.warning {color: #8D6708; background-color: #ffffc2; border-bottom: solid 2px #8D6708;}
    .scheduled.error {color: #600000; background-color: #db5959; border-bottom: solid 2px #600000;}
</style>
