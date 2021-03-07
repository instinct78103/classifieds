<template>
    <div class="modal-menu">
        <div class="modal-content"></div>
    </div>
</template>

<script>
    export default {
        name: 'Modal',
    };
</script>

<style lang="scss" scoped>
    .modal-menu{
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #2c3e50;
        opacity: 0.7;
        z-index: 1050;
    }

    .modal-content{
        width: 150px;
        height: 100px;
        background: white;
        margin: auto;
    }
</style>