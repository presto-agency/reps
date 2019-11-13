<template>
    <div class="messanger">
        <div class="row_contentChat" v-for="item in messagearray" :key="item.message">
            <div class=" block_user_akk">
                <div class="user" >
                    <img class="icon_bars" :src="item.flag">
                    <img class="icon_bars" :src="item.ava"/>
                    <a href="#">
                        <span class="blue_text">Rus_Brain</span>
                        <span class="number_mess night_text">#3797</span>
                    </a>
                </div>
                <div class=" block_close">
                    <button>
                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times"
                             class="svg-inline--fa fa-times fa-w-11" role="img"
                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352 512">
                            <path fill="#bfc3ce"
                                  d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"></path>
                        </svg>
                    </button>
                </div>
                <div class=" block_date">
                    <span>{{item.date}}</span>
                </div>
            </div>
            <div class=" block_userMessage">
                <span class="user_nick">{{item.usernick}}</span>
                <span class="user_text night_text">{{item.message}}</span>
            </div>

        </div>
    </div> <!--main messenger-->
</template>
<script>
export default {
    props: ['messagearray']
}
</script>
