<template>
    <div class="content-container" direction="vertical">

        <!-- list -->
        <div class="show" style="height: 98%;overflow: auto">
            <div v-if="showpic">
                <div v-for="(item,albumindex) in album_list" class="row" >
                    <div v-for="(pic,picindex) in item" class="column" @click="openModal(albumindex*4+picindex);" >

                        <h3>{{ pic['a_name'] }}</h3>
                        <img onerror="this.style.display='none'" alt="该相册没有图片"  decoding="async" :src="'/myApi'+'album/照片/'+username+'/'+pic['a_name']+'/'+firstphoto[pic['a_name']]" style="width:100%;color: white;"
                             class="hover-shadow cursor">
                        <div style="height: 20px"></div>
                    </div>
                </div>
            </div>
            <el-table
                highlight-current-row
                :data="this.$store.state.album_info"
                tooltip-effect="dark"
                height="750"
                empty-text="没有数据"
                style="width: 100%">
                <el-table-column
                    label="所有者"
                    width="100">
                    <p>{{this.$store.state.name}}</p>
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
                    width="200"
                    prop="a_edittime">
                </el-table-column>
                <el-table-column
                    width="200">
                    <template #default="scope">
                        <el-button @click="openModal(scope.$index)" size="small" type="success">打开相册</el-button>
                        <el-button size="small" type="danger" @click="deleteAlbum(scope.$index)">删除</el-button>
                    </template>
                </el-table-column>
            </el-table>

        </div>
        <div>

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
        }
    },
    computed: {

    },
    // 组件挂载时获取数据
    mounted() {
        Storage.commit("getAlbumFlag",false);
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
        albumxmlhttp.open("GET", '/myApi' + phpaddr + '?order=0&name='+Storage.state.name, false);

        albumxmlhttp.send();


    },

    methods: {
        openModal(index) {
            Storage.commit("getAlbumName",Storage.state.album_info[index]['a_name']);

            this.$router.push({path: "/adminhome/photoadmin/"+Storage.state.name+"/"+Storage.state.album_info[index]['a_name']});

        },
        deleteAlbum(index){
            var name=Storage.state.album_info[index]['a_name'];
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
                    albumxmlhttp.open("GET", '/myApi' + phpaddr + '?owner='+Storage.state.name+'&name='+name, true);

                    albumxmlhttp.send();
                    var arr=[].concat(Storage.state.album_info);
                    arr.splice(index,1);
                    Storage.commit('getAlbumInfo',arr);
                })
                .catch(() => {
                    // catch error
                });


        },
    }
}
</script>