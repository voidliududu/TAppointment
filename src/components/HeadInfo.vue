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
        <!--<mu-list>-->
            <!--<mu-list-item :title="username" :describe-text="userSchool" class="userinfo">-->
                <!--<mu-avatar slot="left" :src="userhead"/>-->
            <!--</mu-list-item>-->
        <!--</mu-list>-->
        <mu-flexbox orient="vertical" justify="center" class="hdinfo">
            <mu-avatar :src="userhead" size="78"/>
            <mu-flexbox class="hiuser">{{username}}</mu-flexbox>
            <mu-flexbox class="hiuser">{{userSchool}}</mu-flexbox>
        </mu-flexbox>
        <mu-flexbox class="hdbutton" justify="space-between">
            <!--flexbox无click事件-->
            <mu-flexbox-item class="score">
                <mu-flat-button v-on:click="apclick" :label="apcount" icon="whatshot" :color="apclickcolor">
                    <div>当前预约数:</div>
                </mu-flat-button>
            </mu-flexbox-item>
            <mu-flexbox-item class="score">
                <mu-flat-button v-on:click="apHclick" :label="aphistorycount" icon="history" :color="apHclickcolor">
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
        props: ['userhead', 'username', 'userSchool', 'apcount', 'aphistorycount'],
        data: function () {
            return {
                apclickcolor: "blue",
                apHclickcolor: ""
            }
        },
        methods: {
            apclick: function () {
                this.apclickcolor = "blue"
                this.apHclickcolor = "";
                this.$emit('apclick');
            },
            apHclick: function () {
                this.apHclickcolor = "blue"
                this.apclickcolor = "";
                this.$emit('ap-h-click');
            }
        }
    }
</script>

<style scoped>
    .userinfo {
        text-align: left;
    }
    .hdinfo{
        min-height: 250px;
        background-color: #2196f3;
    }
    .hdbutton{
        margin-top: 20px;
        margin-left: 5%;
        margin-right: 5%;
    }
    .hiuser{
        color: white;
        font-size: 15px;
        width: auto;
    }
    .score {
        width: auto;
        margin: 0 auto;
    }
</style>