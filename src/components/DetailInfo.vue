<template>
    <div id="detail" v-html="rawHtml"></div>
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
                    this.rawHtml = res.body;
                }, res => {

                })
        }
    }
</script>

<style scoped>

</style>