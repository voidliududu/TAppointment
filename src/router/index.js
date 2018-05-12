import Vue from 'vue'
import Router from 'vue-router'
import HelloWorld from '@/components/HelloWorld'
import Me from "@/components/Me"
import Login from "@/components/Login"

Vue.use(Router)

export default new Router({
    routes: [
        {
            path: '/',
            name: 'login',
            component: HelloWorld,
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
        }
    ]
})
