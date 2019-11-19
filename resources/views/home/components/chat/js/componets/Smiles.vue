<template>
    <transition name="fade">
    <div v-if="status" class="component_smiles">
        <div class="">
            <img v-for="(smile, index) in smiles" :key ="`smile-${index}`"
                 :src="`/images/${smile.src}`"
                 :alt="`${smile.charactor}`"
                 :title="`${smile.charactor}`" @click="selSmile(smile.charactor)">
        </div>
    </div>
    </transition>
</template>

<script>
    export default {
        name: "Smiles",
        props: ['status'],
        data() {
            return {
                smiles: []
            }
        },
        created: console.log('smile'),
        methods: {
            get_smiles() {
                axios.get('/chat/get_smiles').then((response) => {
                    response.data.forEach((item,index)=> {
                        this.smiles.push({
                            src: item.src,
                            charactor: item.charactor

                        })
                    })
                })
            }
        }
    }
</script>

<style lang="scss" scoped>
    .component_smiles{
        position: absolute;
        bottom: 100px;
        padding: 4px;
        width: 100%;
        min-height: 40px;
        height: auto;
        background: white;
        box-shadow: 0 0 4px rgba(0,0,0,0.5);
        z-index: 150;
        div {
            img {
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
