<template>
    <div class="info">
        <div class="usermsg">
            <h4>用户名：{{name}}</h4>
        </div>
        <div class="headimg">
            <h4>头像：</h4>
        <img style="width:100px;height:100px;border-radius:50%;margin:auto;margin-right:0;" :src="'http://localhost/album/头像/'+head"/>
            <el-button type="primary" style="position:relative;bottom: -67px;">更改头像</el-button>
        </div>
        <div class="usermsg">
            <h4>性别：{{sex}}</h4>
        </div>
        <div class="usermsg">
            <h4>出生日期：{{birthday}}</h4>
        </div>
        <div class="usermsg">
            <h4>个性签名：{{signature}}</h4>
        </div>

        <div class="usermsg">
            <h4>状态： <span style="float: right;color: greenyellow" >{{status}}</span> </h4>
        </div>

        <div class="usermsg">
            <h4>注册时间：{{registertime}}</h4>
        </div>
        <el-button @click="changeInfo" type="primary" style="float:left;position:relative;bottom: -67px;">修改信息</el-button>
        <el-button type="warning" style="float:left;position:relative;bottom: -67px;">修改密码</el-button>
    </div>
    <div v-show="edit" class="el-overlay is-message-box" style="z-index: 2017;">
        <div role="dialog" aria-modal="true" aria-describedby="el-id-419-14" class="el-overlay-message-box" aria-label="请输入新建相册信息">
            <div class="el-message-box" tabindex="-1">
                <div class="el-message-box__header">
                    <div class="el-message-box__title">
                        <!--v-if-->
                        <span id="create_or_change">请输入修改用户信息</span>
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
                            <label>用户名
                            </label>


                            <div class="el-input">

                                <!-- input -->

                                <!-- prepend slot -->

                                <!--v-if-->

                                <div class="el-input__wrapper">

                                    <!-- prefix slot -->

                                    <!--v-if-->

                                    <input v-model="name" id="newu_name" class="el-input__inner" aria-invalid="false" type="text" autocomplete="off" tabindex="0" placeholder="">

                                    <!-- suffix slot -->

                                    <!--v-if-->

                                </div>

                                <!-- append slot -->

                                <!--v-if-->

                            </div>

                            <div>
                                <label>性别
                                </label>

                                <el-radio-group v-model="sex" class="ml-4">
                                    <el-radio label="男" size="large">男</el-radio>
                                    <el-radio label="女" size="large">女</el-radio>
                                </el-radio-group>
                            </div>


                            <div>
                                <label>出生日期
                                </label>

                                <el-date-picker
                                    v-model="birthday"
                                    type="date"
                                    placeholder="选择一个日期"
                                    value-format="YYYY-MM-DD"
                                    :size="size"
                                />
                            </div>



                            <label>个性签名（选填）
                            </label>


                            <div class="el-input">

                                <!-- input -->

                                <!-- prepend slot -->

                                <!--v-if-->

                                <div class="el-input__wrapper">

                                    <!-- prefix slot -->

                                    <!--v-if-->

                                    <input v-model="signature" id='newu_signature' class="el-input__inner" aria-invalid="false" type="text" autocomplete="off" tabindex="0" placeholder="">

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

<script>
import Storage from "@/tools/Storage";
export default {
    data(){
        return{
            name:Storage.state.userName,
            head:Storage.state.head,
            sex:Storage.state.sex,
            birthday:Storage.state.birthday,
            signature:Storage.state.signature,
            status:Storage.state.status,
            registertime:Storage.state.registertime,
            oldname:'',
            oldsex:'',
            oldbirthday:'',
            oldsignature:'',
            edit:false,
        }
    },
    mounted() {

    },
    methods:{
        changeInfo(){
            this.edit=true;
            this.oldname=this.name;
            this.oldsex=this.sex;
            this.oldbirthday=this.birthday;
            this.oldsignature=this.signature;
        },
        cancel(){
            this.name=this.oldname;
            this.sex=this.oldsex;
            this.birthday=this.oldbirthday;
            this.signature=this.oldsignature;
            this.edit=false;
        },
        ok(){
            this.$confirm(
                '请确认修改信息无误，修改无法撤回。',
                '警告',
                {
                    confirmButtonText: '确认',
                    cancelButtonText: '取消',
                    type: 'warning',
                })
                .then(() => {
                    let phpaddr = "album/php/updateUser.php";
                    var userxmlhttp;
                    userxmlhttp = new XMLHttpRequest();
                    userxmlhttp.onreadystatechange = function () {
                        if (userxmlhttp.readyState == 4 && userxmlhttp.status == 200) {
                            //
                        }
                    }
                    userxmlhttp.open("GET", '/myApi' + phpaddr + '?user='+Storage.state.userName+'&name='+this.name+'&sex='+this.sex+'' +
                        '&birthday='+this.birthday+'&signature='+this.signature, false);

                    userxmlhttp.send();


                    Storage.commit('getUserInformation',{
                        head:this.head,
                        sex:this.sex,
                        birthday:this.birthday,
                        signature:this.signature,
                        status:this.status,
                        registertime:this.registertime,
                    })
                    Storage.commit('getUserName',this.name);
                    console.log(Storage.state.userName);
                    this.edit=false;
                })
                .catch(() => {
                    // catch error
                });


        },
    },
}
</script>

<style scoped>
.info{
    color: white;

}
.usermsg{
    position: relative;
    height: 50px !important;
}
.usermsg *,.headimg *{
    float: left;
}
.headimg{
    position: relative;
    height: 120px !important;
}

</style>