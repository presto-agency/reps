<template>
    <transition name="fade">
        <div v-if="status" class="component_image">
            <div class="categories ">..
                <img class="close-images" src="/images/chat/icons/cancel.png" alt="close" @click="CloseImages">
                <p class="category__item" :class="{active: category.active}" v-for="(category,index) in all_images" @click="change_Category(index)">{{category.category}}</p>
            </div>
            <div class=" row images">
                <div class="image col-6" v-for="(image,index) in category_images.array" @click="selImage(image.charactor, index)">
                    <img
                            :src="image.filepath"
                            :alt="image.charactor"
                            :title="image.charactor"/>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
    import * as chatHelper from "../helper/chatHelper";
    import {bus} from "../chat";

    export default {
        name: "Images",
        props: ["status"],
        data() {
            return {
                current_category: '',
                all_images: [],
                category_images: {}
            }
        },
        created() {
            bus.$on('got-images',(obj)=>{
                this.all_images = obj.images;
                this.category_images = obj.category;
            })
        },
        methods: {
            change_Category(selected_index) {
                this.all_images.forEach((item) => {
                    item.active = false;
                });
                this.all_images[selected_index].active = true;
                this.category_images = this.all_images[selected_index];
            },
            selImage: function (title, index) {
                let str = title.replace(title, '%' + title + '%');
                this.$emit("insert_image", {'str': str, 'images': this.category_images.array[index]});

            },
            CloseImages() {
                this.$emit("turnOffStatus");
            }


        }
    }
</script>

<style lang="scss" scoped>
    .component_image {
        position: absolute;
        padding: 4px;
        bottom: 105px;
        width: 100%;
        max-height: 51vh;
        min-height: 51vh;
        background: white;
        overflow-y: auto;

        .categories {
            position: relative;
            padding: 10px 0;
            overflow-x: auto;
            display: flex;
            flex-wrap: wrap;
            .close-images {
                position: absolute;
                width: 16px;
                height: 16px;
                right: 1px;
                top: 1px;
                cursor: pointer;
            }
            .category__item {
                display: inline;
                cursor: pointer;
                margin-left: 10px;
                border-radius: 10px;
                padding: 4px 5px;
                box-shadow: 0 0 4px rgba(0, 0, 0, 0.5);
                background: #9fb4bf;
            }

            .active {
                color: #fff;
                background: linear-gradient(45deg, #487cb0, #1079e3);
            }
        }

        .images {
            border-top: 1px solid gray;
            margin: 0;
            max-height: 330px;
            overflow-y: auto;

            .image {
                cursor: pointer;
                margin-top: 5px;
                width: auto;
                padding: 2px;
                transition: all 0.2s;

                &:hover {
                    box-shadow: 0 0 4px rgba(0, 0, 0, 0.5);
                }
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
