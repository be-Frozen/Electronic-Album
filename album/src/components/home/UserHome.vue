<template>
    <el-container id="container">
        <el-aside width="250px" style="overflow: hidden;">
            <el-container id="top">
                <img style="width:35px;height:35px;border-radius:50%;margin:auto;margin-right:0;"
                     src="~@/assets/logo.jpg"/>

                <div style="margin:auto;margin-left:10px;color:#ffffff;font-size:24px">
                    响当当相册
                </div>
            </el-container>
            <el-menu
                router
                :default-active="$route.path"
                style="border: none; height:95%;overflow: auto"
                background-color="transparent"
                text-color="#fff"
                active-text-color="#ffd04b"
                @select="selectItem">


                <el-sub-menu index="1">
                    <template #title>
                        <i class="el-icon-s-order"></i>
                        <span>个人中心</span>
                    </template>
                    <el-menu-item index="/userhome/user/main">相册</el-menu-item>
                    <el-menu-item index="/userhome/user/information">个人资料</el-menu-item>
                </el-sub-menu>



                <el-menu-item index="/userhome/user/share">朋友圈</el-menu-item>
                <el-sub-menu index="2">
                    <template #title>
                        <i class="el-icon-s-order"></i>
                        <span>我的相册（{{$store.state.album_info.length}}）</span>
                    </template>
                    <el-menu-item v-for="(value,index) in $store.state.album_info" :index="'/userhome/user/order/'+value['a_name']">{{ $store.state.album_info[index]['a_name'] }}({{ $store.state.album_info[index]['a_size'] }})</el-menu-item>
                </el-sub-menu>



            </el-menu>
        </el-aside>
        <el-main style="padding:0">
            <!-- 添加一个通用的头部 -->
            <el-header style="height: 10%;">
                <el-container style="margin:0;padding:0;height:80px">
                    <div class="head" style="width: 90%; color: white; margin: auto;margin-left:100px;">
                        <h1>欢迎您登录响当当相册，用户<span style="color:#ffd04b;">{{ userName }}</span>！</h1>
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
                        <el-button type="danger" @click="logout">注销</el-button>
                    </div>
                </el-container>
            </el-header>
            <!--<div class="content" style="height: 90%; overflow: scroll;position: relative;">-->
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
    name: "UserHome",
    data() {
        return {

            //userName: Storage.state.userName,
            mytimer:"",
        }
    },
    computed:{
        userName(){
            return Storage.state.userName;
        },
        album_info(){
            //return Storage.state.album_info;
            //console.log(Storage.state.album_info);
            var arr=Object.create(Storage.state.album_info);
            //var arr=Storage.state.album_info;
            //console.log(arr);
            var compare = function(name,fun){
                return function(o,p){
                    var a,b;
                    if(o && p && typeof o === 'object' && typeof p ==='object'){
                        a = o[name];
                        b = p[name];
                        if(name==='a_name'){
                            return a.localeCompare(b, 'zh-CN');
                        }
                        if(name==='a_size'){
                            a=parseInt(a);
                            b=parseInt(b);
                        }
                        //当o[name] 和 p[name] 相等时，利用fun函数根据另一个属性来进行比较
                        if(a === b){
                            a=o['a_name'];
                            b=p['a_name'];
                            return a.localeCompare(b, 'zh-CN');
                        }
                        if(typeof a === typeof b){
                            return a < b ? -1:1;
                        }
                        return typeof a < typeof b ? -1 : 1;
                    }
                }
            };
            arr.sort(compare('a_name'));
            return Storage.state.album_info?arr:arr;

        },
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
    beforeCreate() {
        //console.log("ok");
        let phpaddr = "album/php/getAlbum.php";
        var albumxmlhttp;
        albumxmlhttp = new XMLHttpRequest();
        albumxmlhttp.onreadystatechange = function () {
            if (albumxmlhttp.readyState == 4 && albumxmlhttp.status == 200) {
                var x=JSON.parse(albumxmlhttp.responseText);
                Storage.commit("getAlbumInfo", x);
                //console.log(Storage.state.album_info);
                //console.log(Storage.state.album_info);
                //console.log(Storage.state.album_info[0]);
                //console.log(Storage.state.album_info[0]['a_name']);
            }
        }
        albumxmlhttp.open("GET", '/myApi' + phpaddr + '?order=0&name='+Storage.state.userName, false);

        albumxmlhttp.send();

        phpaddr = "album/php/getHead.php";
        var headxmlhttp;
        headxmlhttp = new XMLHttpRequest();
        headxmlhttp.onreadystatechange = function () {
            if (headxmlhttp.readyState == 4 && headxmlhttp.status == 200) {
                var x=JSON.parse(headxmlhttp.responseText);
                Storage.commit("getHeadInfo", x);
                console.log(x);
                //console.log(Storage.state.album_info);
                //console.log(Storage.state.album_info);
                //console.log(Storage.state.album_info[0]);
                //console.log(Storage.state.album_info[0]['a_name']);
            }
        }
        headxmlhttp.open("GET", '/myApi' + phpaddr, true);
        headxmlhttp.send();


        var photoxmlhttp = [];
        for (var i = 0; i < Storage.state.album_info.length; i++) {
            let phpaddr = "album/php/getPhoto.php";

            photoxmlhttp[i] = new XMLHttpRequest();
            photoxmlhttp[i].album = Storage.state.album_info[i]['a_name'];
            photoxmlhttp[i].onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    var x = this.album;
                    //console.log(x);
                    var text=JSON.parse(this.responseText);
                    //console.log(text);
                    //console.log(text);
                    Storage.commit("getPhotoList", {
                        album: x,
                        photolist: text,
                    })
                   //console.log(text);
                }
            }
            //console.log(Storage.state.album_info[i]);
            photoxmlhttp[i].open("GET", '/myApi' + phpaddr + '?owner='+Storage.state.userName+'&album='+Storage.state.album_info[i]['a_name'], true);

            photoxmlhttp[i].send();

        }

        phpaddr = "album/php/getShare.php";
        var sharexmlhttp;
        sharexmlhttp = new XMLHttpRequest();
        sharexmlhttp.onreadystatechange = function () {
            if (sharexmlhttp.readyState == 4 && sharexmlhttp.status == 200) {
                var x=JSON.parse(sharexmlhttp.responseText);
                Storage.commit("getShareInfo", x);
                //console.log(x);
            }
        }
        sharexmlhttp.open("GET", '/myApi' + phpaddr+"?name="+Storage.state.userName, true);

        sharexmlhttp.send();
    },
    /*created() {
        console.log(Storage.state.album_info.length);
        var xmlhttp = [];
        for (var i = 0; i < Storage.state.album_info.length; i++) {
            let phpaddr = "album/php/outdir.php";

            xmlhttp[i] = new XMLHttpRequest();
            xmlhttp[i].album = Storage.state.album_info[i];
            xmlhttp[i].onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    var x = this.album;
                    Storage.commit("getFirstPhoto", {
                        album: x,
                        first_photo: JSON.parse(this.responseText),
                    })
                    console.log(this.responseText);
                }
            }
            console.log(Storage.state.album_info[i]);
            xmlhttp[i].open("GET", '/' + phpaddr + '?readall=0&type=1&addr=原神/' + Storage.state.album_info[i], true);

            xmlhttp[i].send();

        }
    },*/
    mounted() {
        this.mytimer = setInterval(this.myTime, 1000);


        let phpaddr = "album/php/GetUserInformation.php";
        var xmlhttp;
        var success = false;
        xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                //var x = JSON.parse(xmlhttp.responseText);
                var x = JSON.parse(xmlhttp.responseText);
                Storage.commit('getUserInformation',{
                    head:x['u_head'],
                    sex:x['u_sex'],
                    birthday:x['u_birthday'],
                    signature:x['u_signature'],
                    status:x['u_status'],
                    registertime:x['u_registertime']
                })
                //console.log(x);
            }
        }
        xmlhttp.open("GET", '/myApi' + phpaddr + '?name=' + this.userName, true);
        xmlhttp.send();

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

.el-menu-item{
    font-size: 15px;
}
.el-sub-menu__title span{
    font-size: 15px;
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
.el-menu::-webkit-scrollbar{
    display: none;
}
</style>