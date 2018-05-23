<template>
    <div id="detail" v-html=""></div>
</template>

<script>
    import {webroot,taapi} from "../gcommon";

    export default {
        name: "DetailInfo",
        props:["info"],
        data: function () {
            return {
                rawHtml:""
            }
        },
        created: function () {
            this.$http.get(webroot + taapi.getDetailInfo + "/" + this.info)
                .then(res => {
                    this.rawHtml = res.bodyText;
                    console.log(res.body)
                    console.log(res.bodyText);
                }, res => {

                })
        }
    }
</script>

<style scoped>

</style>