<template>
    <div id="app" @contextmenu="triggerContextMenu">
        <div class="container">
            <div class="row text-monospace">
                <div class="col-xs-12 col-sm-12 col-lg-4 mb-sm-3">
                    <input-block
                            :msg="message"
                            @messageChanged="message = $event"/>
                </div>
                <div class="col-xs-6 col-sm-6 col-lg-4 position-static">
                    <matches
                            @fillInTextarea="message = $event"
                            :msg="message"/>
                </div>
                <div class="col-xs-6 col-sm-6 col-lg-4">
                    <messages
                            :messageID="messageID"/>
                </div>
            </div>
            <context style="position: absolute"
                     v-click-outside="onClickOutside"
                     :style="`left: ${contextPosX}px; top: ${contextPosY}px`"
                     v-show="showContextMenu"
                     :messageID="messageID"
                     @offContext="showContextMenu = $event"></context>
            <modal v-if="showModal"></modal>
        </div>
    </div>
</template>

<script>
    import bootstrap from 'bootstrap/dist/css/bootstrap.min.css';
    import vClickOutside from 'v-click-outside';

    import Input from './components/Input';
    import Messages from './components/Messages';
    import Matches from './components/Matches';
    import Context from './components/Context';
    import Modal from './components/Modal';

    export default {
        name: 'App',
        components: {
            'input-block': Input,
            Messages,
            Matches,
            Context,
            Modal,
        },
        directives: {
            clickOutside: vClickOutside.directive,
        },
        data() {
            return {
                message: '',
                showContextMenu: false,
                contextPosX: null,
                contextPosY: null,
                messageID: null,
                showModal: false,
            };
        },
        methods: {
            onClickOutside() {
                this.showContextMenu = false;
            },
            triggerContextMenu(e) {
                e.preventDefault();
                e.stopPropagation();
                if (e.target.dataset.id) {
                    this.messageID = e.target.dataset.id;
                    this.contextPosX = e.pageX;
                    this.contextPosY = e.pageY;
                    this.showContextMenu = true;
                } else {
                    this.messageID = null;
                    this.showContextMenu = false;
                }
            },
        },
        mounted() {
            this.$root.$on('showMeModal', () => {
                this.showModal = true;
                this.showContextMenu = false;
            });
        },
    };
</script>

<style lang="scss">
    #app {
        font-family: Monospaced, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        color: #2c3e50;
        margin-top: 60px;
    }
</style>
