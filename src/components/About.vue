<template>
    <div id="about">
        <mu-list>
            <mu-list-item title="网球场地预约制度">
                <mu-icon slot="left" value="forum"></mu-icon>
            </mu-list-item>
            <mu-divider/>
            <mu-list-item title="预约系统使用说明">
                <mu-icon slot="left" value="info"></mu-icon>
            </mu-list-item>
            <mu-divider/>
            <mu-list-item title="意见反馈">
                <mu-icon slot="left" value="feedback"></mu-icon>
            </mu-list-item>
            <mu-divider/>
            <mu-list-item title="版本说明">
                <mu-icon slot="left" value="copyright"></mu-icon>
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