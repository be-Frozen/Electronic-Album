import { createRouter, createWebHashHistory } from 'vue-router'
import Login from '../components/login/Login.vue'
import AdminHome from '../components/home/AdminHome.vue'
import UserHome from "../components/home/UserHome.vue";
import Order from '../components/order/Order.vue'
import Store from '../tools/Storage'
import Main from "../components/User/Main";
import Share from "../components/share/Share";
import Information from "@/components/User/information";
import userAdmin from "@/components/admin/userAdmin";
import albumAdmin from "@/components/admin/albumAdmin";
import photoAdmin from "@/components/admin/photoAdmin";
import shareAdmin from "@/components/admin/shareAdmin";
const Router = createRouter({
    history:createWebHashHistory('/'),
    //mode:"hash",
    //base: process.env.BASE_URL,
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
                    path:'user/order/:type',
                    component:Order,
                    name:"order"
                },
                {
                    path:'user/information',
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
                    path:'userAdmin/',
                    component:userAdmin,
                    name:"useradmin"
                },
                {
                    path:'albumadmin/:user',
                    component: albumAdmin,
                    name:"albumadmin"
                },
                {
                    path:'photoadmin/:user/:album',
                    component: photoAdmin,
                    name:"photoadmin"
                },
                {
                    path:'shareadmin',
                    component: shareAdmin,
                    name:"shareadmin"
                },
            ],
            redirect:'/adminhome/useradmin'
        },

    ]
})

Router.beforeEach((from) => {
    let isLogin = Store.getters.isLogin;
    if (isLogin || from.name == 'login') {
        return true;
    } else {
        console.log("back to login");
        return {name: 'login'}
    }
    
})

export default Router;