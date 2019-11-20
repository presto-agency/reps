<template>
    <transition name="fade">
    <div v-if="status" class="component_image">
            <img v-for="(image, index) in images" :key ="`image-${index}`"
                 :src="`${image.src}`"
                 :alt="`${image.charactor}`"
                 :title="`${image.charactor}`" @click="selImage(image.charactor)">
        </div>
    </transition>
</template>

<script>
    import * as chatHelper from "../helper/chatHelper";
    export default {
        name: "Images",
        props: ["status"],
        data() {
            return {
                images: []
            }
        },
        methods: {
            get_images() {
                axios.get('/chat/get_images').then((response) => {
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
.component_image {
    position: absolute;
    bottom: 100px;
    padding: 4px;
    width: 100%;
    height: 400px;
    max-height: 400px;
    overflow-y: auto;
    background: white;
    img {
        max-width: 75px;
        padding: 3px;
        cursor: pointer;
        &:hover {
            background: #e6e6e6;
        }
    }
}
.fade-enter, .fade-leave-to {
    opacity: 0;
    transform: translateY(-300px);
}
.fade-enter-active, .fade-leave-active {
    transition: all 0.5s;
}
</style>
