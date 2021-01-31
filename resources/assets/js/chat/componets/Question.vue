<template>
    <transition name="fade">
        <div class="component_question">
            <p v-html="helper_text"></p>
        </div>
    </transition>
</template>

<script>
    import {bus} from "../chat";
    export default {
        name: "Question",
        data() {
            return {
                helper_text: ''
            }
        },
        created() {
            bus.$on('got-helper', (text)=> {
                this.helper_text = text;
            })
        }
    }
</script>

<style lang="scss" scoped>
    .component_question {
        position: absolute;
        padding: 4px;
        bottom: 105px;
        width: 100%;
        border: 1px solid #ccc;
        max-height: 51vh;
        min-height: 51vh;
        background: white;
        overflow-y: auto;
    }
    .fade-enter, .fade-leave-to {
        opacity: 0;
        transform: translateY(-300px);
    }

    .fade-enter-active, .fade-leave-active {
        transition: all 0.5s;
    }
</style>
