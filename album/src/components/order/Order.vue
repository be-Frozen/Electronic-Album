<template>
    <div class="content-container" direction="vertical">
        <!-- button -->
        <div class="content-row" style="height: 10%">
            <el-container>

                <!--:headers="upHeaders"-->
                <el-upload
                    style="margin-right: 10px;margin-left: 10px;"
                    class="upload-demo"
                    :action="myApi"
                    accept="image/*"
                    :on-preview="handlePreview"
                    :on-remove="handleRemove"
                    :before-remove="beforeRemove"
                    multiple
                    :show-file-list="false"
                    :before-upload="beforeUpload"
                    :on-exceed="handleExceed"
                    :on-success="handleSuccess"
                    :on-error="handleError">
                    <el-button type="success">新增照片</el-button>
                </el-upload>
                <el-button type="danger" @click="backmain">返回主页</el-button>
                <el-radio-group @change="changeOrder" v-model="order" class="album_order">
                    <el-radio label="0" size="large">按上传时间降序</el-radio>
                    <el-radio label="1" size="large">按上传时间升序</el-radio>
                    <el-radio label="2" size="large">按名称降序</el-radio>
                    <el-radio label="3" size="large">按名称升序</el-radio>
                </el-radio-group>
            </el-container>
        </div>

        <!-- list -->
        <div class="show" style="height: 88%;overflow: auto">
            <!--<img style="width: 20%;" src="~@/assets/1.png">
            <img style="width:35px;height:35px;border-radius:50%;margin:auto;margin-right:0;"
                 src="~@/assets/logo.jpg"/>-->
            <div v-for="(item,index) in photo_list" class="row">
                <div v-for="(pic,picindex) in item" class="column">
                    <!--<img decoding="async" :src="'http://localhost/album/原神/'+albumname+'/'+pic" style="width:100%"
                         @click="openModal(index*4+picindex);" class="hover-shadow cursor">-->
                    <img decoding="async" :src="'/myApi'+'album/照片/'+username+'/'+$route.params.type+'/'+pic['p_address']" style="width:100%"
                         @click="openModal(index*4+picindex);" class="hover-shadow cursor">
                    <h3>{{photoname[index*4+picindex]}}<button @click="deletePhoto(index*4+picindex)" class="deletephoto">×</button></h3>
                    <div style="height: 20px"></div>
                </div>
            </div>

            <div id="myModal" class="modal">
                <div style="position: absolute;width: 100%;height: 100%;background-color: rgb(0 0 0 / 46%);"
                     @click="closeModal()"></div>
                <div class="modal-content" style="height: 100%;width: 100%">
                    <div  @mousewheel="rollImg" class="mySlides" style="width: 100%; height: 100%;">
                        <div class="numbertext">{{pic_index+1}}/{{photolist.length}}</div>
                        <!--<div class="close" @click="closeModal">×</div>-->
                        <div class="close" @click="closeModal">×</div>
                        <img ref="imgDiv" class="img" @mousedown="move" decoding="async" :src="'/myApi'+'album/照片/'+username+'/'+$route.params.type+'/'+nowphoto['p_address']">
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
    computed: {
        username(){
            return Storage.state.userName;
        },
        photolist(){
            console.log(this.$route.params.type);
            console.log(Storage.state.photolist);


            //scroll[0].style.scroll.scrollTop = 0;
            //console.log(Object.values(Storage.state.photolist[this.$route.params.type]));
            return Storage.state.photolist[this.$route.params.type];

        },
        photo_list(){
            var newarr=this.photolist;
            console.log(newarr);
            var compare = function(name,fun){
                return function(o,p){
                    var a,b;
                    if(o && p && typeof o === 'object' && typeof p ==='object'){
                        a = o[name];
                        b = p[name];
                        if(name==='p_address'){
                            return b.localeCompare(a, 'zh-CN');
                        }
                        //当o[name] 和 p[name] 相等时，利用fun函数根据另一个属性来进行比较
                        if(a === b){
                            a=o['p_address'];
                            b=p['p_address'];
                            return a.localeCompare(b, 'zh-CN');
                        }
                        if(typeof a === typeof b){
                            return a < b ? -1:1;
                        }
                        return typeof a < typeof b ? -1 : 1;
                    }
                }
            };
            var rcompare = function(name,fun){
                return function(o,p){
                    var a,b;
                    if(o && p && typeof o === 'object' && typeof p ==='object'){
                        a = o[name];
                        b = p[name];
                        if(name==='p_address'){
                            return a.localeCompare(b, 'zh-CN');
                        }
                        //当o[name] 和 p[name] 相等时，利用fun函数根据另一个属性来进行比较
                        if(a === b){
                            a=o['p_address'];
                            b=p['p_address'];
                            return a.localeCompare(b, 'zh-CN');
                        }
                        if(typeof a === typeof b){
                            return a > b ? -1:1;
                        }
                        return typeof a > typeof b ? -1 : 1;
                    }
                }
            };
            if(this.order==='0') newarr.sort(rcompare('p_time'));
            else if(this.order==='1') newarr.sort(compare('p_time'));
            else if(this.order==='2') newarr.sort(compare('p_address'));
            else if(this.order==='3') newarr.sort(rcompare('p_address'));
            var list=Object.create(Storage.state.photolist);
            console.log(list);
            list[this.$route.params.type]=arr;
            //Storage.commit('getPhotoList',list);
            console.log(Storage.state.photolist);
            console.log(this.photo_list);
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
            return arr;
        },
        photoname(){
          var arr=[];
          for(var i=0;i<this.photolist.length;i++)
          {
              arr.push(this.photolist[i]['p_address'].substr(this.photolist[i]['p_address'].lastIndexOf('/')+1));
              //arr.push("text");
              //console.log(this.photolist[i]);
          }
          //console.log(arr);
          return this.update>0?arr:arr;
        },
        albumname(){
            //console.log(Storage.state.album);
            return Storage.state.album;

        },
        sellModeString: {
            get() {
                if (this.queryParams.sellMode == 2) {
                    return '全部'
                }
                return this.queryParams.sellMode == 0 ? '否' : '是'
            },
            set(val) {
                this.queryParams.sellMode = val
            }
        },
        expModeString: {
            get() {
                if (this.queryParams.expMode == 2) {
                    return '全部'
                }
                return this.queryParams.expMode == 0 ? '否' : '是'
            },
            set(val) {
                this.queryParams.expMode = val
            }

        }
    },
    watch: {
        //'$route.params.type' (to, from) {

    },
    // 组件挂载时获取数据
    mounted() {
        //this.photolist=Object.values(Storage.state.photolist[this.$route.params.type]);

        this.changeOrder();



    },
    // 路由更新时刷新数据
    beforeRouteUpdate(to) {
        var x=document.getElementsByClassName("show");
        //console.log(x[0].style);
        x[0].scrollTop=0;
    },

    beforeCreate() {




        /*//let phpaddr="index.php";
        axios
            //.post('http://localhost/album/php/outdir.php')
            .get('/'+phpaddr)
            .then(response => (console.log(response.data)))
            .catch(function (error) { // 请求失败处理
                console.log(error);
            });

        console.log(this.goodsData);
        console.log("???");*/
    },

    methods: {
        deletePhoto(index){
            var name=this.photolist[index]['p_address'];

            this.$confirm(
                '确认删除该照片吗？',
                '警告',
                {
                    confirmButtonText: '确认',
                    cancelButtonText: '取消',
                    type: 'warning',
                })
                .then(() => {
                    var arr=Storage.state.photolist;
                    var i;
                    for(i=0;i<arr[this.$route.params.type].length;i++){
                        if(arr[this.$route.params.type][i]['p_address']===name){
                            arr[this.$route.params.type].splice(i,1);
                            break;
                        }
                    }
                    console.log('delete');
                    let phpaddr = "album/php/deletePhoto.php";
                    var photoxmlhttp;
                    photoxmlhttp = new XMLHttpRequest();
                    photoxmlhttp.album=this.$route.params.type;
                    photoxmlhttp.onreadystatechange = function () {
                        if (photoxmlhttp.readyState == 4 && photoxmlhttp.status == 200) {
                            var x=this.responseText;
                            console.log(this.responseText);
                            var newarr=Storage.state.album_info;

                            for(var i=0;i<newarr.length;i++){
                                if(newarr[i]['a_name']===this.album){
                                    console.log(newarr[i]['a_size']);
                                    console.log(Storage.state.album_info[i]['a_size']);
                                    newarr[i]['a_size']=parseInt(newarr[i]['a_size'])-1;
                                    newarr[i]['a_edittime']=x;
                                    break;
                                }

                            }
                        }

                    }
                    photoxmlhttp.open("GET", '/myApi' + phpaddr + '?owner='+Storage.state.userName+'&album='+this.$route.params.type+'&address='+name, false);

                    photoxmlhttp.send();

                })
                .catch(() => {
                    // catch error
                });
        },


        // 删除文件钩子
        handleRemove(file, fileList) {
            console.log(file, fileList)
        },
        // 已上传文件钩子
        handlePreview(file) {
            console.log(file)
        },
        // 文件上传前的钩子(这里可以对文件上传时的后缀进行限制)
        beforeUpload(file) {
            /*var FileExt = file.name.replace(/.+\./, '')
            if (['jpg', 'JPG'].indexOf(FileExt) === -1) {
                this.$message({
                    type: 'warning',
                    message: '请上传后缀名为 json 的文件！',
                })
                return false
            }*/
        },
        // 上传文件个数限制钩子
        handleExceed(files, fileList) {
            this.$message.warning(`当前限制选择 1 个文件，本次选择了 ${files.length} 个文件，共选择了 ${files.length + fileList.length} 个文件`)
        },
        // 删除文件前的钩子
        beforeRemove(file, fileList) {
            return this.$confirm(`确定移除 ${ file.name }？`);
        },
        // 上传失败钩子
        handleError(err, file, fileList) {
            this.$message.error(err.errormsg)
        },
        // 上传成功钩子(在这里可以处理上传成功后端返回的数据)
        handleSuccess(req, file, fileList) {
            console.log(req)
            var name=req;
            let phpaddr = "album/php/addPhoto.php";
            var photoxmlhttp;
            photoxmlhttp = new XMLHttpRequest();
            photoxmlhttp.album=this.$route.params.type;
            photoxmlhttp.onreadystatechange = function () {
                if (photoxmlhttp.readyState == 4 && photoxmlhttp.status == 200) {
                    var x=photoxmlhttp.responseText;
                    if(x==='同名图片已存在'){
                        ElMessage({
                            message: '同名图片已存在',
                            type: 'error',
                            duration: 1500
                        })
                    }
                    else {
                        x = JSON.parse(photoxmlhttp.responseText);

                        console.log(x);

                        var arr = Storage.state.photolist;
                        console.log(arr);
                        arr[this.album].push(x['photo']);
                        console.log(arr[this.album]);
                        var newarr=Storage.state.album_info;

                        for(var i=0;i<newarr.length;i++){
                            if(newarr[i]['a_name']===this.album){
                                console.log(newarr[i]['a_size']);
                                console.log(Storage.state.album_info[i]['a_size']);
                                newarr[i]['a_size']=parseInt(newarr[i]['a_size'])+1;
                                newarr[i]['a_edittime']=x['time'];
                                break;
                            }

                        }
                        //Storage.commit("getAlbumInfo", x);
                        //console.log(Storage.state.album_info);
                        //console.log(Storage.state.album_info);
                        //console.log(Storage.state.album_info[0]);
                        //console.log(Storage.state.album_info[0]['a_name']);
                    }
                }
            }
            photoxmlhttp.open("GET", '/myApi' + phpaddr + '?owner='+Storage.state.userName+'&album='+this.$route.params.type+'&address='+name, false);

            photoxmlhttp.send();
            //console.log(req.data.path);
            //console.log(file);

        },


        upload(param) {
            console.log(param.file);
            const formData = new FormData()
            formData.append('file', param.file)
            const url = '/myApi'+'album/temp'
            this.$http.post(url, formData).then((res) => {
                console.log('ok');
                console.log(res)
            })
        },

        uploadimg(res,file,files){
            console.log(file);
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


        openModal(index) {

            document.getElementById('myModal').style.display = "block";
            this.pic_index=index;
            this.nowphoto=this.photolist[index];
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
        backmain(){
            this.$router.push("/userhome");
        },
        changeOrder(){
            /*var newarr=this.photolist;
            console.log(newarr);
            var compare = function(name,fun){
                return function(o,p){
                    var a,b;
                    if(o && p && typeof o === 'object' && typeof p ==='object'){
                        a = o[name];
                        b = p[name];
                        if(name==='p_address'){
                            return b.localeCompare(a, 'zh-CN');
                        }
                        //当o[name] 和 p[name] 相等时，利用fun函数根据另一个属性来进行比较
                        if(a === b){
                            a=o['p_address'];
                            b=p['p_address'];
                            return a.localeCompare(b, 'zh-CN');
                        }
                        if(typeof a === typeof b){
                            return a < b ? -1:1;
                        }
                        return typeof a < typeof b ? -1 : 1;
                    }
                }
            };
            var rcompare = function(name,fun){
                return function(o,p){
                    var a,b;
                    if(o && p && typeof o === 'object' && typeof p ==='object'){
                        a = o[name];
                        b = p[name];
                        if(name==='p_address'){
                            return a.localeCompare(b, 'zh-CN');
                        }
                        //当o[name] 和 p[name] 相等时，利用fun函数根据另一个属性来进行比较
                        if(a === b){
                            a=o['p_address'];
                            b=p['p_address'];
                            return a.localeCompare(b, 'zh-CN');
                        }
                        if(typeof a === typeof b){
                            return a > b ? -1:1;
                        }
                        return typeof a > typeof b ? -1 : 1;
                    }
                }
            };
            if(this.order==='0') newarr.sort(rcompare('p_time'));
            else if(this.order==='1') newarr.sort(compare('p_time'));
            else if(this.order==='2') newarr.sort(compare('p_address'));
            else if(this.order==='3') newarr.sort(rcompare('p_address'));
            var list=Object.create(Storage.state.photolist);
            console.log(list);
            list[this.$route.params.type]=arr;
            //Storage.commit('getPhotoList',list);
            console.log(Storage.state.photolist);
            console.log(this.photo_list);
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
            this.photo_list=arr;
            console.log(this.photo_list);*/
        },
    }
}
</script>