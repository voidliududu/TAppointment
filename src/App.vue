<template>
    <div id="app">
        <!--<img src="./assets/logo.png">-->
        <router-view/>
        <foot-nav id="footbar"/>
    </div>
</template>

<script>
    import FootNav from "./components/FootNav";
    import {webroot, taapi} from "./gcommon";

    export default {
        components: {FootNav},
        name: 'App',
        created: function () {
            this.$http.get(webroot + taapi.getUserInfo)
                .then(res => {
                        let result = res.body
                        if (result.status === 0) {
                            //成功
                            if (result.data.state == 1) {
                                this.$router.push("/login")
                            } else if (result.data.state == 0) {
                                this.$router.push("/me")
                            } else {
                                //todo error handler
                            }
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

<style>
    #app {
        font-family: 'Avenir', Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        color: #2c3e50;
        margin-bottom: 60px;
    }

    #footbar {
        position: fixed;
        bottom: 0;
        width: 100%;
    }
</style>
