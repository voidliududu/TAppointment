import Vue from 'vue'
import Router from 'vue-router'
import HelloWorld from '@/components/HelloWorld'
import Me from "@/components/Me"
import Login from "@/components/Login"
import ApInfo from "@/components/ApInfo"
import Appointment from "@/components/Appointment"
import About from "@/components/About"
Vue.use(Router)

export default new Router({
    routes: [
        {
            path: '/apinfo/:aid',
            name: 'apinfo',
            component: ApInfo,
            props: true
        },
        {
            path: '/me',
            name: 'Me',
            component: Me
        },
        {
            path: '/login',
            name: 'improveinfo',
            component: Login,
            props:true
        },
        {
            path: '/appointment',
            name: 'appointment',
            component: Appointment,
        },
        {
            path: '/about',
            name: 'about',
            component: About,
        }
    ]
})
