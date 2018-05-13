import Vue from 'vue'
import Router from 'vue-router'
import HelloWorld from '@/components/HelloWorld'
import Me from "@/components/Me"
import Login from "@/components/Login"
import ApInfo from "@/components/ApInfo"
import Appointment from "@/components/Appointment"
Vue.use(Router)

export default new Router({
    routes: [
        {
            path: '/apinfo/:aid',
            name: 'login',
            component: ApInfo,
            props: true
        },
        {
            path: '/me',
            name: 'Me',
            component: Me
        },
        {
            path: '/login/:user',
            name: 'improveinfo',
            component: Login,
            props:true
        },
        {
            path: '/appointment',
            name: 'appointment',
            component: Appointment,
        }
    ]
})
