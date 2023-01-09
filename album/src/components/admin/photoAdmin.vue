<template>
    <div class="content-container" direction="vertical">
        <!-- button -->
        <div class="content-row" style="margin: 0;padding: 0">
            <h1 style="color: white;margin: 0;padding: 0">用户名：{{this.$store.state.name}}->相册名：{{this.$store.state.album}}</h1>
        </div>

        <!-- list -->
        <div class="show" style="height: 88%;overflow: auto">

            <div v-for="(item,index) in this.$store.state.photo" class="row">
                <div v-for="(pic,picindex) in item" class="column">
                    <!--<img decoding="async" :src="'http://localhost/album/原神/'+albumname+'/'+pic" style="width:100%"
                         @click="openModal(index*4+picindex);" class="hover-shadow cursor">-->
                    <img decoding="async" :src="'/myApi'+'album/照片/'+this.$store.state.name+'/'+this.$store.state.album+'/'+pic['p_address']" style="width:100%"
                         @click="openModal(index*4+picindex);" class="hover-shadow cursor">
                    <h3>{{pic['p_address']}}<button @click="deletePhoto(index*4+picindex)" class="deletephoto">×</button></h3>
                    <div style="height: 20px"></div>
                </div>
            </div>
            <div id="myModal" class="modal">
                <div style="position: absolute;width: 100%;height: 100%;background-color: rgb(0 0 0 / 46%);"
                     @click="closeModal()"></div>
                <div class="modal-content" style="height: 100%;width: 100%">
                    <div  @mousewheel="rollImg" class="mySlides" style="width: 100%; height: 100%;">
                        <div class="numbertext">{{pic_index+1}}/{{this.$store.state.photo_info.length}}</div>
                        <div class="close" @click="closeModal">×</div>
                        <img ref="imgDiv" class="img" @mousedown="move" decoding="async" :src="'/myApi'+'album/照片/'+this.$store.state.name+'/'+this.$store.state.album+'/'+nowphoto['p_address']">
                    </div>


                    <a class="prev" @click="PrevPic()">&#10094;</a>
                    <a class="next" @click="NextPic()">&#10095;</a>

                </div>
            </div>
        </div>
    </div>
</template>

<style>
.deletephoto{
    color: transparent;
    background-color: transparent;
    border: none;
    width: 40px;
    margin-left: 10px;
    transition: 0.6s ease;
}
.deletephoto:hover {
    background-color: rgba(0, 0, 0, 0.8);
    color: white;
}

.show::-webkit-scrollbar {

    display: none;

}

body {
    font-family: Verdana, sans-serif;
    margin: 0;
}

* {
    box-sizing: border-box;
}

.row > .column {
    padding: 0 8px;
}

.row:after {
    content: "";
    display: table;
    clear: both;
}

.column {
    float: left;
    width: 25%;
}
*{

    margin: 0;

    padding: 0;

}

html,body{

    width: 100%;

    height: 100%;

}
/* 弹窗背景 */
.modal {
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
.modal-content {
    overflow: hidden;
    position: relative;
    top: 0;
    background-color: rgb(0 0 0 / 46%);
    margin: auto;
    padding: 0;
    width: 90%;
}

/* 关闭按钮 */
.close {
    color: white;
    position: absolute;
    top: 10px;
    right: 25px;
    font-size: 35px;
    font-weight: bold;
    z-index: 5;
}

.close:hover,
.close:focus {
    color: #999;
    text-decoration: none;
    cursor: pointer;
}

.mySlides {
    display: none;
    overflow: hidden;
}

.cursor {
    cursor: pointer
}

/* 上一页 & 下一页 按钮 */
.prev,
.next {
    cursor: pointer;
    position: absolute;
    /*top: 50%;*/
    /*width: auto;*/
    height: 100%;
    width: 20%;
    top: 0;
    padding: 16px;
    margin-top: -50px;
    color: transparent;
    font-weight: bold;
    font-size: 20px;
    transition: 0.6s ease;
    border-radius: 0 3px 3px 0;
    user-select: none;
    -webkit-user-select: none;
}

.prev {
    left: 0;
}

/* 定位下一页按钮到右侧 */
.next {
    right: 0;
    border-radius: 3px 0 0 3px;
}

/* 鼠标移动上去修改背景色为黑色 */
/*.prev:hover,
.next:hover {
    background-color: rgba(0, 0, 0, 0.8);
    color: white;
}*/

/* 页数(1/3 etc) */
.numbertext {
    color: #f2f2f2;
    font-size: 12px;
    padding: 8px 12px;
    position: absolute;
    top: 0;
}

img {
    margin-bottom: -4px;
}

.img {
    position: absolute;
    top: 0px;
    left: 0px;
    object-fit: contain;
    cursor: move;
}

.caption-container {
    text-align: center;
    background-color: black;
    padding: 2px 16px;
    color: white;
}

.demo {
    opacity: 0.6;
}

.active,
.demo:hover {
    opacity: 1;
}

img.hover-shadow {
    transition: 0.3s
}

.hover-shadow:hover {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)
}
</style>

<script>

import axios from "axios";
import $ from 'jquery/src/jquery'
import Storage from "@/tools/Storage";
import {ElMessage} from "element-plus";
export default {
    data() {
        return {
            nowphoto:"",
            //:'/'+'album/temp',
            myApi:'/myApi'+'album/php/uploadPhoto.php',
            firstphoto:Storage.state.firstphoto,
            firstphotoarr:[],
            albumList:Storage.state.album_info,
            album_list:[],
            goodsData: [],
            pic_index:"",
            order:'0',
            //photo_list:[],
            update:1,
            first:'false',
            //album:'',

        }
    },

    // 组件挂载时获取数据
    mounted() {
        //this.photolist=Object.values(Storage.state.photolist[this.$route.params.type]);
        Storage.commit("getPhotoFlag",false);
        //this.changeOrder();
        let phpaddr = "album/php/getPhoto.php";
        var albumxmlhttp;
        albumxmlhttp = new XMLHttpRequest();
        albumxmlhttp.onreadystatechange = function () {
            if (albumxmlhttp.readyState == 4 && albumxmlhttp.status == 200) {
                var x=JSON.parse(albumxmlhttp.responseText);
                Storage.commit("getPhotoInfo", x);
                console.log(Storage.state.photo_info);
                var newarr=[].concat(Storage.state.photo_info);
                var arr=[];
                arr= newarr.reduce((pre, next, idx) => { // reduce 用来便利数组，具体语法就 rtfm 吧
                    const inner = pre[~~(idx / 4)]               // ~~用来取整，inner 是内层数组
                    if (inner !== undefined) {                   // 判断有没有内层数组
                        inner.push(next)                           // 如果有就把遍历的值 next push 到内层数组里
                    } else {
                        pre.push([next])                           // 没有就新建一个包含 next 的数组，作为内层数组
                    }
                    return pre
                }, [[]]);
                console.log(arr);
                Storage.commit("getPhoto",arr);
                console.log(Storage.state.photo);
                //console.log(Storage.state.album_info);
                //console.log(Storage.state.album_info);
                //console.log(Storage.state.album_info[0]);
                //console.log(Storage.state.album_info[0]['a_name']);
            }
        }
        albumxmlhttp.open("GET", '/myApi' + phpaddr + '?owner='+Storage.state.name+'&album='+Storage.state.album, true);

        albumxmlhttp.send();


    },


    methods: {
        deletePhoto(index){
            var name=Storage.state.photo_info[index]['p_address'];

            this.$confirm(
                '确认删除该照片吗？',
                '警告',
                {
                    confirmButtonText: '确认',
                    cancelButtonText: '取消',
                    type: 'warning',
                })
                .then(() => {
                    var arr=[].concat(Storage.state.photo_info);
                    arr.splice(index,1);
                    Storage.commit("getPhotoInfo",arr);
                    var newarr=[].concat(Storage.state.photo_info);
                    arr=[];
                    arr= newarr.reduce((pre, next, idx) => { // reduce 用来便利数组，具体语法就 rtfm 吧
                        const inner = pre[~~(idx / 4)]               // ~~用来取整，inner 是内层数组
                        if (inner !== undefined) {                   // 判断有没有内层数组
                            inner.push(next)                           // 如果有就把遍历的值 next push 到内层数组里
                        } else {
                            pre.push([next])                           // 没有就新建一个包含 next 的数组，作为内层数组
                        }
                        return pre
                    }, [[]]);
                    console.log(arr);
                    Storage.commit("getPhoto",arr);


                    let phpaddr = "album/php/deletePhoto.php";
                    var photoxmlhttp;
                    photoxmlhttp = new XMLHttpRequest();
                    photoxmlhttp.album=this.$route.params.type;
                    photoxmlhttp.onreadystatechange = function () {
                        if (photoxmlhttp.readyState == 4 && photoxmlhttp.status == 200) {
                            var x=this.responseText;
                            console.log(this.responseText);
                        }

                    }
                    photoxmlhttp.open("GET", '/myApi' + phpaddr + '?owner='+Storage.state.name+'&album='+Storage.state.album+'&address='+name, true);

                    photoxmlhttp.send();

                })
                .catch(() => {
                    // catch error
                });
        },







        move(e) {
            //console.log("click");
            e.preventDefault()
            // 获取元素
            var left = document.querySelector('.mySlides')

            //console.log(left.clientWidth);
            //console.log(left.clientHeight);
            var img = document.querySelector('.img')
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
            //console.log(this.$refs.imgDiv.style.zoom)


            var img = document.querySelector('.img');
            var left = document.querySelector('.mySlides');
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

        },

        // 获取数据的方法
        requestData() {var x=document.getElementsByClassName("show");
            console.log(x[0].style);
            //console.log(this.photolist);
            console.log(Storage.state.album_info);

        },
        openModal(index) {

            document.getElementById('myModal').style.display = "block"; console.log("ok");
            this.pic_index=index;
            this.nowphoto=Storage.state.photo_info[index];
            document.getElementsByClassName("mySlides")[0].style.display = "block";
            var img = document.querySelector('.img');
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
            document.getElementById('myModal').style.display = "none";
            var img = document.querySelector('.img');



        },
        NextPic(){
            if(this.pic_index==this.photolist.length-1){
                this.pic_index=0;
            }
            else{
                this.pic_index++;
            }
            this.openModal(this.pic_index);
        },
        PrevPic(){
            if(this.pic_index==0){
                this.pic_index=this.photolist.length-1;
            }
            else{
                this.pic_index--;
            }
            this.openModal(this.pic_index);
        },


    }
}
</script>