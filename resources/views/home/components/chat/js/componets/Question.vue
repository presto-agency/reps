<template>
    <transition name="fade">
        <div class="component_question">
            <p>1a nice content place here  a nice content place here</p>
            <p>2a nice content place here  a nice content place here</p>
            <p>3a nice content place here  a nice content place here</p>
            <p>4a nice content place here  a nice content place here</p>
            <p>5a nice content place here  a nice content place here</p>
            <p>6a nice content place here  a nice content place here</p>
        </div>
    </transition>
</template>

<script>
    export default {
        name: "Question",
    }
</script>

<style lang="scss" scoped>
    .component_question {
        position: absolute;
        padding: 4px;
        bottom: 105px;
        width: 100%;
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
