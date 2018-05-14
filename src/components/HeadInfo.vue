<template>
    <!--event_available
        event_busy
    -->
    <div>
        <!--<mu-paper>-->
            <!--<mu-row>-->
                <!--<mu-col width="33">-->
                    <!--<div id="me-avatar">-->
                        <!--<mu-avatar slot="left" :src="userhead" :size="80"/>-->
                    <!--</div>-->
                <!--</mu-col>-->
                <!--<mu-col width="66">-->
                    <!--<div id="username">{{username}}</div>-->
                    <!--<div id="userSchool">{{userSchool}}</div>-->
                <!--</mu-col>-->
            <!--</mu-row>-->
        <!--</mu-paper>-->
        <!--<mu-paper>-->
        <mu-list>
            <mu-list-item :title="username" :describe-text="userSchool" class="userinfo">
                <mu-avatar slot="left" :src="userhead"/>
            </mu-list-item>
        </mu-list>
            <mu-flexbox justify="space-between">
                <!--flexbox无click事件-->
                <mu-flexbox-item class="score" >
                    <mu-flat-button  v-on:click="apclick" :label="apcount" icon="whatshot">
                        <div>当前预约数:</div>
                    </mu-flat-button>
                </mu-flexbox-item>
                <mu-flexbox-item class="score">
                    <mu-flat-button v-on:click="apHclick" :label="aphistorycount" icon="history">
                        <div>历史预约数:</div>
                    </mu-flat-button>
                </mu-flexbox-item>
            </mu-flexbox>
        <!--</mu-paper>-->
    </div>
</template>
<script>
    import MuFlexbox from "muse-ui/src/flexbox/flexbox";
    import MuFlexboxItem from "muse-ui/src/flexbox/flexboxItem";
    import MuListItem from "muse-ui/src/list/listItem";

    export default {
        name: "HeadInfo",
        components: {MuListItem, MuFlexboxItem, MuFlexbox},
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
   .userinfo{
       text-align: left;
   }
    .score {
        width: auto;
        margin: 0 auto;
    }
</style>