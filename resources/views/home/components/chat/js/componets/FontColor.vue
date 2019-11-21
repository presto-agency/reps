<template>
    <div v-if="status" class="component_color">
        <div class="">
            <span v-for="(color, index) in colors" :key="`color-${index}`" @click="selColor(color)" :style="`background:${color.color}`">
              {{color.key}}
            </span>
        </div>
    </div>
</template>

<script>
    import $ from 'jquery'
    import * as chatHelper from '../helper/chatHelper';

    export default {
        name: "FontColor",
        props: ["status"],
        data() {
            return {
                colors: [
                    {'key': 'c1', 'color': '#FFFF77'},
                    {'key': 'c2', 'color': '#FF77FF'},
                    {'key': 'c3', 'color': '#77FFFF'},
                    {'key': 'c4', 'color': '#FFAAAA'},
                    {'key': 'c5', 'color': '#AAFFAA'},
                    {'key': 'c6', 'color': '#AAAAFF'},

                ],
                mystr: ''
            }
        },

        methods: {
            selColor(color) {
                let textareaObj = chatHelper.textareaObj();
                let sel = chatHelper.getSelection();
                let text;
                if (sel.length > 0) {
                    let newValue = textareaObj.value.replace(sel, '[' + color.key + ']' + sel + '[/' + color.key + ']');
                    text = textareaObj.value = newValue;
                } else {
                    chatHelper.insertText('[' + color.key + '][/' + color.key + ']');
                    text = textareaObj.value;
                }
                this.$emit("turnOffStatus");
                this.$emit("textarealistener", text);

            }
        }

    }
</script>

<style lang="scss" scoped>
    .component_color {
        position: absolute;
        bottom: 103px;
        left: 50%;
        transform: translateX(-50%);
        box-shadow: 0 0 4px rgba(0, 0, 0, 0.5);
        padding: 4px 0;
        width: 250px;
        max-height: 197px;
        height: auto;
        margin: 0 auto;
        overflow-y: hidden;
        background: white;

        div {
            margin: 4px;
            text-align: center;

            span {
                padding: 5px;
                cursor: pointer;
                border: solid 1px #e0dddd;
                margin: 2px;
                opacity: 0.7;
                transition: all 0.2s;

                &:hover {
                    opacity: 1;
                }
            }
        }
    }
</style>
