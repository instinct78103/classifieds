<template>
    <div>
        <ul class="mb-0 border" style="min-height: 134px">
            <li v-for="(item, key) in showMatches" :data-code="item.code" :data-id="item.id" class="mb-3 mt-3"
                @dblclick="chooseLine">
                {{item.str}}
            </li>
        </ul>
    </div>
</template>
<script>
    import axios from 'axios';
    import Context from './Context';

    export default {
        name: 'Matches',
        props: ['msg'],
        components: {
            Context,
        },
        data() {
            return {
                info: null,
                matches: null,
                loaded: false,
                toApp: '',
                openContext: false,
                left: 0,
                top: 0,
                itemID: null,
            };
        },
        methods: {
            chooseLine(e) {
                e.preventDefault();
                e.stopPropagation();
                this.toApp = e.target.innerText;
                this.$emit('fillInTextarea', this.toApp);
            },
        },
        created() {
            axios
                .get('http://classifieds/api/')
                .then(resp => {
                    this.info = resp.data;
                    this.loaded = true;
                })
                .catch(err => console.warn(err));
        },
        computed: {
            showMatches() {
                if (this.loaded && this.msg) {

                    function quotemeta(str) {
                        return (str + '').replace(/([\.\\\+\*\?\[\^\]\$\(\)])/g, '\\$1');
                    }

                    const regex = new RegExp(quotemeta(this.msg), 'ui');

                    const arr = this.info
                        .map(item => Object.assign({'str': item.code + ' ' + item.message.replace('\r\n', '')}, item))
                        .filter(item => item.str.match(regex));

                    return arr;
                }
            },
            style() {
                return {
                    left: `${this.left}px`,
                    top: `${this.top}px`,
                };
            },
        },
    };
</script>

<style lang="scss" scoped>
    ul {
        list-style-type: none;
        padding: 6px 12px;
    }

    li {
        font-size: 12px;
        line-height: 1.2;
    }


</style>