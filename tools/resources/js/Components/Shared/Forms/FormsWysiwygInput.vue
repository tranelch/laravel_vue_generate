<template>
    <div class="form-input-wrap">
        <quillEditor
            :id="id"
            v-bind="$attrs"
            :class="{ error: error }"
            class="form-input"
            :name="name"
            v-model:value="modelValue"
            @change="$emit('update:modelValue', modelValue)"
            :options="editorOptions"
            v-on:keydown.enter="$event.stopPropagation()"
        />
        <label v-if="label" :for="id" :class="required">
            {{ label }}
        </label>
        <div v-if="error" class="text-red-500">
            {{ error }}
        </div>
    </div>
</template>

<script>
import { reactive } from 'vue'
import { quillEditor, Quill } from 'vue3-quill'

var AlignStyle = Quill.import('attributors/style/align');
Quill.register(AlignStyle,true);
var SizeStyle = Quill.import('attributors/style/size');
Quill.register(SizeStyle,true);

export default {
    inheritAttrs: false,

    components: {
        quillEditor,
    },
    props: {
        id: String,
        modelValue: String,
        label: String,
        error: String,
        name: String,
        required: String,
        toolbar: {
            type: Array,
        }
    },
    setup (props) {
        //var AlignClass = Quill.import();
        //Quill.register(AlignClass,true);

        const editorOptions  = reactive({
            placeholder: 'Enter text here...',
            modules: {
                toolbar: props.toolbar ?? [
                    ['bold', 'italic', 'underline', 'strike'],
                    //['blockquote', 'code-block'],
                    [{ header: 1 }, { header: 2 }],
                    [{ list: 'ordered' }, { list: 'bullet' }],
                    //[{ script: 'sub' }, { script: 'super' }],
                    [{ indent: '-1' }, { indent: '+1' }],
                    //[{ direction: 'rtl' }],
                    [{ size: ['small', false, 'large', 'huge'] }],
                    //[{ header: [1, 2, 3, 4, 5, 6, false] }],
                    [{ color: [] }, { background: [] }],
                    //[{ font: [] }],
                    [{ align: [] }],
                    //['clean'],
                    //['link', 'image', 'video']
                ],
            // other moudle options here
            }
            // more options
        })

        return {editorOptions}
    }
    /*methods: {
        focus() {
            this.$refs.input.focus()
        },
        select() {
            this.$refs.input.select()
        },
    },*/
}
</script>