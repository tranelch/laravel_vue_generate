<?php
$info_content = "<template>
  <div v-if=\"" . $text['camel']['singular'] . "\">
  <InfoModalLayout title=\"" . $text['spacedUpper']['singular'] . "\" @closeModal=\"\$emit('closeModal')\">
    <div class=\"grid grid-cols-1 lg:grid-cols-2 gap-4\">
$vue_info_line    </div>
  </InfoModalLayout>
  </div>
  <div v-else>
    No Information Found
  </div>
</template>

<script>
import InfoModalLayout from '@/Components/Layout/InfoModalLayout.vue'

export default {
  components: {
    InfoModalLayout
  },
  props: {
    " . $text['camel']['singular'] . ": {
      type: Object,
      required: true,
    },
    errors: {
      type: Object,
      default: () => ({}),
    }
  },
}
</script>";

if (!is_dir('generated/resources/js/Components/' . $text['camelUpper']['plural'])) {
    mkdir('generated/resources/js/Components/' . $text['camelUpper']['plural'], 0777, true);
}
$file = fopen('generated/resources/js/Components/' . $text['camelUpper']['plural'] . "/" . $text['camelUpper']['singular'] . 'Info.vue', "w");
fputs($file, $info_content);
fclose($file);
