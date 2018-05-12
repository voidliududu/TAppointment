<template>
    <div id="me">
        <head-info id="head"
                   :userhead="userdata.uhead"
                   :username="userdata.yb_username"
                   :user-school="userdata.yb_schoolname"
                   :apcount="userdata.apcount"
                   :aphistorycount="userdata.aphistorycount"
                   v-on:apclick="onapclick"
                   v-on:ap-h-click="onapHclick"></head-info>
        <mu-list>
            <mu-sub-header>{{aptitle}}</mu-sub-header>
            <mu-list-item v-for="item in listdata" :title="item.adate" describeText="">
                <mu-icon slot="left" value="home"/>
            </mu-list-item>
        </mu-list>
    </div>
</template>

<script>
    import HeadInfo from "./HeadInfo";
    import MuList from "muse-ui/src/list/list"
    import MuListItem from "muse-ui/src/list/listItem"
    import {webroot, taapi} from "../gcommon";

    export default {
        name: "Me",
        components: {HeadInfo, MuList},
        data: function () {
            return {
                aptitle: "当前预约",
                userdata: {
                    'uhead': './assets/logo.png',
                    'yb_username': '刘都都',
                    'yb_schoolname': '中南大学',
                    'apcount': 3,
                    'aphistorycount': 16
                },
                listdata: []
            }
        },
        methods: {
            onapclick: function () {
                //处理点击事件
                console.log("ap被点击")
                this.aptitle = "当前预约"
                this.$http.get(webroot + taapi.getApInfo)
                    .then(res => {
                        let result = res.body
                        if (result.status === 0) {
                            this.listdata = result.data
                        } else {

                        }
                    }, res => {

                    })
            },
            onapHclick: function () {
                //处理点击事件
                console.log("aph被点击")
                this.aptitle = "历史预约"
                this.$http.get(webroot + taapi.getHApInfo)
                    .then(res => {
                        let result = res.body
                        if (result.status === 0) {
                            this.listdata = result.data
                        } else {

                        }
                    }, res => {

                    })
            }
        }
        ,
        created: function () {
            this.$http.get(webroot + taapi.getUserInfo)
                .then(res => {
                        let result = res.body
                        if (result.status === 0) {
                            //成功
                            this.userdata.uhead = result.data.yb_userhead
                            this.userdata.apcount = result.data.apcount
                            this.userdata.aphistorycount = result.data.historyApcount
                            this.userdata.yb_schoolname = result.data.yb_schoolname
                            this.userdata.yb_username = result.data.yb_name
                        } else {
                            //获取失败时的默认信息
                        }
                    },
                    res => {
                        //网络错误的处理
                    })
            this.onapclick()
        }
    }
</script>

<style scoped>
    #id {
        width: 100%;
    }
</style>