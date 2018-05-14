<template>
    <div id="login">
        <mu-flexbox orient="vertical" justify="center">
            <mu-flexbox-item id="login-title">
                实名登记
            </mu-flexbox-item>
            <mu-flexbox-item id="headimg">
                <div>
                    <mu-avatar id="inner-headimg" :src="userhead"></mu-avatar>
                </div>
            </mu-flexbox-item>
            <mu-flexbox-item>
                <div id="greeting">
                    你好，{{username}}。请输入你的学号姓名完成登记
                </div>
                <br/>
            </mu-flexbox-item>
            <mu-flexbox-item>
                <mu-text-field hint-text="学号" v-model="schoolnumber"></mu-text-field>
            </mu-flexbox-item>
            <mu-flexbox-item>
                <mu-text-field hint-text="姓名" v-model="realname"></mu-text-field>
            </mu-flexbox-item>
            <mu-flexbox-item>
                <mu-flat-button label="确认" primary id="confirm" v-on:click="postData"></mu-flat-button>
            </mu-flexbox-item>
        </mu-flexbox>
        <mu-dialog :open="dialog" title="Dialog" @close="close">
            {{msg}}
            <mu-flat-button slot="actions" @click="close" primary label="取消"/>
            <mu-flat-button slot="actions" primary @click="close" label="确定"/>
        </mu-dialog>
    </div>
</template>

<script>
    import MuFlexbox from "muse-ui/src/flexbox/flexbox";
    import MuFlexboxItem from "muse-ui/src/flexbox/flexboxItem";
    import {webroot, taapi} from "../gcommon"

    export default {
        name: "Login",
        // props: ['user', 'userhead'],
        components: {MuFlexboxItem, MuFlexbox},
        data: function () {
            return {
                username: "",
                userhead: "",
                schoolnumber: '',
                realname: '',
                dialog: false,
                msg: '默认'
            }
        },
        methods: {
            postData: function () {
                var school_num = this.schoolnumber;
                var realname = this.realname;
                if (/\d{10}/.test(school_num) === false || realname.length === 0) {
                    this.msg = /d{10}/.test(school_num) + "" + realname.length
                    this.dialog = true;
                    return
                }
                this.$http.post(webroot + taapi.improveInfo,
                    {
                        schoolnumber: school_num,
                        name: realname
                    }).then(res => {
                    var result = res.body;
                    if (result.status === 0) {
                        this.msg = "成功";
                        this.dialog = true;
                    } else {
                        this.msg = "失败";
                    }
                }, res => {
                    this.msg = "网络繁忙";
                    this.dialog = true;
                })
            },
            close: function () {
                this.dialog = false
            },
            open: function () {
                this.dialog = true
            }
        },

        created: function () {
            this.$http.get(webroot + taapi.getUserInfo)
                .then(res => {
                        let result = res.body
                        if (result.status === 0) {
                            //成功
                            this.username = result.data.yb_username
                            this.userhead = result.data.yb_userhead
                        } else {
                            //获取失败时的默认信息
                            //todo
                        }
                    },
                    res => {
                        //网络错误的处理
                        //todo
                    })
        }
    }
</script>

<style scoped>
    #login {
        margin: 10px 10%;
        margin-top: 40px;
    }

    #login-title {
        width: auto;
        font-size: 20px;
    }

    #headimg {
        width: auto;
    }

    #inner-headimg {
        margin: 0 auto;
    }

    #greeting {
        font-size: 17px;
    }

    #confirm {
        width: 100%;
    }
</style>