<template>
   <transition name="fade">
        <div v-if="status" class="component_image">
            <div class="categories ">
                <p class="category__item" :class="{active: category.active}" v-for="(category,index) in all_images" @click="change_Category(index)">{{category.category}}</p>
            </div>
            <div class=" row images" >
                <div class="image col-6" v-for="(image,index) in category_images.array" @click="selImage(image.charactor, index)" >
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
            axios.get('chat/get_externalimages').then((response) => {
                let i=0;
                for( let key in response.data.images ) {
                    this.all_images.push({
                        category: key,
                        active: false,
                        array: Object.values(response.data.images)[i]
                    });
                    i++;
                }
                this.all_images[0].active= true;
                this.category_images = this.all_images[0];
            })
        },
        methods: {
            get_images() {
                    axios.get('/get_externalimages').then((response) => {
                        response.data.forEach((item,index)=> {
                            this.images.push({
                                src: item.src,
                                charactor: item.charactor
                            })
                        });
                        if(response.data.length>0 )this.tabIndex = Object.keys(this.images)[0];
                    })
                },
                change_Category(selected_index) {
                this.all_images.forEach((item)=>{
                    item.active = false;
                });
                    this.all_images[selected_index].active = true;
                    this.category_images = this.all_images[selected_index];
                },
            selImage: function(title,index){
                let str = title.replace(title,'%' + title + '%');
                this.$emit("insert_image", {'str':str,'images': this.category_images.array[index]});
                this.$emit("turnOffStatus");
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
    min-height: 400px;

    background: white;
    .categories {
        padding: 10px 0;
        overflow-x: auto;
        display: flex;
        flex-wrap: wrap;
        .category__item {
            display: inline;
            cursor: pointer;
            margin-left: 10px;
            border-radius: 10px;
            padding: 4px 5px;
            box-shadow: 0 0 4px rgba(0,0,0,0.5);
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
                box-shadow: 0 0 4px rgba(0,0,0,0.5);}
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
