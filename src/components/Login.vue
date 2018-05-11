<template>
    <div id="login">
        <mu-flexbox orient="vertical" justify="center">
            <mu-flexbox-item id="login-title">
                实名登记
            </mu-flexbox-item>
            <mu-flexbox-item id="headimg">
                <div >
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
                <mu-flat-button label="确认" primary="true" id="confirm" v-on:click=""></mu-flat-button>
            </mu-flexbox-item>
        </mu-flexbox>
    </div>
</template>

<script>
    import MuFlexbox from "muse-ui/src/flexbox/flexbox";
    import MuFlexboxItem from "muse-ui/src/flexbox/flexboxItem";
    export default {
        name: "Login",
        components: {MuFlexboxItem, MuFlexbox},
        data: function () {
            return {
                username:"xxx",
                userhead:'',
                schoolnumber:'',
                realname:''
            }
        },
        methods:{
            postData: function () {
                this.$http.post()
            }
        }

    }
</script>

<style scoped>
    #login{
        margin:10px 10%;
    }
    #login-title{
        width:auto;
        font-size: 20px;
    }
    #headimg{
        width:auto;
    }
    #inner-headimg{
        margin:0 auto;
    }
    #greeting{
        font-size: 17px;
    }
    #confirm{
        width:100%;
    }
</style>