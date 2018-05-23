<!--
issue
    1. todo所示内容
    2. apcount 的问题
    3. 修复按钮的外观
-->

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
        <div id="meinfo">
        <mu-sub-header>{{aptitle}}</mu-sub-header>
        <mu-list @itemClick="handleItemClick">
            <mu-list-item v-for="item in listdata" :value="item.aid" :title="item.adate"
                          :describeText="printTimeslice(item.timeslice)" class="listitem">
                <mu-icon slot="left" value="event_available" color="blue"/>
                <mu-icon value="delete" slot="right" @click.stop="deleteAp(item.aid)" color="blue" v-if="isHistory"/>
                <!--<mu-icon-button class="test" icon="android"/>-->
                <!--<mu-icon-menu slot="right" icon="delete" @open.stop="test"></mu-icon-menu>-->
            </mu-list-item>
        </mu-list>
        <mu-toast v-if="toast" :message="msg" @close="hideToast"/>
        <mu-dialog :open="dialog" title="" @close="close">
            {{dialogmsg}}
            <mu-flat-button slot="actions" @click="close" primary label="否"/>
            <mu-flat-button slot="actions" primary @click="dodelete" label="是"/>
        </mu-dialog>
        </div>
    </div>
</template>

<script>
    import HeadInfo from "./HeadInfo";
    import MuList from "muse-ui/src/list/list"
    import MuListItem from "muse-ui/src/list/listItem"
    import {webroot, taapi, timesliceMap} from "../gcommon";

    export default {
        name: "Me",
        components: {HeadInfo, MuList},
        data: function () {
            return {
                dialog: false,
                toast: false,
                msg: "",
                dialogmsg: "是否删除该预约",
                aptitle: "当前预约",
                deleteAid: -1,
                isHistory: true,
                userdata: {
                    'uhead': '',
                    'yb_username': 'xxx',
                    'yb_schoolname': 'xxxx',
                    'apcount': 0,
                    'aphistorycount': 0
                },
                // listdata: [{
                //     aid: 1,
                //     adate: "xxxx-xx-xx",
                //     timeslice: 1
                // }, {
                //     aid: 1,
                //     adate: "xxxx-xx-xx",
                //     timeslice: 1
                // }, {
                //     aid: 1,
                //     adate: "xxxx-xx-xx",
                //     timeslice: 1
                // }]
                listdata:[]
            }
        },
        methods: {
            close: function () {
                this.dialog = false
            },
            open: function () {
                this.dialog = true
            },
            deleteAp: function (aid) {
                this.deleteAid = aid
                this.open()
            },
            dodelete: function () {
                this.close()
                this.$http
                    .post(webroot + taapi.withdrawAp, {aid: this.deleteAid})
                    .then(res => {
                        let result = res.body
                        if (result.status === 0) {
                            this.msg = "取消成功"
                            this.showToast()
                            this.onapclick()
                        } else {
                            this.msg = "取消失败"
                            this.showToast()
                        }
                    }, res => {

                    })
            },
            showToast() {
                this.toast = true
                if (this.toastTimer) clearTimeout(this.toastTimer)
                this.toastTimer = setTimeout(() => {
                    this.toast = false
                }, 2000)
            },
            hideToast() {
                this.toast = false
                if (this.toastTimer) clearTimeout(this.toastTimer)
            },
            onapclick: function () {
                //处理点击事件
                // console.log("ap被点击")
                this.aptitle = "当前预约"
                this.$http.get(webroot + taapi.getApList)
                    .then(res => {
                        let result = res.body
                        if (result.status === 0) {
                            this.listdata = result.data
                        } else {
                            this.listdata = []
                        }
                        this.isHistory = true;
                    }, res => {

                    })
            },
            onapHclick: function () {
                //处理点击事件
                // console.log("aph被点击")
                this.aptitle = "历史预约"
                this.$http.get(webroot + taapi.getHApList)
                    .then(res => {
                        let result = res.body
                        if (result.status === 0) {
                            this.listdata = result.data
                        } else {
                            //todo
                            this.listdata = []
                        }
                        this.isHistory = false
                    }, res => {

                    })
            },
            handleItemClick: function (item) {
                let aid = item.value
                this.$router.push('/apinfo/' + aid)
            },
            printTimeslice: function (timeslice) {
                return timesliceMap[timeslice]
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
                            this.userdata.aphistorycount = result.data.history_apcount
                            this.userdata.yb_schoolname = result.data.yb_schoolname
                            this.userdata.yb_username = result.data.yb_name
                        } else {
                            //获取失败时的默认信息
                            //todo 置list为空
                        }
                    },
                    res => {
                        //网络错误的处理
                        //todo
                    })
            this.onapclick()
        }
    }
</script>

<style scoped>
    #meinfo {
        margin-top: 20px;
        margin-left: 5%;
        margin-right: 5%;
        /*background-color: #e6e6e6;*/
    }

    .listitem {
        text-align: left;
        background-color: white;
    }

</style>