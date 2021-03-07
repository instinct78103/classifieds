<template>
    <div class="context" tabindex="0" ref="context">
        <ul class="dropdown" role="menu" aria-labelledby="dropdownMenu">
            <li><a href="#"
                   @click="clickToEdit">Редактировать</a></li>
            <li><a href="#"
                   @click="clickToRemove"><span class="fa fa-trash"></span>Удалить</a></li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: 'Context',
        props: ['messageID'],
        methods: {
            clickToEdit() {
                this.$emit('offContext', false);
                console.log(`Editing: ${this.messageID}`);
                //this.$root.$emit('showMeModal', true);
            },
            clickToRemove() {
                this.$emit('offContext', false);
                console.log(`Message ${this.messageID} has been removed!`);
            },
        },
    };
</script>

<style lang="scss" scoped>
    .context {
        background: #fff;
        z-index: 1000;

        ul.dropdown {
            display: flex;
            flex-direction: column;
            padding-left: 0;
            margin-bottom: 0;
            box-shadow: 0 3px 5px rgba(0, 0, 0, 0.2);
            list-style: none;

            li {
                text-transform: uppercase;

                a {
                    color: #42b983;
                    padding: 6px 12px;
                }

                &:hover {

                    background: #42b983;

                    a {
                        color: #fff;
                        text-decoration: none;
                    }
                }
            }
        }
    }
</style>