<template>
    <div id="about">
        <mu-list>
            <mu-list-item title="网球场地预约制度" to="/about/1">
                <mu-icon slot="left" value="forum" color="blue"></mu-icon>
            </mu-list-item>
            <mu-divider/>
            <mu-list-item title="预约系统使用说明" to="/about/2">
                <mu-icon slot="left" value="info" color="blue"></mu-icon>
            </mu-list-item>
            <mu-divider/>
            <mu-list-item title="意见反馈" to="/about/3">
                <mu-icon slot="left" value="feedback" color="blue"></mu-icon>
            </mu-list-item>
            <mu-divider/>
            <mu-list-item title="版本说明" to="/about/4">
                <mu-icon slot="left" value="copyright" color="blue"></mu-icon>
            </mu-list-item>
        </mu-list>
    </div>

</template>

<script>
    import MuList from "muse-ui/src/list/list";
    import MuListItem from "muse-ui/src/list/listItem";

    export default {
        name: "About",
        components: {MuListItem, MuList}
    }
</script>

<style scoped>
    #about {
        margin-top: 20px;
        margin-left: 5%;
        margin-right: 5%;

    }
</style>