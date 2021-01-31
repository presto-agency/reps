<template>
    <transition name="fade">
        <div v-if="status" class="component_smiles">
            <img class="close-smiles" src="/images/chat/icons/cancel.png" alt="close" @click="CloseSmiles">
            <div class="smiles-list">
                <img class="smiles-list-item" v-for="(smile, index) in smiles" :key="`smile-${index}`"
                     :src="`storage/chat/smiles/${smile.src}`"
                     :alt="`${smile.charactor}`"
                     :title="`${smile.charactor}`" @click="selSmile(smile.charactor)">
            </div>
        </div>
    </transition>
</template>

<script>
    import {bus} from "../chat";

    export default {
        name: "Smiles",
        props: ['status', 'textareaId'],
        data() {
            return {
                smiles: []
            }
        },
        created() {
            bus.$on('got-smiles',(array)=>{
                this.smiles = array;
            })
        },
        methods: {
            selSmile: function (smile) {
                let str = smile.replace(smile, ';' + smile + ';');
                this.$emit("insert_smile", {'str': str, 'smlies': this.smiles});
            },
            CloseSmiles() {
                this.$emit("turnOffStatus");
            }
        }
    }
</script>

<style lang="scss" scoped>
    .component_smiles {
        position: absolute;
        bottom: 100px;
        padding: 4px;
        width: 100%;
        min-height: 40px;
        height: auto;
        background: white;
        box-shadow: 0 0 4px rgba(0, 0, 0, 0.5);
        z-index: 150;
        .close-smiles {
            position: absolute;
            width: 16px;
            height: 16px;
            right: 5px;
            top: 10px;
            cursor: pointer;
            }
        .smiles-list {
            max-width: 90%;
            .smiles-list-item {
                padding: 2px;
                cursor: pointer;

                &:hover {
                    background: #e6e6e6;
                }
            }
        }
    }

    .fade-enter, .fade-leave-to {
        opacity: 0;
        transform: translateY(-200px);
    }

    .fade-enter-active, .fade-leave-active {
        transition: all 0.5s;
    }
</style>
