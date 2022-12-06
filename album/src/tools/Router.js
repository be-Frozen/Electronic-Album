import { createRouter, createWebHashHistory } from 'vue-router'
import Login from '../components/login/Login.vue'
import AdminHome from '../components/home/AdminHome.vue'
import UserHome from "../components/home/UserHome.vue";
import Order from '../components/order/Order.vue'
import Store from '../tools/Storage'
import Main from "../components/User/Main";
import Share from "../components/share/Share";
import Information from "@/components/User/information";

const Router = createRouter({
    history:createWebHashHistory(),
    routes:[
        {
            path:'/login',
            component:Login,
            name:"login"
        },
        {
            path:'/userhome',
            component:UserHome,
            name:"userhome",
            children:[
                {
                    path:'user/main',
                    component: Main,
                    name:"Main"
                },
                {
                    path:'user/share',
                    component:Share,
                    name:"Share"
                },
                {
                    path:'user/order/:type',// 0是普通订单 1是秒杀订单,
                    component:Order,
                    name:"order"
                },
                {
                    path:'user/information',// 0是普通订单 1是秒杀订单,
                    component:Information,
                    name:"information"
                },
            ],
            redirect:'/userhome/user/main'
        },
        {
            path:'/adminhome',
            component:AdminHome,
            name:"adminhome",
            children:[
                {
                    path:'order/:type',// 0是普通订单 1是秒杀订单,
                    component:Order,
                    name:"Order"
                },
            ],
            redirect:'/adminhome/order/0'
        },

    ]
})

Router.beforeEach((from) => {
    let isLogin = Store.getters.isLogin;
    if (isLogin || from.name == 'login') {
        return true;
    } else {
        return {name: 'login'}
    }
    
})

export default Router;