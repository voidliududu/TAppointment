<template>
    <div id="apinfo">
        <mu-flexbox orient="vertical" justify="center">
            <mu-flexbox-item class="myflex" id="stateicon">
                <div>
                    <mu-icon :value="getStatusIcon()" size="60" color="blue"></mu-icon>
                </div>
            </mu-flexbox-item>
            <mu-flexbox-item class="myflex" id="playground">
                {{playground}}
            </mu-flexbox-item>
            <mu-flexbox-item class="myflex" id="date">
                {{adate}}
            </mu-flexbox-item>
        </mu-flexbox>
        <mu-list>
            <mu-list-item title="申请人" :describe-text="name">
                <mu-icon slot="left" value="person" color="blue"></mu-icon>
            </mu-list-item>
            <mu-list-item title="学号" :describe-text="schoolnumber">
                <mu-icon slot="left" value="assignment" color="blue"></mu-icon>
            </mu-list-item>
            <mu-list-item title="验证码" :describe-text="token">
                <mu-icon slot="left" value="verified_user" color="blue"></mu-icon>
            </mu-list-item>
            <mu-list-item title="申请时间" :describe-text="getSignTime">
                <mu-icon slot="left" value="date_range" color="blue"></mu-icon>
            </mu-list-item>
            <mu-list-item title="状态" :describe-text="getState">
                <mu-icon slot="left" value="code" color="blue"></mu-icon>
            </mu-list-item>
        </mu-list>
    </div>
</template>

<script>
    import MuFlexbox from "muse-ui/src/flexbox/flexbox";
    import MuFlexboxItem from "muse-ui/src/flexbox/flexboxItem";
    import MuList from "muse-ui/src/list/list";
    import MuListItem from "muse-ui/src/list/listItem";
    import {webroot, taapi} from "../gcommon";

    export default {
        name: "ApInfo",
        components: {MuListItem, MuList, MuFlexboxItem, MuFlexbox},
        props: ["aid"],
        msg: "",
        data: function () {
            return {
                playground: "xxx",
                adate: "xxxx-xx-xx",
                name: "xxx",
                schoolnumber: "xxxxxxxxxx",
                token: "xxxxxxx",
                signtime: "xxxxxx",
                astate: 0
            }
        },
        methods: {
            getStatusIcon: function () {
                // let state2icon = ["sentiment_very_satisfied", "sentiment_very_dissatisfied"]
                let state2icon = ["check_circle", "sentiment_very_dissatisfied"]
                return state2icon[this.astate]
            }
        //     withdrawAp() {
        //         this.$http
        //             .post(webroot + taapi.withdrawAp,{aid: this.aid})
        //             .then(res => {
        //                 let result = res.body
        //                 if (result.status === 0) {
        //                     this.msg = "取消成功"
        //                     this.showToast()
        //                     this.$router.push("/me")
        //                 }else{
        //                     this.msg = "取消失败"
        //                     this.showToast()
        //                 }
        //             }, res => {
        //
        //             })
        //     },
        //     showToast() {
        //         this.toast = true
        //         if (this.toastTimer) clearTimeout(this.toastTimer)
        //         this.toastTimer = setTimeout(() => {
        //             this.toast = false
        //         }, 2000)
        //     },
        //     hideToast() {
        //         this.toast = false
        //         if (this.toastTimer) clearTimeout(this.toastTimer)
        //     },
        },
        created: function () {
            //fixme aid 判空
            this.$http.post(webroot + taapi.getApInfo, {aid: this.aid})
                .then(function (res) {
                    let result = res.body;
                    if (result.status == 0) {
                        //处理数据映射
                        this.aid = result.data.aid
                        this.playground = result.data.playground
                        this.adate = result.data.adate
                        this.name = result.data.name
                        this.token = result.data.token
                        this.schoolnumber = result.data.schoolnumber
                        this.signtime = result.data.signtime
                        this.astate = result.data.astate

                    } else {
                        //错误处理
                    }
                }, res => {
                    //网络错误处理
                })
        },
        computed: {
            getState: function () {
                let statecode = ["可用", "不可用"]
                return statecode[this.astate]
            },
            getSignTime: function () {
                return this.signtime
            }
        }
    }
</script>

<style scoped>
    #apinfo{
        margin-top : 80px;
        margin-left: 5%;
        margin-right: 5%;
    }
    .myflex {
        width: auto;
    }
    #stateicon{
        width:auto;
    }
    #playground{
        width: auto;
    }
    #date{
        width: auto;
    }
</style>