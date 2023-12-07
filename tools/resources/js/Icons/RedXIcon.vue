<template>
  <svg :id="'redXIcon-' + location" class="svg system-icon" width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
    <title>X</title>
    <path class="svg-elem fill" d="M24.4583 2.95074L22.0495 0.541992L12.5 10.0916L2.95038 0.541992L0.541626 2.95074L10.0912 12.5003L0.541626 22.0499L2.95038 24.4587L12.5 14.9091L22.0495 24.4587L24.4583 22.0499L14.9087 12.5003L24.4583 2.95074Z" fill="#641115" />
    <path class="svg-elem fill" d="M24.4583 2.95074L22.0495 0.541992L12.5 10.0916L2.95038 0.541992L0.541626 2.95074L10.0912 12.5003L0.541626 22.0499L2.95038 24.4587L12.5 14.9091L22.0495 24.4587L24.4583 22.0499L14.9087 12.5003L24.4583 2.95074Z" fill="#641115" fill-opacity="0.25" />
  </svg>
</template>

<script>
    export default {
        props: {
            location: {
                type: String,
                required: true,
            }
        },
    }
</script>

<style scoped>
svg {
    display: inline-block;
}
</style>
