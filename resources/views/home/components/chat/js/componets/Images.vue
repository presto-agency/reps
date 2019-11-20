<template>
   <!-- <transition name="fade">
        <div v-if="status" class="component_image">
            <b-card no-body>
                <b-tabs v-model="tabIndex" card>
                    <b-tab v-for="(imagesbycategory, key ) in images" :key ="`${key}`" :title="`${key}`" >
                        <div class="">
                            <img v-for="(image, index) in imagesbycategory" :key ="`image-${index}`"
                                 :src="`${image.filepath}`"
                                 :alt="`${image.charactor}`"
                                 :title="`${image.charactor}`" @click="selImage(image.charactor)">
                        </div>
                    </b-tab>
                </b-tabs>
            </b-card>
        </div>
    </transition>-->
</template>

<script>
    import * as chatHelper from "../helper/chatHelper";
    export default {
        name: "Images",
        props: ["status"],
        data() {
            return {
                tabIndex: 0,
                images: []
            }
        },
        methods: {
            // get_images() {
            //         axios.get('/get_externalimages').then((response) => {
            //             response.data.forEach((item,index)=> {
            //                 this.images.push({
            //                     src: item.src,
            //                     charactor: item.charactor
            //
            //                 })
            //             });
            //             if(response.data.length>0 )this.tabIndex = Object.keys(this.images)[0];
            //         })
            //     }

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
