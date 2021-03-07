<template>
    <div class="form-group mb-0">
        <textarea autofocus class="form-control" name="" id="" rows="5"
                  :value="msg"
                  @input="changeMessage"
                  @keyup.enter="submit"
                  @keydown.enter.prevent></textarea>
    </div>
</template>

<script>
    export default {
        props: ['msg'],
        name: 'Input',
        data() {
            return {
                text: ''
            }
        },
        methods: {
            changeMessage(e) {
                this.text = e.target.value;
                this.$emit('messageChanged', this.text)
            },
            submit(e) {
                e.preventDefault();
                e.stopPropagation();
                if(e.target.value !== ''){
                    console.log(parseInt(e.target.value, 10));
                }
            }
        }
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
    h3 {
        margin: 40px 0 0;
    }

    ul {
        list-style-type: none;
        padding: 0;
    }

    li {
        display: inline-block;
        margin: 0 10px;
    }

    a {
        color: #42b983;
    }
</style>
