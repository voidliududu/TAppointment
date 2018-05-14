<template>
    <div>
        <mu-paper>
            <mu-row>
                <mu-col width="33">
                    <div id="me-avatar">
                        <mu-avatar slot="left" :src="userhead" :size="80"/>
                    </div>
                </mu-col>
                <mu-col width="66">
                    <div id="username">{{username}}</div>
                    <div id="userSchool">{{userSchool}}</div>
                </mu-col>
            </mu-row>
        </mu-paper>
        <mu-paper>
            <mu-flexbox>
                <!--flexbox无click事件-->
                <mu-flexbox-item class="score" >
                    <mu-raised-button  v-on:click="apclick" :label="apcount" icon="android" full-width>
                        <div>当前预约数</div>
                    </mu-raised-button>
                </mu-flexbox-item>
                <mu-flexbox-item class="score">
                    <mu-raised-button v-on:click="apHclick" :label="aphistorycount" icon="android" full-width>
                        <div>历史预约数</div>
                    </mu-raised-button>
                </mu-flexbox-item>
            </mu-flexbox>
        </mu-paper>
    </div>
</template>
<script>
    import MuFlexbox from "muse-ui/src/flexbox/flexbox";
    import MuFlexboxItem from "muse-ui/src/flexbox/flexboxItem";

    export default {
        name: "HeadInfo",
        components: {MuFlexboxItem, MuFlexbox},
        props: ['userhead', 'username', 'userSchool','apcount','aphistorycount'],
        data: function () {
            return {}
        },
        methods: {
            apclick: function () {
                this.$emit('apclick');
                console.log("click")
            },
            apHclick: function () {
                this.$emit('ap-h-click');
            }
        }
    }
</script>

<style scoped>
    #me-avatar{

    }
    #username{
        font-size: 30px;
    }
    #userSchool{
        font-size: 30px;
    }
    .score {
        width: 40%;
        margin: 0 auto;
    }
</style>