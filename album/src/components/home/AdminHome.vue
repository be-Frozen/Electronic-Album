<template>
    <el-container id="container">
        <el-aside width="250px">
            <el-container id="top">
                <img style="width:25px;height:25px;border-radius:50%;margin:auto;margin-right:0;"
                     src="~@/assets/logo.jpg"/>

                <div style="margin:auto;margin-left:10px;color:#ffffff;font-size:17px">
                    响当当相册后台管理
                </div>
            </el-container>
            <el-menu
                :default-active="$route.path"
                style="border: none; height:100%"
                background-color="transparent"
                text-color="#fff"
                active-text-color="#ffd04b"
                @select="selectItem">
                <el-menu-item index="/adminhome/useradmin">用户管理</el-menu-item>
                <el-menu-item :disabled="this.$store.state.albumflag" :index="'/adminhome/albumadmin/'+this.$store.state.name">相册管理</el-menu-item>
                <el-menu-item :disabled="this.$store.state.photoflag" :index="'/adminhome/photoadmin/'+this.$store.state.name+'/'+this.$store.state.album">照片管理</el-menu-item>
                <el-menu-item index="/adminhome/shareadmin">朋友圈管理</el-menu-item>
            </el-menu>
        </el-aside>
        <el-main style="padding:0">
            <!-- 添加一个通用的头部 -->
            <el-header style="height: 10%;">
                <el-container style="margin:0;padding:0;height:80px">
                    <div class="head" style="width: 90%; color: white; margin: auto;margin-left:100px;">
                        <h1>欢迎您登录后台管理系统，管理员用户<span style="color:#ffd04b;">{{userName}}</span>！</h1>
                        <div class="clock">
                            <h1>当前时间：</h1>
                            <h1 id="1">0</h1>
                            <h1 id="2">0</h1>
                            <h1 id="3">:</h1>
                            <h1 id="4">0</h1>
                            <h1 id="5">0</h1>
                            <h1 id="6">:</h1>
                            <h1 id="7">0</h1>
                            <h1 id="8">0</h1>
                        </div>
                    </div>
                    <div style="width: 10%; margin: auto;margin-right:50px">
                        <el-button type="primary" @click="logout">注销</el-button>
                    </div>
                </el-container>
            </el-header>
            <div class="content" style="height: 90%; overflow: scroll;">
                <!-- 这里用来渲染具体的功能模块 -->
                <router-view style="height:100%; width: 98%;margin: 0;"></router-view>
            </div>
        </el-main>
    </el-container>
</template>

<script>
import Storage from '../../tools/Storage'

export default {
    // eslint-disable-next-line vue/multi-word-component-names
    name: "AdminHome",
    data(){
        return{
            userName:Storage.state.userName,
            mytimer:"",
        }
    },
    methods: {
        logout() {
            Storage.commit('clearUserInfo');
            this.$router.push({name: 'login'})
        },
        selectItem(index) {
            this.$router.push(index)
        },
        myTime() {
            let time = new Date();
            let hh = time.getHours();  //时
            let mm = time.getMinutes();  //分
            let ss = time.getSeconds();  //秒
            // Math.floor() 向下取整
            document.getElementById("1").innerText = Math.floor(hh / 10);
            document.getElementById("2").innerText = hh % 10;
            document.getElementById("4").innerText = Math.floor(mm / 10);
            document.getElementById("5").innerText = mm % 10;
            document.getElementById("7").innerText = Math.floor(ss / 10);
            document.getElementById("8").innerText = ss % 10;
        }
    },
    mounted() {
        this.mytimer=setInterval(this.myTime, 1000);
    },
    unmounted() {
        clearInterval(this.mytimer);
    }
}
</script>

<style scoped>
#container {
    height: 100%;
    width: 100%;
    position: absolute;
}

#top {
    margin-right: 1px;
    text-align: center;
    height: 60px;
}


.clock {
    float: right;
}

.head h1 {
    float: left;
}

.el-menu-item:hover {
    /* 鼠标移入元素沿Y轴上移 */
}

/* 加个扫光动画 */
.el-menu-item:before {
    content: "";
    position: absolute;
    top: 0px;
    left: 0px;
    width: 50px;
    height: 100%;
    background-color: rgb(37 33 33);;
    /* 元素沿X轴45横切，沿X轴右移150px */
    transform: skewX(45deg) translateX(300px);
    /* 动画过渡 */
}

.el-menu-item:hover::before {
    /* 元素沿X轴45横切，沿X轴左移150px */
    transform: skewX(45deg) translateX(-300px);
    transition: all 0.5s;
}

.el-aside::-webkit-scrollbar {

    display: none;

}

.el-main::-webkit-scrollbar {

    display: none;

}

.content::-webkit-scrollbar {

    display: none;

}
</style>