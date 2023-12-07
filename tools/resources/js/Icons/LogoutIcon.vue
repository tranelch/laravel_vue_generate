<template>
  <svg :id="'logoutIcon-' + location" class="svg system-icon" width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
    <title>Logout</title>
    <path class="svg-elem fill" d="M10.09 15.59L11.5 17L16.5 12L11.5 7L10.09 8.41L12.67 11H3V13H12.67L10.09 15.59ZM19 3H5C3.89 3 3 3.9 3 5V9H5V5H19V19H5V15H3V19C3 20.1 3.89 21 5 21H19C20.1 21 21 20.1 21 19V5C21 3.9 20.1 3 19 3Z" fill="#666666" />
    <path class="svg-elem fill" d="M10.09 15.59L11.5 17L16.5 12L11.5 7L10.09 8.41L12.67 11H3V13H12.67L10.09 15.59ZM19 3H5C3.89 3 3 3.9 3 5V9H5V5H19V19H5V15H3V19C3 20.1 3.89 21 5 21H19C20.1 21 21 20.1 21 19V5C21 3.9 20.1 3 19 3Z" fill="#666666" fill-opacity="0.5" />
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
