<template>
    <div id="appointment">
        <mu-date-picker
                v-model="dateinfo"
                format="YYYY-MM-DD"
                hint-text="请选择日期"
                @change="handlechange"></mu-date-picker>
        <mu-sub-header class="catetitle">空闲场地</mu-sub-header>
        <!--<mu-flexbox wrap="wrap" class="pgflow">-->
        <!--<mu-flexbox-item v-for="item in avaiablePg" >-->
        <!--<div class="playground">-->
        <!--<a>-->
        <!--<div>{{item.playground}}</div>-->
        <!--<div>{{item.timeslice}}</div>-->
        <!--</a>-->
        <!--</div>-->
        <!--</mu-flexbox-item>-->
        <!--</mu-flexbox>-->
        <!--flex布局失败，尝试列表布局-->
        <div v-for="(itemlist, index) in avaiablePg">
            <mu-sub-header>{{getTimeSlice(index)}}</mu-sub-header>
            <mu-list @itemClick="apclick">
                <mu-list-item class="listitem" v-for="item in itemlist" @click="apclick" :value="item.pgid"
                              :title="item.playground" :describe-text="item.timeslice">
                    <mu-icon slot="left" :value="StatusIcon(item.pgstate)" color="blue"/>
                </mu-list-item>
            </mu-list>
        </div>
        <mu-dialog :open="dialog" title="" @close="close">
            确定要预约该场地？
            <mu-flat-button slot="actions" @click="close" primary label="取消"/>
            <mu-flat-button slot="actions" primary @click="apcommit" label="确定"/>
        </mu-dialog>
        <mu-toast v-if="toast" :message="msg" @close="hideToast"/>
    </div>
</template>

<script>
    import MuFlexbox from "muse-ui/src/flexbox/flexbox";
    import MuFlexboxItem from "muse-ui/src/flexbox/flexboxItem";
    import MuList from "muse-ui/src/list/list";
    import MuListItem from "muse-ui/src/list/listItem";
    import {webroot, taapi, timesliceMap} from "../gcommon";

    export default {
        name: "Appointment",
        components: {MuListItem, MuList, MuFlexboxItem, MuFlexbox},
        data: function () {
            return {
                dateinfo: "",
                currentpgid: 0,
                dialog: false,
                toast: false,
                toastTimer: 0,
                msg: "",
                avaiablePg:[]
                // avaiablePg: [[{
                //     pgid: 1,
                //     playground: "test",
                //     timeslice: "test",
                //     pgstate: 0
                // }, {
                //     pgid: 1,
                //     playground: "test",
                //     timeslice: "test",
                //     pgstate: 0
                // }, {
                //     pgid: 1,
                //     playground: "test",
                //     timeslice: "test",
                //     pgstate: 0
                // }, {
                //     pgid: 1,
                //     playground: "test",
                //     timeslice: "test",
                //     pgstate: 0
                // },
                //
                // ],
                //     [
                //         {
                //             pgid: 1,
                //             playground: "test",
                //             timeslice: "test",
                //             pgstate: 0
                //         }, {
                //         pgid: 1,
                //         playground: "test",
                //         timeslice: "test",
                //         pgstate: 0
                //     }, {
                //         pgid: 1,
                //         playground: "test",
                //         timeslice: "test",
                //         pgstate: 0
                //     },
                //     ],
                //     [
                //         {
                //             pgid: 1,
                //             playground: "test",
                //             timeslice: "test",
                //             pgstate: 0
                //         }, {
                //         pgid: 1,
                //         playground: "test",
                //         timeslice: "test",
                //         pgstate: 0
                //     }, {
                //         pgid: 1,
                //         playground: "test",
                //         timeslice: "test",
                //         pgstate: 0
                //     },
                //     ],
                //     [
                //         {
                //             pgid: 1,
                //             playground: "test",
                //             timeslice: "test",
                //             pgstate: 0
                //         }, {
                //         pgid: 1,
                //         playground: "test",
                //         timeslice: "test",
                //         pgstate: 0
                //     }, {
                //         pgid: 1,
                //         playground: "test",
                //         timeslice: "test",
                //         pgstate: 0
                //     },
                //     ]],
            }
        },
        methods: {
            apclick: function (item) {
                this.currentpgid = item.value
                this.dialog = true
            },
            apcommit: function () {
                this.close()
                let cpgid = this.currentpgid
                let dinfo = this.dateinfo
                this.$http.post(webroot + taapi.appointment, {
                    pgid: cpgid,
                    date: dinfo
                }).then(res => {
                    let result = res.body
                    if (result.status === 0) {
                        this.msg = "预约成功"
                        this.showToast()
                    } else {
                        this.msg = result.msg
                        this.showToast()
                    }
                }, res => {
                    this.msg = "网络繁忙"
                    this.showToast()
                })
            },
            close() {
                this.dialog = false
            },
            showToast() {
                this.toast = true
                if (this.toastTimer) clearTimeout(this.toastTimer)
                this.toastTimer = setTimeout(() => {
                    this.toast = false
                }, 2000)
            },
            hideToast() {
                this.toast = false
                if (this.toastTimer) clearTimeout(this.toastTimer)
            },
            handlechange: function (value) {
                console.log(value)
                this.$http
                    .post(webroot + taapi.getAvaiable, {date: value})
                    .then(res => {
                        let result = res.body
                        if (result.status === 0) {
                            let resdata = result.data;
                            let tempdata = []
                            tempdata[0] = []
                            tempdata[1] = []
                            tempdata[2] = []
                            tempdata[3] = []
                            resdata.forEach(function (item) {
                                tempdata[item.timeslice].push({
                                    pgid: item.pgid,
                                    playground: item.pgname,
                                    timeslice: timesliceMap[item.timeslice],
                                    pgstate: item.pstate
                                })
                            })
                            this.avaiablePg = tempdata
                        } else {
                            this.avaiablePg = []
                        }
                    }, res => {
                        //网络错误
                    })
            },
            StatusIcon: function (state) {
                if (state == 0) {
                    return "event_available"
                } else {
                    return "event_busy"
                }
            },
            getTimeSlice: function (timeslice) {
                return timesliceMap[timeslice]
            }
        }
        // watch: {
        //     dateinfo: function (newdate, olddate) {
        //         console.log(newdate)
        //         console.log(olddate)
        //         this.$http
        //             .post(webroot + taapi.getAvaiable, {date: newdate})
        //             .then(res => {
        //                 let result = res.body
        //                 if (result.status === 0) {
        //                     resdata = result.data;
        //                     resdata.forEach(function (item) {
        //                         this.avaiablePg = []
        //                         this.avaiablePg.push({
        //                             playground: item.pgname,
        //                             timeslice: timesliceMap[item.timeslice],
        //                             pgstate: item.pstate
        //                         })
        //                     })
        //                 } else {
        //                     this.avaiablePg = []
        //                 }
        //             }, res => {
        //                 //网络错误
        //             })
        //     }
        // },
    }
</script>

<style scoped>
    /*.pgflow{*/
    /*width: 500px;*/
    /*}*/
    /*.playground{*/
    /*margin: 0 10px;*/
    /*background-color: #2196f3;*/
    /*width: 100px;*/
    /*height: 100px;*/
    /*}*/
    #appointment {
        margin-top: 20px;
        margin-right: 5%;
        margin-left: 5%;
        text-align: center;
    }
    .catetitle{
        text-align: left;
    }
    .listitem {
        text-align: left;
    }
</style>