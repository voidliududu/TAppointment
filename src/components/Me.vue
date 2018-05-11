<template>
    <div id="me">
        <head-info id="head" :userhead="uhead" :username="yb_username" :user-school="yb_schoolname"></head-info>
    </div>
</template>

<script>
    import HeadInfo from "./HeadInfo";
    export default {
        name: "Me",
        components: {HeadInfo},
        data: function () {
            return {
                'uhead':'./assets/logo.png',
                'yb_username':'刘都都',
                'yb_schoolname':'中南大学'
            }
        }
    }
</script>

<style scoped>
    #id{
        width: 100%;
    }
</style>