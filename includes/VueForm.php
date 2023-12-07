<?php

$vue_form_content = "<template>
<FormLayout :secondaryNav=\"secondaryNav\">
  <form @submit.prevent=\"submitForm()\">
    <div class=\"grid grid-cols-1 lg:grid-cols-2 gap-4 mb-10\">
$vue_form_text    </div>
    <!-- submit -->
    <button id=\"submit-content\" type=\"submit\" :disabled=\"form.processing\" class=\"button-input btn-dark\">Save</button>
  </form>
</FormLayout>
</template>

<script>
import { ref, inject } from 'vue'
import { useForm } from '@inertiajs/vue3'
import ApiLookup from '@/Components/Shared/Forms/ApiLookup.vue'
import FormsSelectInput from '@/Components/Shared/Forms/FormsSelectInput.vue'
import FormsDateInput from '@/Components/Shared/Forms/FormsDateInput.vue'
import FormsDateTimeInput from '@/Components/Shared/Forms/DateTimeInput.vue'
import FormsTextInput from '@/Components/Shared/Forms/FormsTextInput.vue'
import FormsNumberInput from '@/Components/Shared/Forms/FormsNumberInput.vue'
import FormsToggleInput from '@/Components/Shared/Forms/FormsToggleInput.vue'
import FormsTextareaInput from '@/Components/Shared/Forms/FormsTextareaInput.vue'
import FormLayout from '@/Components/Layout/FormLayout.vue'

export default {
  components: {
    ApiLookup,
    FormsSelectInput,
    FormsDateInput,
    FormsDateTimeInput,
    FormsTextInput,
    FormsNumberInput,
    FormsToggleInput,
    FormsTextareaInput,
    FormLayout,
  },

  props: {
    post_url: {
      type: String,
      default: null,
    },
    put_url: {
      type: String,
      default: null,
    },
    " . $text['camel']['singular'] . ": {
      type: Object,
      required: true,
    },
    secondaryNav: {
      type: Object,
      default: () => ({}),
    },
    permissionBase: {
      type:String,
      required: true,
    },
    errors: {
      type: Object,
      default: () => ({}),
    }
  },
  setup (props, context) {
    const permissions = inject('permissions')

    const form = useForm({
$vue_form_definition    })


    const submitForm = () => {
      var submission = form
        .transform((data) => ({
        ...data,
      }))
      if(props.post_url) submission.post(props.post_url)
      if(props.put_url) submission.put(props.put_url)
    }

    return {
      permissions, form, submitForm,
    }
  },
}
</script>";

if (!is_dir('generated/resources/js/Components/' . $text['camelUpper']['plural'])) {
    mkdir('generated/resources/js/Components/' . $text['camelUpper']['plural'], 0777, true);
}
$file = fopen('generated/resources/js/Components/' . $text['camelUpper']['plural'] . "/" . $text['camelUpper']['singular'] . 'EditForm.vue', "w");
fputs($file, $vue_form_content);
fclose($file);

/****  EDIT PAGE **********************************************************/
$edit_page_content = "
<template>
  <AppLayout title=\"Edit " . $text['spacedUpper']['singular'] . "\">
    <" . $text['camelUpper']['singular'] . "EditForm :" . $text['camel']['singular'] . "=\"" . $text['camel']['singular'] . "\" :put_url=\"baseUrl + '/' + " . $text['camel']['singular'] . ".id\" :permissionBase=\"permissionBase\" :secondaryNav=\"secondaryNav\" :errors=\"errors\" />
  </AppLayout>
</template>

<script>
import { ref, inject } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { usePage } from '@inertiajs/vue3'
import " . $text['camelUpper']['singular'] . "EditForm from '@/Components/" . $text['camelUpper']['plural'] . "/" . $text['camelUpper']['singular'] . "EditForm.vue'

export default {
  components: {
    AppLayout,
    " . $text['camelUpper']['plural'] . "EditForm,
  },

  props: {
    " . $text['camel']['singular'] . ": {
      type: Object,
      required: true,
    },
    errors: {
      type: Object,
      default: () => ({}),
    },
  },

  setup (props) {
    const permissions = inject('permissions')
    const permissionBase = '{SECTION-camelSingular}'
    let urlPieces = usePage().url.value.split('/')
    const baseUrl = '/{SECTION-kabob}/" . $text['kabob']['plural'] . "/' + props." . $text['camel']['singular'] . ".id
    const secondaryNav = ref({
      links: [
        {href: baseUrl + '/edit', label: 'Profile'},
      ]
    })

    const previousPage = () => {
      history.back();
    }

    return { permissions, permissionBase, secondaryNav, previousPage, baseUrl, }
  },
}
</script>";

if (!is_dir('generated/resources/js/Pages/' . $text['camelUpper']['plural'])) {
    mkdir('generated/resources/js/Pages/' . $text['camelUpper']['plural'], 0777, true);
}
$file = fopen('generated/resources/js/Pages/' . $text['camelUpper']['plural'] . "/" . $text['camelUpper']['singular'] . 'Edit.vue', "w");
fputs($file, $edit_page_content);
fclose($file);

/****  CREATE PAGE **********************************************************/
$create_page_content = "
<template>
  <AppLayout title=\"Create " . $text['spacedUpper']['singular'] . "\">
    <" . $text['camelUpper']['singular'] . "EditForm :" . $text['camel']['singular'] . "=\"" . $text['camel']['singular'] . "\" :post_url=\"baseUrl\" :permissionBase=\"permissionBase\" :secondaryNav=\"secondaryNav\" :errors=\"errors\" />
  </AppLayout>
</template>

<script>
/* FIND AND REPLACE:
{SECTION-camelSingular} : permissionBase
{SECTION-kabob}/ : baseUrl
*/
import { ref, inject } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { usePage } from '@inertiajs/vue3'
import " . $text['camelUpper']['singular'] . "EditForm from '@/Components/" . $text['camelUpper']['plural'] . "/" . $text['camelUpper']['singular'] . "EditForm.vue'

export default {
  components: {
    AppLayout,
    " . $text['camelUpper']['plural'] . "EditForm,
  },

  props: {
    " . $text['camel']['singular'] . ": {
      type: Object,
      default: () => ({}),
    },
    errors: {
      type: Object,
      default: () => ({}),
    },
  },

  setup (props) {
    const permissions = inject('permissions')
    const permissionBase = '{SECTION-camelSingular}'
    const baseUrl = '/{SECTION-kabob}/" . $text['kabob']['plural'] . "'
    const secondaryNav = ref({
      links: [
        {href: baseUrl + '/edit', label: 'Profile'},
      ]
    })

    return { permissions, permissionBase, secondaryNav, baseUrl }
  },
}
</script>
";
if (!is_dir('generated/resources/js/Pages/' . $text['camelUpper']['plural'])) {
    mkdir('generated/resources/js/Pages/' . $text['camelUpper']['plural'], 0777, true);
}
$file = fopen('generated/resources/js/Pages/' . $text['camelUpper']['plural'] . "/" . $text['camelUpper']['singular'] . 'Create.vue', "w");
fputs($file, $create_page_content);
fclose($file);
