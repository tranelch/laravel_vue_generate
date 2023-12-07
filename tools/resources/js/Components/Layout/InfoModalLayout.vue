
<template>
    <div class="info-wrap">
        <div class="flex flex-row justify-between">
            <h1>{{title}}</h1>
            <div>
                <i
                    class="fas fa-times cursor-pointer close"
                    @click="$emit('closeModal')"
                >
                </i>
            </div>
        </div>
        <hr class="my-3" />

        <slot />
    </div>
</template>

<script>
import { ref } from 'vue'

export default {
    components: {
    },

    props: {
        title: {
            type: String,
        },
    },

    setup(props) {
        return {}
    }
}
</script>