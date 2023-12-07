<template>
  <svg :id="'notificationIcon-' + location" class="svg system-icon" width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
    <title>Notifications</title>
    <g class="svg-elem" clip-path="url(#clip0_1060_17038)">
      <path class="svg-elem stroke" d="M18.5749 8.2555C18.5749 6.61338 17.9226 5.03852 16.7614 3.87736C15.6003 2.7162 14.0254 2.06387 12.3833 2.06387C10.7411 2.06387 9.16628 2.7162 8.00513 3.87736C6.84397 5.03852 6.19164 6.61338 6.19164 8.2555C6.19164 15.4791 3.09583 17.5429 3.09583 17.5429H21.6707C21.6707 17.5429 18.5749 15.4791 18.5749 8.2555Z" stroke="#666666" stroke-width="2.06388" stroke-linecap="round" stroke-linejoin="round" />
      <path class="svg-elem stroke" d="M18.5749 8.2555C18.5749 6.61338 17.9226 5.03852 16.7614 3.87736C15.6003 2.7162 14.0254 2.06387 12.3833 2.06387C10.7411 2.06387 9.16628 2.7162 8.00513 3.87736C6.84397 5.03852 6.19164 6.61338 6.19164 8.2555C6.19164 15.4791 3.09583 17.5429 3.09583 17.5429H21.6707C21.6707 17.5429 18.5749 15.4791 18.5749 8.2555Z" stroke="#666666" stroke-opacity="0.5" stroke-width="2.06388" stroke-linecap="round" stroke-linejoin="round" />
      <path class="svg-elem stroke" d="M14.1685 21.6707C13.987 21.9835 13.7266 22.2431 13.4133 22.4235C13.1 22.604 12.7448 22.699 12.3832 22.699C12.0216 22.699 11.6664 22.604 11.3531 22.4235C11.0398 22.2431 10.7794 21.9835 10.598 21.6707" stroke="#666666" stroke-width="2.06388" stroke-linecap="round" stroke-linejoin="round" />
      <path class="svg-elem stroke" d="M14.1685 21.6707C13.987 21.9835 13.7266 22.2431 13.4133 22.4235C13.1 22.604 12.7448 22.699 12.3832 22.699C12.0216 22.699 11.6664 22.604 11.3531 22.4235C11.0398 22.2431 10.7794 21.9835 10.598 21.6707" stroke="#666666" stroke-opacity="0.5" stroke-width="2.06388" stroke-linecap="round" stroke-linejoin="round" />
    </g>
    <defs>
      <clipPath id="clip0_1060_17038" class="svg-elem stroke">
        <rect class="svg-elem stroke" width="24.7665" height="24.7665" fill="#666666" />
      </clipPath>
    </defs>
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
