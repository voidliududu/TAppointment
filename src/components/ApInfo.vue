<template>
    <div id="apinfo">
        <mu-flexbox orient="vertical" justify="center">
            <mu-flexbox-item class="flex-item" id="stateicon">
                <mu-icon value="home"></mu-icon>
            </mu-flexbox-item>
            <mu-flexbox-item class="flex-item" id="playground">
                {{playground}}号球场
            </mu-flexbox-item>
            <mu-flexbox-item class="flex-item" id="date">
                {{adate}}
            </mu-flexbox-item>
        </mu-flexbox>
        <mu-list>
            <mu-list-item title="申请人" :describe-text="name"></mu-list-item>
            <mu-list-item title="学号" :describe-text="schoolnumber"></mu-list-item>
            <mu-list-item title="验证码" :describe-text="token"></mu-list-item>
            <mu-list-item title="申请时间" :describe-text="getSignTime"></mu-list-item>
            <mu-list-item title="状态" :describe-text="getState"></mu-list-item>
        </mu-list>
    </div>
</template>

<script>
    import MuFlexbox from "muse-ui/src/flexbox/flexbox";
    import MuFlexboxItem from "muse-ui/src/flexbox/flexboxItem";
    import MuList from "muse-ui/src/list/list";
    import MuListItem from "muse-ui/src/list/listItem";
    import {webroot,taapi} from "../gcommon";

    export default {
        name: "ApInfo",
        components: {MuListItem, MuList, MuFlexboxItem, MuFlexbox},
        props:["aid"],
        data:function () {
            return {
                playground:"3",
                adate:"2018-02-03",
                name:"刘都都",
                schoolnumber:"0902160201",
                token:"dxejo2374",
                signtime:"2018-01-2 11:11:11",
                astate:"0"
            }
        },
        methods: {

        },
        created: function(){
            //fixme aid 判空
            this.$http.post(webroot + taapi.getApInfo,  {aid:this.aid})
                .then(res => {
                    let result = res.body;
                    if (result.status == 0) {
                        //处理数据映射
                        this.data = result.data

                    }else{
                        //错误处理
                    }
                }, res => {
                    //网络错误处理
                })
        },
        computed: {
            getState: function() {
                let statecode = ["可用","不可用"]
                return statecode[this.astate]
            },
            getSignTime: function () {
                return this.signtime
            }
        }
    }
</script>

<style scoped>
    .flex-item{
        width: auto;
    }
</style>