<template>
  <svg :id="'rightIcon-' + location" class="svg" width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
    <title>Arrow Right</title>
    <rect width="25" height="25" fill="#F6F8FA" />
    <path d="M8.94794 17.0208L13.7188 12.2396L8.94794 7.45834L10.4167 5.98959L16.6667 12.2396L10.4167 18.4896L8.94794 17.0208Z" fill="#C2C9D1" />
    <path d="M8.94794 17.0208L13.7188 12.2396L8.94794 7.45834L10.4167 5.98959L16.6667 12.2396L10.4167 18.4896L8.94794 17.0208Z" fill="black" fill-opacity="0.25" />
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
