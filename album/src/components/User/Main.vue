<template>
    <div class="content-container" direction="vertical">
        <!-- button -->
        <div class="content-row" style="height: 10%">
            <el-container style="vertical-align: middle">
                <el-button type="primary" @click="changeShowType">{{this.$store.state.albumshowtype}}</el-button>
                <el-button type="success" @click="addAlbum">新增相册</el-button>
                <el-radio-group @change="changeOrder" v-model="order" class="album_order">
                    <el-radio label="0" size="large">按时间降序</el-radio>
                    <el-radio label="1" size="large">按时间升序</el-radio>
                    <el-radio label="2" size="large">按名称降序</el-radio>
                    <el-radio label="3" size="large">按名称升序</el-radio>
                    <el-radio label="4" size="large">按大小降序</el-radio>
                    <el-radio label="5" size="large">按大小升序</el-radio>
                </el-radio-group>
            </el-container>
        </div>

        <!-- list -->
        <div class="show" style="height: 88%;overflow: auto">
            <div v-if="showpic">
            <div v-for="(item,albumindex) in album_list" class="row" >
                <div v-for="(pic,picindex) in item" class="column" @click="openModal(albumindex*4+picindex);" >

                    <h3>{{ pic['a_name'] }}</h3>
                    <img onerror="this.style.display='none'" alt="该相册没有图片"  decoding="async" :src="'/myApi'+'album/照片/'+username+'/'+pic['a_name']+'/'+firstphoto[pic['a_name']]" style="width:100%;color: white;"
                          class="hover-shadow cursor">
                    <div style="height: 20px"></div>
                </div>
            </div>
                <!--<div v-for="(item,albumindex) in albumList" @click="openModal(albumindex);" class="column" style="border-style: solid;border-color: white">
                    <div v-for="(pic,picindex) in item" class="column" @click="openModal(albumindex*4+picindex);">

                        <h3>{{ item['a_name'] }}</h3>
                        <img decoding="async" :src="firstphoto[item['a_name']]" style="width:100%"
                             class="hover-shadow cursor">
                    </div>
                </div>-->
            </div>
            <el-table
                v-show="showlist"
                highlight-current-row
                :data="albumList"
                tooltip-effect="dark"
                height="700"
                empty-text="没有数据"
                style="width: 100%">
                <el-table-column
                    width="100">
                    <template #header>
                        <el-input @input="updatealbumlist" v-model="$store.state.filter" size="small" placeholder="筛选" />
                    </template>
                    <template #default="scope">
                        <el-button @click="openModal(scope.$index)" size="small" type="success">打开相册</el-button>
                    </template>
                </el-table-column>
                <el-table-column
                    label="相册名"
                    width="200"
                    prop="a_name">
                    <!--<template #default="scope">
                        <div style="text-align:center"><el-image :src="scope.row.img" style="width: 60px; height: 100px"/></div>
                        <div style="text-align:center">{{scope.row.name}}</div>
                    </template>-->

                </el-table-column>
                <el-table-column
                    label="照片数量"
                    width="100"
                    prop="a_size">
                </el-table-column>
                <el-table-column
                    label="相册简介"

                    prop="a_introduction">
                </el-table-column>
                <el-table-column
                    label="修改日期"
                    width="100"
                    prop="a_edittime">
                </el-table-column>
                <el-table-column
                    width="200">
                    <template #default="scope">
                        <el-button @click="changeAlbum(scope.$index)" size="small">修改</el-button>
                        <el-button size="small" type="danger" @click="deleteAlbum(scope.$index)">删除</el-button>
                    </template>
                </el-table-column>
                <!--<el-table-column
                    label="库存"
                    width="100"
                    prop="count">
                </el-table-column>
                <el-table-column
                    label="退款数量"
                    width="100"
                    prop="back">
                </el-table-column>
                <el-table-column
                    label="退款金额"
                    width="100"
                    prop="backPrice">
                </el-table-column>
                <el-table-column
                    label="操作"
                    width="100"
                    prop="name">
                    <template #default="scope">
                        <el-button @click="operate(scope.row)" :type="scope.row.state ? 'danger':'success'">{{scope.row.state ? '下架':'上架'}}</el-button>
                    </template>
                </el-table-column>
                <el-table-column
                    label="管理员"
                    width="100"
                    prop="owner">
                </el-table-column>
                <el-table-column
                    label="更新时间"
                    prop="time">
                </el-table-column>-->
            </el-table>

        </div>
        <div>

        </div>
    </div>

    <div v-show="create" class="el-overlay is-message-box" style="z-index: 2017;">
        <div role="dialog" aria-modal="true" aria-describedby="el-id-419-14" class="el-overlay-message-box" aria-label="请输入新建相册信息">
            <div class="el-message-box" tabindex="-1">
                <div class="el-message-box__header">
                    <div class="el-message-box__title">
                        <!--v-if-->
                        <span id="create_or_change">请输入新建相册信息</span>
                    </div>
                    <button @click="cancel"  type="button" class="el-message-box__headerbtn" aria-label="Close this dialog">
                        <i class="el-icon el-message-box__close">
                            <svg viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                                <path fill="currentColor" d="M764.288 214.592 512 466.88 259.712 214.592a31.936 31.936 0 0 0-45.12 45.12L466.752 512 214.528 764.224a31.936 31.936 0 1 0 45.12 45.184L512 557.184l252.288 252.288a31.936 31.936 0 0 0 45.12-45.12L557.12 512.064l252.288-252.352a31.936 31.936 0 1 0-45.12-45.184z">
                                </path>
                            </svg>
                        </i>
                    </button>
                </div>
                <div id="el-id-419-14" class="el-message-box__content">
                    <div class="el-message-box__container">
                        <!--v-if-->
                        <div class="el-message-box__message">
                            <label>相册名
                            </label>


                            <div class="el-input">

                                <!-- input -->

                                <!-- prepend slot -->

                                <!--v-if-->

                                <div class="el-input__wrapper">

                                    <!-- prefix slot -->

                                    <!--v-if-->

                                    <input id="newa_name" class="el-input__inner" aria-invalid="false" type="text" autocomplete="off" tabindex="0" placeholder="">

                                    <!-- suffix slot -->

                                    <!--v-if-->

                                </div>

                                <!-- append slot -->

                                <!--v-if-->

                            </div>




                            <label>相册简介（选填）
                            </label>


                            <div class="el-input">

                                <!-- input -->

                                <!-- prepend slot -->

                                <!--v-if-->

                                <div class="el-input__wrapper">

                                    <!-- prefix slot -->

                                    <!--v-if-->

                                    <input id='newa_introduction' class="el-input__inner" aria-invalid="false" type="text" autocomplete="off" tabindex="0" placeholder="">

                                    <!-- suffix slot -->

                                    <!--v-if-->

                                </div>

                                <!-- append slot -->

                                <!--v-if-->

                            </div>
                        </div>
                    </div>
                </div>
                <div class="el-message-box__btns">
                    <button @click="cancel" class="el-button" aria-disabled="false" type="button">
                        <!--v-if-->
                        <span class="">取消</span>
                    </button>
                    <button @click="ok" class="el-button el-button--primary" aria-disabled="false" type="button">
                        <!--v-if-->
                        <span class="">确定</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<style>

.album_order{
    margin-left: 10px;
}
.album_order span{
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
}

.close:hover,
.close:focus {
    color: #999;
    text-decoration: none;
    cursor: pointer;
}

.mySlides {
    display: none;
}

.cursor {
    cursor: pointer
}



.prev {
    left: 0;
}

/* 定位下一页按钮到右侧 */
.next {
    right: 0;
    border-radius: 3px 0 0 3px;
}



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
            showpic:false,  //以图片方式显示
            showlist:true,//以列表方式显示
            nowphoto:"",
            albumList:[],
            //firstphoto:Storage.state.firstphoto,
            firstphotoarr:[],
            create:false,
            change:false,
            goodsData: [],
            update:0,
            pic_index:0,
            newa_name:'',
            newa_introduction:'',
            olda_name:'',
            olda_introduction:'',
            exsit:'',
            firstphoto:'',
            order:'0',  //按时间降序：0；按时间升序：1；按名称降序：2；按名称升序：3；按照片数降序：4；按照片数升序：5
            // 模拟分类数据
            categorys: [
                "全部",
                "男装",
                "女装"
            ],
            queryParams: {
                name: "",
                id: "",
                category: "",
                sellMode: 2, //0 否 1是 2全部
                expMode: 2,
            }
        }
    },
    computed: {
        username(){
            return Storage.state.userName;
        },
        filter() {//筛选相册
            return Storage.state.filter;
        },
        /*firstphoto(){
            var arr=[],i;
            console.log(Storage.state.photolist);
            var key=Object.keys(Storage.state.photolist);
            console.log(Storage.state.photolist);
            console.log(key);
            for(var x of key)
            {
                arr[x]=(Storage.state.photolist[x][0]);
            }
            console.log(arr);
            return this.update>0?arr:arr;
            //return arr;
        },*/
        allalbumList(){
            return Storage.state.album_info;
        },
        album_list(){
            var arr;
            arr= this.albumList.reduce((pre, next, idx) => { // reduce 用来便利数组，具体语法就 rtfm 吧
                const inner = pre[~~(idx / 4)]               // ~~用来取整，inner 是内层数组
                if (inner !== undefined) {                   // 判断有没有内层数组
                    inner.push(next)                           // 如果有就把遍历的值 next push 到内层数组里
                } else {
                    pre.push([next])                           // 没有就新建一个包含 next 的数组，作为内层数组
                }
                return pre
            }, [[]]);
            /*console.log(this.album_list);

            var x=Object.values(this.firstphoto);
            console.log(x);
            this.firstphotoarr=x;
            console.log(this.firstphotoarr);*/
            return arr;
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
    // 组件挂载时获取数据
    mounted() {
        this.changeOrder();
    },
    beforeCreate() {
        this.update+=1;
    },
    beforeMount() {
        this.updatealbumlist();
        this.update+=1;
        var arr=[],i;
        //console.log(Storage.state.photolist);
        var key=Object.keys(Storage.state.photolist);
        //console.log(Storage.state.photolist);
        //console.log(key);
        for(var x of key)
        {
            arr[x]=(Storage.state.photolist[x][0]);
        }
        //console.log(arr);
        this.firstphoto=arr;
    },
    methods: {
        // 显示图片/列表
        changeShowType() {
            var arr=[],i;
            //console.log(Storage.state.photolist);
            console.log(Storage.state.photolist);
            var key=Object.keys(Storage.state.photolist);
            //console.log(Storage.state.photolist);
            //console.log(key);
            for(var x of key)
            {
                if(Storage.state.photolist[x].length===0){
                    //console.log(x);
                    arr[x]='';
                }
                else{
                    //console.log(x,x);
                    arr[x]=(Storage.state.photolist[x][0]['p_address']);
                }
            }
            console.log(arr);
            this.firstphoto=arr;
            //for(var i=0;i<10;i++) this.update+=1;


            this.showlist=!this.showlist;
            this.showpic=!this.showpic;
            if(Storage.state.albumshowtype==='显示图片') Storage.commit('getAlbumShowType','显示列表');
            else Storage.commit('getAlbumShowType','显示图片')
        },
        openModal(index) {
            console.log(index);
            /*document.getElementById('myModal').style.display = "block";
            this.pic_index=index;
            this.nowphoto=this.firstphoto[this.albumList[index]][0];
            document.getElementsByClassName("mySlides")[0].style.display = "block";*/
            //this.$router.push({name: "userhome/order/"+index});
            this.$router.push({path: "order/"+this.albumList[index]['a_name']});

        },
        closeModal() {
            document.getElementById('myModal').style.display = "none";
        },
        NextPic(){
            if(this.pic_index==this.albumList.length-1){
                this.pic_index=0;
            }
            else{
                this.pic_index++;
            }
            this.openModal(this.pic_index);
        },
        PrevPic(){
            if(this.pic_index==0){
                this.pic_index=this.albumList.length-1;
            }
            else{
                this.pic_index--;
            }
            this.openModal(this.pic_index);
        },
        addAlbum() {
            this.create=true;
            this.exsit='0';
            document.getElementById('newa_name').value='';
            document.getElementById('newa_introduction').value='';
            document.getElementById('create_or_change').innerText='请输入新建相册信息';
        },
        cancel(){
            this.create=false;
            this.change=false;
        },
        ok(){
            this.newa_name=document.getElementById('newa_name').value;
            this.newa_introduction=document.getElementById('newa_introduction').value;
            if(this.newa_name===''){
                ElMessage({
                    message: '相册名称不能为空',
                    type: 'error',
                    duration: 1500
                })
                return;
            }

            var newa_edittime;

            let phpaddr = "album/php/addAlbum.php";
            var albumxmlhttp;
            albumxmlhttp = new XMLHttpRequest();
            albumxmlhttp.onreadystatechange = function () {
                if (albumxmlhttp.readyState == 4 && albumxmlhttp.status == 200) {
                    newa_edittime=albumxmlhttp.responseText;
                    //console.log(Storage.state.album_info);
                    //console.log(Storage.state.album_info);
                    //console.log(Storage.state.album_info[0]);
                    //console.log(Storage.state.album_info[0]['a_name']);
                    console.log(albumxmlhttp.responseText);
                }
            }
            albumxmlhttp.open("GET", '/myApi' + phpaddr + '?oldname='+this.olda_name+'&oldintroduction='+this.olda_introduction+'&exsit='+this.exsit+'&owner='+Storage.state.userName+'&name='+this.newa_name+'&introduction='+this.newa_introduction, false);

            albumxmlhttp.send();
            if(newa_edittime==='false'){
                ElMessage({
                    message: '该相册名已存在',
                    type: 'error',
                    duration: 1500
                })
                return;
            }

            Storage.state.photolist[this.newa_name]=[];
            var p= {};
            p['a_name']=this.newa_name;
            p['a_introduction']=this.newa_introduction;
            p['a_edittime']=newa_edittime;
            p['a_size']=0;
            console.log(Storage.state.album_info);
            var arr=[].concat(Storage.state.album_info);
            console.log(arr);
            if(this.exsit==='0') arr.push(p);
            else{
                for(var i=0;i<arr.length;i++){
                    if(arr[i]['a_name']==this.olda_name){
                        arr[i]['a_name']=this.newa_name;
                        arr[i]['a_introduction']=this.newa_introduction;
                        arr[i]['a_edittime']=newa_edittime;
                    }
                }
            }
            Storage.commit('getAlbumInfo',arr);
            this.order='0';
            this.changeOrder();
            this.create=false;
        },
        changeOrder(){
            var compare = function(name,fun){
                return function(o,p){
                    var a,b;
                    if(o && p && typeof o === 'object' && typeof p ==='object'){
                        a = o[name];
                        b = p[name];
                        if(name==='a_name'){
                            return b.localeCompare(a, 'zh-CN');
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
            var rcompare = function(name,fun){
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
                            return a > b ? -1:1;
                        }
                        return typeof a > typeof b ? -1 : 1;
                    }
                }
            };
            if(this.order==='0') this.allalbumList.sort(rcompare('a_edittime'));
            else if(this.order==='1') this.allalbumList.sort(compare('a_edittime'));
            else if(this.order==='2') this.allalbumList.sort(compare('a_name'));
            else if(this.order==='3') this.allalbumList.sort(rcompare('a_name'));
            else if(this.order==='4') this.allalbumList.sort(rcompare('a_size'));
            else if(this.order==='5') this.allalbumList.sort(compare('a_size'));
            this.updatealbumlist();
        },
        updatealbumlist(){
            if(this.filter===''){
                this.albumList=this.allalbumList;
            }
            else{
                this.albumList=[];
                for(var i=0;i<this.allalbumList.length;i++)
                {
                    console.log(this.allalbumList[i]['a_name']);
                    console.log(this.filter);
                    if(this.allalbumList[i]['a_name'].match(this.filter)){
                        this.albumList.push(this.allalbumList[i]);
                    }
                }
            }
        },
        deleteAlbum(index){
            var name=this.albumList[index]['a_name'];
            console.log(name);
            this.$confirm(
                '确认删除该相册吗？（注意，相册内如果有照片，照片也会被删除，该操作不可逆。）',
                '警告',
                {
                    confirmButtonText: '确认',
                    cancelButtonText: '取消',
                    type: 'warning',
                })
                .then(() => {
                    let phpaddr = "album/php/deleteAlbum.php";
                    var albumxmlhttp;
                    albumxmlhttp = new XMLHttpRequest();
                    albumxmlhttp.onreadystatechange = function () {
                        if (albumxmlhttp.readyState == 4 && albumxmlhttp.status == 200) {
                            //
                        }
                    }
                    albumxmlhttp.open("GET", '/myApi' + phpaddr + '?owner='+Storage.state.userName+'&name='+name, false);

                    albumxmlhttp.send();
                    var i;
                    for(i=0;i<Storage.state.album_info.length;i++){
                        if(Storage.state.album_info[i]['a_name']===name){
                            break;
                        }
                    }
                    var arr=[].concat(Storage.state.album_info);
                    arr.splice(i,1);
                    Storage.commit('getAlbumInfo',arr);
                    this.order='0';
                    this.changeOrder();
                })
                .catch(() => {
                    // catch error
                });


        },
        changeAlbum(index){
            this.olda_name=this.albumList[index]['a_name'];
            this.olda_introduction=this.albumList[index]['a_introduction'];
            this.create=true;
            this.exsit='1';
            document.getElementById('newa_name').value=this.olda_name;
            document.getElementById('newa_introduction').value=this.olda_introduction;
            document.getElementById('create_or_change').innerText='请输入修改相册信息';
        }
    }
}
</script>