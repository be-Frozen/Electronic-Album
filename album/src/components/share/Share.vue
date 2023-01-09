<template>
    <div class="content-container" direction="vertical">

        <div v-show="!send" class="content-row" style="height: 10%">
            <el-container>
                <el-button style="color: white" color="darkorange" type="success" @click="share">发朋友圈</el-button>
            </el-container>
        </div>

        <el-drawer
            v-model="drawer"
            title="I am the title"
            direction="ltr"
            size="50%"
            :with-header="false"
        >
            <el-select @change="addpic" v-model="nowalbum" class="m-2" placeholder="Select" size="large">
                <el-option
                    v-for="item in this.$store.state.album_info"
                    :key="item['a_name']"
                    :label="item['a_name']"
                    :value="item['a_name']"
                />
            </el-select>
            <div v-show="albumnotexist" style="margin-top: 40%">
                <span>该相册不存在</span>
            </div>
            <div v-show="albumempty" style="margin-top: 40%">
                <span>该相册为空</span>
            </div>
            <div v-show="albumok" class="selectpic">
                <div class="eachpic" v-for="i in this.$store.state.photolist[this.nowalbum]" @click.capture="choose(i)">

                    <img
                        decoding="async"
                        :src="'/myApi'+'album/照片/'+this.$store.state.userName+'/'+this.nowalbum+'/'+i['p_address']"
                        style="pointer-events: none; width: auto; height: auto; max-width: 100%; max-height: 100%;"
                    >
                </div>
            </div>
        </el-drawer>

        <div class="edit" v-show="send">
            <el-container>
                <div>
                    <el-button type="danger" @click="cancel">取消</el-button>
                    <el-button type="success" @click="ok">发布</el-button>
                </div>
            </el-container>
                <el-input class="input"
                          resize="none"
                          v-model="sharewords"
                          type="textarea"
                          placeholder="内容"
                          :autosize="{ minRows: 2 }"
                />
            <el-container>
                <div>
                    <el-button type="danger" @click="clear" plain>清空照片</el-button>
                    <el-button type="success" @click="addpic" plain>添加照片</el-button>
                </div>
            </el-container>
            <el-container>
                <div style="width: 1000px;">
            <div class="selectedpic" v-for="(i,index) in this.choosepicarr" @click="unchoose(index)">

                <img
                    decoding="async"
                    :src="'/myApi'+'album/照片/'+this.$store.state.userName+'/'+i"
                    style="pointer-events: none; width: auto; height: auto; max-width: 100%; max-height: 100%;"
                >
            </div>
                </div>
            </el-container>
        </div>



        <el-container v-for="(i,index) in this.$store.state.share_info">
            <el-header class="sharer">
                <img class="profile" :src="'/myApi'+'album/头像/'+i['head']"/>
                <div>
                    <h2 class="name">{{i['user']}}</h2>
                    <h5 class="time">&nbsp;&nbsp;{{i['time']}}</h5>
                    <h5 @click="deleteshare(index)" v-show="i['delete']" style="float: right; cursor: pointer; position:relative; text-align: right; color: silver;text-decoration: underline;">删除</h5>
                </div>
                <br/>
                <div><h3 class="message"><span>&nbsp;&nbsp;</span>{{i['words']}}</h3></div>
            </el-header>
            <el-main class="pic">
                <el-space v-for="j in i['photo']" wrap style="float:left;">
                    <div @click="openModal(j)" class="shareimg">
                        <img decoding="async" :src="'/myApi'+'album/照片/'+j"
                            style="pointer-events: none; width: auto; height: auto; max-width: 100%; max-height: 100%;">
                    </div>
                </el-space>


                <div id="mysharemyModal" class="mysharemodal">
                    <div style="position: absolute;width: 100%;height: 100%;background-color: rgb(0 0 0 / 46%);"
                         @click="closeModal()"></div>
                    <div class="mysharemodal-content" style="height: 100%;width: 100%">
                        <div   class="mysharemySlides" style="width: 100%; height: 100%;">
                            <!--<div class="close" @click="closeModal">×</div>-->
                            <div class="myshareclose" @click="closeModal">×</div>
                            <img ref="imgDiv" class="myshareimg" @mousewheel="rollImg" @mousedown="move" decoding="async" :src="'/myApi'+'album/照片/'+this.nowphoto">
                        </div>


                    </div>
                </div>

            </el-main>
            <el-footer class="commant">
                <el-container style="padding: 0;">
                <div class="dianzan">
                    <button @click="like(index)" class="paw-button" style="float:left;">
                        <div v-show="!i['like']" class="text" style="color: yellow">
                            <svg>
                                <use xlink:href="#heart"/>
                            </svg>
                        </div>
                        <div v-show="i['like']" class="text" style="color: yellow">
                            <svg style="--background: #f1758d;">
                                <use xlink:href="#heart"/>
                            </svg>
                        </div>
                        <span>{{ i['likenum'] }}</span>
                    </button>
                </div>


                <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                    <symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 21 19" id="heart">
                        <path d="M10.7146252,2.79863032 C12.7012563,0.931232655 14.9323041,0.436636741 17.303155,1.3849771 C20.1742369,2.53340984 21.379939,5.46245395 20.2209696,8.35987762 C19.6094364,9.88871051 17.374953,12.5020804 13.4593886,16.3167815 L12.4216841,17.3182725 C11.3603119,18.3334838 9.68851069,18.3354777 8.62471989,17.322801 L7.91413528,16.6420566 C3.86646758,12.738617 1.52252172,10.0157042 0.832966246,8.37137962 C-0.41863058,5.38680258 0.803066105,2.56217827 3.74606902,1.3849771 C5.99801057,0.484200479 8.20491678,0.982789394 10.280801,2.80379411 L10.5027119,3.00395851 L10.7146252,2.79863032 Z" fill="var(--border)"></path>
                        <path d="M16.746069,2.77769213 C14.6991759,1.9589349 12.8646007,2.52341959 11.0917453,4.57210939 L10.5493822,5.19885746 L9.97978137,4.59675633 C8.07203164,2.58015418 6.22092676,2.01058345 4.30315504,2.77769213 C2.13116413,3.6464885 1.29186971,5.5869795 2.21625782,7.79128961 C2.80060177,9.18472518 5.06951474,11.8148892 8.97366525,15.5798429 L9.65895765,16.2363608 C10.142501,16.6966703 10.9024138,16.695764 11.3840599,16.2350667 L12.3934356,15.260969 L13.3524601,14.3169524 C16.5267562,11.1578139 18.3665388,8.9570809 18.8282545,7.80279161 C19.6830863,5.66571221 18.8388588,3.61480804 16.746069,2.77769213 Z" fill="var(--background)"></path>
                        <path d="M11.2640718,4.39338901 L11.1990259,4.45003381 C12.9386445,2.50122541 14.7404343,1.97543825 16.746069,2.77769213 C18.8388588,3.61480804 19.6830863,5.66571221 18.8282545,7.80279161 C18.3963269,8.88261062 17.6718097,9.565648 18.0773108,8.55189509 C18.9321426,6.41481569 18.0879151,4.36391153 15.9951253,3.52679561 C14.3011449,2.84920342 12.7525807,3.11899214 11.2640718,4.39338901 L11.1990259,4.45003381 L11.2640718,4.39338901 Z" fill="var(--shadow-light)"></path>
                        <path d="M4.30315504,2.77769213 C5.1840079,2.42535099 6.05079631,2.35500405 6.91546905,2.57734431 C6.71200283,2.6290933 6.50795909,2.69577051 6.30315504,2.77769213 C4.13116413,3.6464885 3.29186971,5.5869795 4.21625782,7.79128961 C4.80060177,9.18472518 7.06951474,11.8148892 10.9736653,15.5798429 L11.5197324,16.1027938 L11.3840599,16.2350667 C10.9368171,16.6628571 10.2496402,16.694195 9.76660209,16.3279397 L9.65895765,16.2363608 L8.97366525,15.5798429 L8.30168234,14.9272399 C4.80841276,11.5097375 2.7662286,9.10275838 2.21625782,7.79128961 C1.29186971,5.5869795 2.13116413,3.6464885 4.30315504,2.77769213 Z" fill="var(--shadow-dark)"></path>
                    </symbol>
                </svg>




                <el-button id="uncomment" @click="comment(index)" style="position: relative;float: left;top: 5px; background-color: transparent;border: none; ">
                    <el-icon choose="false" id="comment" style="pointer-events: none;font-size: 40px;"><Comment /></el-icon>
                    <span choose="false" style="font-size: 24px;color: white;">{{i['commentnum']}}</span>
                </el-button>
                </el-container>

                <div v-show="i['cmt']" style="width: 50%">
                    <el-input
                              class="cmtinput"
                              resize="none"
                              maxlength="200"
                              v-model="i['content']"
                              show-word-limit
                              type="textarea"
                              placeholder="内容"
                              :autosize="{ minRows: 2 }"
                    />
                    <el-container>
                        <div>
                            <el-button type="danger" @click="comment(index)">取消</el-button>
                            <el-button type="success" @click="uploadcomment(index)">评论</el-button>
                        </div>
                    </el-container>
                </div>
                <div style="border: 1px solid black;">
                    <div v-for="(j,indexj) in this.$store.state.share_info[index]['comment']" class="comment">
                        <img style="position:absolute;float:left; left: 0; width: 40px;height: 40px;border-radius: 50%;" :src="'/myApi'+'album/头像/'+j['head']"/>
                        <h4 class="name" style="left: 55px;">{{j['user']}}</h4>
                        <button @click="deletecomment(index,indexj)" v-if="j['delete']" class="deletecmt">×</button>
                        <br/>
                        <h5 style="padding: 0; position:relative; left: 55px; height: auto; float:left; text-align: left">{{j['words']}}</h5>
                        <h5 style="position: relative; color:pink;left: 55px;text-align: right;">{{j['time']}}</h5>
                        <h1> </h1>
                    </div>
                </div>
            </el-footer>
            <hr>
        </el-container>

    </div>
</template>
<style>
*{
    margin: 0;
    padding: 0;
}
.deletecmt{
    color: white;
    float: left;
    left: 55px;
    background-color: transparent;
    border: none;
    width: 40px;
    margin-left: 10px;
    position: relative;
}

/* 弹窗背景 */
.mysharemodal {
    overflow: unset;
    display: none;
    position: absolute;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    object-fit: contain;
    background-color: transparent;
}

/* 弹窗内容 */
.mysharemodal-content {
    overflow: hidden;
    position: relative;
    top: 0;
    background-color: rgb(0 0 0 / 46%);
    margin: auto;
    padding: 0;
    width: 90%;
}

/* 关闭按钮 */
.myshareclose {
    color: white;
    position: absolute;
    top: 10px;
    right: 25px;
    font-size: 35px;
    font-weight: bold;
    z-index: 5;
}

.myshareclose:hover,
.myshareclose:focus {
    color: #999;
    text-decoration: none;
    cursor: pointer;
}
.mysharemySlides {
    display: none;
    overflow: hidden;
}

.myshareimg {
    position: absolute;
    top: 0px;
    left: 0px;
    object-fit: contain;
    cursor: move;
}

div{

    -moz-user-select:none;/*火狐*/

    -webkit-user-select:none;/*webkit浏览器*/

    -ms-user-select:none;/*IE10*/

    -khtml-user-select:none;/*早期浏览器*/

    user-select:none;

}

.input .el-textarea__inner{
    background-color: transparent;
    color:white;
    width: 50%;
    margin-left: 15px;
}

.cmtinput .el-textarea__inner{
    background-color: transparent;
    color:white;
    margin-left: 15px;
}
.cmtinput .el-input__count{
    background-color: transparent;
}
.commenttime{
    background-color: blue;
    height: 200px;
}
.comment{
    position: relative;
    background-color: transparent;
    width: 95%;
}

.selectpic{
    overflow: auto;
    height: 800px;
}

.selectpic::-webkit-scrollbar {
    display: none;
}

.selectedpic{
    cursor: pointer;
    alignment: center;
    display: flex;
    align-items: center;
    margin: 2px;
    width: 130px;
    height: 130px;
    position: relative;
    float: left;
    justify-content: space-around;
    background-color: transparent;
    border: 1px solid black;
}

.selectedpic:hover{
    border: 4px solid #f56c6c;
}

.eachpic{
    cursor: pointer;
    alignment: center;
    display: flex;
    align-items: center;
    margin: 2px;
    width: 130px;
    height: 130px;
    position: relative;
    float: left;
    justify-content: space-around;
    background-color: transparent;
    border: 1px solid black;
}

.eachpic:hover{
    border: 4px solid #67c23a;
}

#comment span{
    pointer-events: none;
}
#uncomment span{
    pointer-events: none;
}
#uncomment .el-icon{
    color: white;
}
#comment .el-icon{
    color: #409eff;
}



.sharer{
    background-color: transparent;
    color: white;
    height: auto;
    --el-header-padding: 0;
    position: relative;
}
.pic{
    background-color: transparent;
    color: white;
    height: auto;
}
.commant{
    background-color: transparent;
    color: white;
    height: auto;
}
.profile{
    position: relative;
    width:60px;
    height:60px;
    border-radius:50%;
    top: 0;
    bottom: 0;
    background-color: transparent;
    float: left;
}
.name{
    position: relative;
    background-color: transparent;
    float: left;
    bottom: 0;
    top: 0;
    left: 12px;
    color: rgb(255, 208, 75);
    text-align: left;
}
.time{
    position: relative;
    background-color: transparent;
    float: left;
    bottom: 0;
    top: 0;
    left: 12px;
    color: pink;
    text-align: left;
}
.message{
    position: relative;
    background-color: transparent;
    float: left;
    bottom: 0;
    top: 0;

    text-align: left;
}
.shareimg{
    cursor: pointer;
    alignment: center;
    display: flex;
    align-items: center;
    margin: 2px;
    width: 200px;
    height: 200px;
    position: relative;
    float: left;
    justify-content: space-around;
    background-color: transparent;
    border: 1px solid black;
}

.dianzan{
    background-color: transparent;
}

.paw-button {
    background-color: transparent;
    border: none;
    --background: transparent;
    --background-active: #FEE8F4;
    --border: transparent;
    --border-active: transparent;
    --text: #000;
    --number: #9C9496;
    --number-active: #000;
    --heart-background: #fff;
    --heart-background-active: #FEA5D7;
    --heart-border: #C3C2C0;
    --heart-border-active: #2B2926;
    --heart-shadow-light: #FEE0F2;
    --heart-shadow-dark: #EA5DAF;
    --paw-background: #fff;
    --paw-border: #201E1B;
    --paw-shadow: #EEEDED;
    --paw-inner: var(--heart-background-active);
    --paw-shadow-light: var(--heart-shadow-light);
    --paw-shadow-dark: var(--heart-shadow-dark);
    --paw-clap-background: #FEF0A5;
    --paw-clap-border: var(--paw-border);
    --paw-clap-shadow: #FED75C;
    --circle: #df3dce;
    --circle-line: #000;
    display: inline-flex;
    text-decoration: none;
    font-weight: bold;
    position: relative;
    line-height: 19px;
    /*padding: 12px 16px;*/
}
.paw-button:before {
    background-color: transparent;
    content: '';
    position: absolute;
    display: block;
    left: -2px;
    top: -2px;
    bottom: -2px;
    right: -2px;
    z-index: 0;
    border-radius: 5px;
    transition: background .45s, border-color .45s;
    background: var(--background);
    border: 2px solid var(--border);
}
.paw-button svg {
    display: block;
}
.paw-button .text {
    position: relative;
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    -webkit-transform: translateZ(0);
    transform: translateZ(0);
    margin-right: 8px;
    transition: width .25s;
    width: 104px;
    margin-left: 0;
}

.paw-button .text svg {
    transition: opacity .2s, -webkit-transform .15s ease-out;
    transition: transform .15s ease-out, opacity .2s;
    transition: transform .15s ease-out, opacity .2s, -webkit-transform .15s ease-out;
    opacity: var(--o, 1);
    height: 40px !important;
    width: 40px !important;
    margin-left: 20px !important;
}

.paw-button .text svg {
    --background: var(--heart-background);
    --shadow-light: transparent;
    --shadow-dark: transparent;
    width: 21px;
    height: 19px;
    -webkit-transform: translateX(var(--x));
    transform: translateX(var(--x));
}
.paw-button > span {
    display: block;
    position: absolute;
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    color: white;
    font-size: 24px;
    top: 12px;
    left: 66px;
    margin: auto;
}


html {
    box-sizing: border-box;
    -webkit-font-smoothing: antialiased;
}

* {
    box-sizing: inherit;
}
*:before, *:after {
    box-sizing: inherit;
}

body {
    min-height: 100vh;
    display: flex;
    font-family: 'Roboto', Arial;
    justify-content: center;
    align-items: center;
    background: #fff;
}
body .dribbble {
    position: fixed;
    display: block;
    right: 20px;
    bottom: 20px;
}
body .dribbble img {
    display: block;
    height: 28px;
}
</style>
<script>
import Storage from "@/tools/Storage";
export default {
    data() {
        return {
            send: false,
            sharewords:"",
            picarr:[],
            drawer:false,
            nowalbum:'',
            albumnotexist:false,
            albumempty:false,
            albumok:false,
            choosepicarr:[],
            nowphoto:"",
        }
    },
    mounted () {
        var phpaddr = "album/php/getShare.php";
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

        if(Storage.state.album_info.length!==0){
            this.nowalbum=Storage.state.album_info[0]['a_name'];
        }

        console.log(Storage.state.share_info);
    },
    methods : {
        deleteshare(i){
            var arr=[].concat(Storage.state.share_info);

            let phpaddr = "album/php/deleteShare.php";
            var userxmlhttp;
            userxmlhttp = new XMLHttpRequest();
            userxmlhttp.onreadystatechange = function () {
                if (userxmlhttp.readyState == 4 && userxmlhttp.status == 200) {
                    //var x=JSON.parse(userxmlhttp.responseText);

                }
            }
            userxmlhttp.open("GET", '/myApi' + phpaddr + "?sid="+arr[i]['id'], true);

            userxmlhttp.send();

            arr.splice(i,1);
            Storage.commit('getShareInfo',arr);
        },
        deletecomment(i,j){
            var arr=[].concat(Storage.state.share_info);
            arr[i]['commentnum']--;

            let phpaddr = "album/php/deletecomment.php";
            var userxmlhttp;
            userxmlhttp = new XMLHttpRequest();
            userxmlhttp.onreadystatechange = function () {
                if (userxmlhttp.readyState == 4 && userxmlhttp.status == 200) {
                    //var x=JSON.parse(userxmlhttp.responseText);

                }
            }
            console.log(i);
            console.log(j);
            userxmlhttp.open("GET", '/myApi' + phpaddr + '?id='+arr[i]['comment'][j]['id']+"&sid="+arr[i]['id']+"&commentnum="+arr[i]['commentnum'], true);

            userxmlhttp.send();

            arr[i]['comment'].splice(j,1);
            Storage.commit('getShareInfo',arr);

        },
        move(e) {
            //console.log("click");
            e.preventDefault()
            // 获取元素
            var left = document.querySelector('.mysharemySlides')

            //console.log(left.clientWidth);
            //console.log(left.clientHeight);
            var img = document.querySelector('.myshareimg')
            var x = e.pageX - img.offsetLeft
            var y = e.pageY - img.offsetTop
            // 添加鼠标移动事件
            left.addEventListener('mousemove', move)
            function move(e) {
                img.style.left = e.pageX - x + 'px'
                img.style.top = e.pageY - y + 'px'
            }
            // 添加鼠标抬起事件，鼠标抬起，将事件移除
            img.addEventListener('mouseup', function() {
                left.removeEventListener('mousemove', move)
            })
            // 鼠标离开父级元素，把事件移除
            left.addEventListener('mouseout', function() {
                left.removeEventListener('mousemove', move)
            })
        },
        rollImg(e) {
            //console.log('roll');
            console.log("roll");


            var img = document.querySelector('.myshareimg');
            var left = document.querySelector('.mysharemySlides');
            //console.log(left.getBoundingClientRect().left);
            var l=e.pageX-left.getBoundingClientRect().left-parseInt(img.style.left);
            var t=e.pageY-left.getBoundingClientRect().top-parseInt(img.style.top);
            //console.log("l:",l);
            //console.log(event.wheelDelta);
            //console.log(img.style.width);
            var x = e.pageX - img.offsetLeft
            var y = e.pageY - img.offsetTop

            //if(parseInt(img.style.width)>10000||parseInt(img.style.width)<100) return;

            if(event.wheelDelta>0&&parseInt(img.style.width)<20000)
            {
                //console.log(0.1*parseInt(img.style.width));


                img.style.left=parseInt(img.style.left)-0.1*l+'px';
                img.style.top=parseInt(img.style.top)-0.1*t+'px';

                img.style.width=parseInt(img.style.width)*1.1+'px';
                img.style.height=parseInt(img.style.height)*1.1+'px';
                //img.style.left=parseInt(img.style.left)-0.1*e.pageX+'px';
                //img.style.top=parseInt(img.style.top)-0.1*e.pageY+'px';
                //var newl=e.pageX-left.getBoundingClientRect().left-parseInt(img.style.left);
                //console.log(l,newl);
                //img.style.left=parseInt(img.style.left)-(newl-l)+'px';
            }
            if(event.wheelDelta<0&&parseInt(img.style.width)>100)
            {
                img.style.left=parseInt(img.style.left)+l/11+'px';
                img.style.top=parseInt(img.style.top)+t/11+'px';

                img.style.width=parseInt(img.style.width)/1.1+'px';
                img.style.height=parseInt(img.style.height)/1.1+'px';
                //img.style.left=parseInt(img.style.left)+0.1*e.pageX+'px';
                //img.style.top=parseInt(img.style.top)+0.1*e.pageY+'px';
            }
            //console.log(img.style.width);
            //var newx = e.pageX - img.offsetLeft
            //var newy = e.pageY - img.offsetTop
            //console.log("e.pageX:",e.pageX,"  img.offsetLeft:",img.offsetLeft,"  img.style.left:",img.style.left);
            //img.style.left=parseInt(img.style.left)-(newx-x)+'px';
            //console.log("e.pageX:",e.pageX,"  img.offsetLeft:",img.offsetLeft,"  img.style.left:",img.style.left);



            /* 获取当前页面的缩放比 若未设置zoom缩放比，则为默认100%，即1，原图大小 */
            //var zoom = parseInt(this.$refs.imgDiv.style.zoom) || 100;
            /* event.wheelDelta 获取滚轮滚动值并将滚动值叠加给缩放比zoom wheelDelta统一为±120，其中正数表示为向上滚动，负数表示向下滚动 */
            //zoom += event.wheelDelta / 12;
            /* 最小范围 和 最大范围 的图片缩放尺度 */
            //if (zoom >= 80 && zoom <500)
            //{
            //this.$refs.imgDiv.style.zoom = zoom + "%";
            //}

        },
        openModal(i) {

            document.getElementById('mysharemyModal').style.display = "block";
            document.getElementsByClassName("mysharemySlides")[0].style.display = "block";
            this.nowphoto=i;
            var img = document.querySelector('.myshareimg');
            //img.style.width='1200px';
            //img.style.height='916px';
            img.style.width=window.innerWidth+'px';
            img.style.height=window.innerHeight+'px';
            img.style.left = 0;
            img.style.top = 0;
            //var screen = document.querySelector('.modal')
            //screen.webkitRequestFullscreen();
        },
        closeModal() {
            document.getElementById('mysharemyModal').style.display = "none";
            var img = document.querySelector('.img');



        },
        choose(i){
            this.choosepicarr.push(this.nowalbum+"/"+i['p_address']);
        },
        unchoose(index){
            this.choosepicarr.splice(index,1);
        },

        like(index){    //点赞


            var arr=[].concat(Storage.state.share_info);
            if(arr[index]['like']===false){
                arr[index]['like']=true;
                arr[index]['likenum']++;
            }
            else{
                arr[index]['like']=false;
                arr[index]['likenum']--;
            }

            Storage.commit('getShareInfo',arr);
            var phpaddr = "album/php/like.php";
            var sharexmlhttp;
            sharexmlhttp = new XMLHttpRequest();
            sharexmlhttp.onreadystatechange = function () {
                if (sharexmlhttp.readyState == 4 && sharexmlhttp.status == 200) {
                    console.log(this.responseText);
                }
            }
            sharexmlhttp.open("GET", '/myApi' + phpaddr +"?user="+Storage.state.userName+"&sid="+arr[index]['id']+"&like="+arr[index]['like']+"&likenum="+arr[index]['likenum'], true);

            sharexmlhttp.send();
        },
        clear(){
            this.choosepicarr=[];
        },
        cancel(){
            this.send=false;
        },
        ok(){
            this.send=false;


            let phpaddr = "album/php/updateShare.php";
            var userxmlhttp;
            userxmlhttp = new XMLHttpRequest();
            userxmlhttp.onreadystatechange = function () {
                if (userxmlhttp.readyState == 4 && userxmlhttp.status == 200) {
                    var x=JSON.parse(userxmlhttp.responseText);
                    this.id=x['id'];
                    this.time=x['time'];
                }
            }
            userxmlhttp.open("GET", '/myApi' + phpaddr + '?user='+Storage.state.userName+'&words='+this.sharewords, false);

            userxmlhttp.send();

            var p=[];
            p['id']=userxmlhttp.id;
            p['user']=Storage.state.userName;
            p['words']=this.sharewords;
            p['likenum']=0;
            p['photo']=[];
            p['comment']=[];
            p['time']=userxmlhttp.time;
            p['like']=false;
            p['cmt']=false;
            p['commentnum']=0;
            p['content']="";
            for(var j=0;j<this.choosepicarr.length;j++){
                p['photo'][j]=Storage.state.userName+"/"+this.choosepicarr[j];
            }
            p['delete']=true;
            p['head']=Storage.state.head;

            var arr=[].concat(Storage.state.share_info);
            arr.unshift(p);
            Storage.commit('getShareInfo',arr);
            console.log(Storage.state.share_info);
            var photoxmlhttp = [];
            for (var i = 0; i < this.choosepicarr.length; i++) {
                let phpaddr = "album/php/updateSharePic.php";
                var x=this.choosepicarr[i].indexOf('/');
                var tempalbum=this.choosepicarr[i].substr(0,x);
                var tempaddress=this.choosepicarr[i].substr(x+1);
                photoxmlhttp[i] = new XMLHttpRequest();
                photoxmlhttp[i].onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        console.log(this.responseText);
                    }
                }
                photoxmlhttp[i].open("GET", '/myApi' + phpaddr + '?user='+Storage.state.userName+'&album='+tempalbum+'&address='+tempaddress+'&sid='+userxmlhttp.id, true);

                photoxmlhttp[i].send();

            }


        },

        addpic(){
            this.drawer=true;
            var i;
            for(i=0;i<Storage.state.album_info.length;i++){
                if(Storage.state.album_info[i]['a_name']===this.nowalbum){
                    break;
                }
            }
            if(i===Storage.state.album_info.length){
                this.albumnotexist=true;
                this.albumempty=false;
                this.albumok=false;
                return;
            }
            if(Storage.state.photolist[this.nowalbum].length===0){
                this.albumnotexist=false;
                this.albumempty=true;
                this.albumok=false;
                return;
            }
            this.albumnotexist=false;
            this.albumempty=false;
            this.albumok=true;

        },
        comment(index){
            var arr=[].concat(Storage.state.share_info);
            if(arr[index]['cmt']===false){
                arr[index]['cmt']=true;
            }
            else{
                arr[index]['cmt']=false;
            }

            Storage.commit('getShareInfo',arr);
            arr[index]['content']="";
        },
        uploadcomment(index){
            var arr=[].concat(Storage.state.share_info);
            arr[index]['commentnum']++;

            //Storage.commit('getShareInfo',arr);


            var phpaddr = "album/php/comment.php";
            var sharexmlhttp;
            sharexmlhttp = new XMLHttpRequest();
            sharexmlhttp.arr=arr;
            sharexmlhttp.index=index;
            sharexmlhttp.user=Storage.state.userName;
            sharexmlhttp.words=arr[index]['content'];
            sharexmlhttp.onreadystatechange = function () {
                if (sharexmlhttp.readyState == 4 && sharexmlhttp.status == 200) {
                    var x=JSON.parse(sharexmlhttp.responseText);
                    console.log(x);
                    var p=[];
                    p['head']=x['head'];
                    p['id']=x['id'];
                    p['time']=x['time'];
                    p['user']=this.user;
                    p['words']=this.words;
                    p['delete']=true;
                    arr[index]['comment'].push(p);
                    Storage.commit('getShareInfo',arr);
                }
            }
            sharexmlhttp.open("GET", '/myApi' + phpaddr +"?user="+Storage.state.userName+"&sid="+arr[index]['id']+"&words="+arr[index]['content']+"&commentnum="+arr[index]['commentnum'], true);

            sharexmlhttp.send();

            this.comment(index);
        },
        share(e){
            this.send=!this.send;
        },
    }
}
</script>
