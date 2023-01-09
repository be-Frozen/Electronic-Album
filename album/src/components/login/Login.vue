<template>
    <div id="container">
        <div class="container">
            <div class="form-box">
                <!-- 注册 -->
                <div class="register-box hidden">
                    <img style="width:150px;height:150px;border-radius:50%;" src="~@/assets/logo.jpg"/>
                    <br/>
                    <h1>注册</h1>
                    <div class="input">
                        <el-icon style="color: white;position: relative;left: 4px;top: 4px;margin: auto;">
                            <User/>
                        </el-icon>
                        <input type="text" placeholder="用户名" v-model="name">
                    </div>
                    <div class="input">
                        <el-icon style="color: white;position: relative;left: 4px;top: 4px;margin: auto;">
                            <Lock/>
                        </el-icon>
                        <input type="password" placeholder="密码" v-model="password" autocomplete="new-password">
                    </div>
                    <div class="input">
                        <el-icon style="color: white;position: relative;left: 4px;top: 4px;margin: auto;">
                            <Lock/>
                        </el-icon>
                        <input type="password" placeholder="确认密码" v-model="password2" autocomplete="new-password">
                    </div>
                    <button @click="register">注册</button>
                </div>
                <!-- 登录 -->
                <div class="login-box">
                    <img style="width:150px;height:150px;border-radius:50%;" src="~@/assets/logo.jpg"/>
                    <br/>
                    <h1>登录</h1>
                    <div class="input">
                        <el-icon style="color: white;position: relative;left: 4px;top: 4px;margin: auto;">
                            <User/>
                        </el-icon>
                        <input type="text" placeholder="用户名" v-model="name">
                    </div>
                    <div class="input">
                        <el-icon style="color: white;position: relative;left: 4px;top: 4px;margin: auto;">
                            <Lock/>
                        </el-icon>
                        <input type="password" placeholder="密码" v-model="password" autocomplete="new-password">
                    </div>
                    <!--<button @keyup.enter="login" @click="login" :disabled="disabled">登录</button>-->
                    <button @click="login">登录</button>
                    <el-container>
                        <el-checkbox v-model="admin"></el-checkbox>
                        <h5 style="margin-top: 8px; margin-left: 7px; color:white;float:left;">以管理员身份登录</h5>
                    </el-container>
                </div>
            </div>
            <div class="con-box left">
                <h2 class="title">欢迎来到<span>响当当相册</span></h2>
                <p>快来领取你的专属<span>相册</span>吧</p>
                <img src="~@/assets/1.png" alt="" class="smaller">
                <p>已有账号</p>
                <button id="login">去登录</button>
            </div>
            <div class="con-box right">
                <h2 class="title">欢迎来到<span>响当当相册</span></h2>
                <p>快来看看你的难忘<span>瞬间</span>吧</p>
                <img src="~@/assets/2.png" alt="" class="smaller">
                <p>没有账号？</p>
                <button id="register">去注册</button>
            </div>
        </div>

    </div>


</template>

<script>
import Storage from '../../tools/Storage'
import {ElMessage} from 'element-plus';


export default {
    // eslint-disable-next-line vue/multi-word-component-names
    name: "Login",
    data() {
        return {
            name: "",   //用户名
            password: "",   //密码
            password2:"",   //确认密码
            admin:false,

        }
    },
    mounted() {
        this.name = ""
        this.password = ""
        // 要操作到的元素
        let login = document.getElementById('login');
        let register = document.getElementById('register');
        let form_box = document.getElementsByClassName('form-box')[0];
        let register_box = document.getElementsByClassName('register-box')[0];
        let login_box = document.getElementsByClassName('login-box')[0];
        // 去注册按钮点击事件
        register.addEventListener('click', () => {
            form_box.style.transform = 'translateX(80%)';
            login_box.classList.add('hidden');
            register_box.classList.remove('hidden');
        })
        // 去登录按钮点击事件
        login.addEventListener('click', () => {
            form_box.style.transform = 'translateX(0%)';
            register_box.classList.add('hidden');
            login_box.classList.remove('hidden');
        })
    },
    computed: {
        disabled() {
            return this.name.length == 0 || this.password.length == 0;
        }
    },
    methods: {
        login() {
            if(this.name.length===0)
            {
                ElMessage({
                    message: '用户名不能为空',
                    type: 'error',
                    duration: 1500
                })
                return;
            }
            if(this.password.length===0)
            {
                ElMessage({
                    message: '密码不能为空',
                    type: 'error',
                    duration: 1500
                })
                return;
            }

            if(this.admin){
                let adminphpaddr = "album/php/adminlogin.php";
                var adminxmlhttp;
                adminxmlhttp = new XMLHttpRequest();
                adminxmlhttp.success=false;
                adminxmlhttp.onreadystatechange = function () {
                    if (adminxmlhttp.readyState === 4 && adminxmlhttp.status === 200) {
                        var x=adminxmlhttp.responseText;
                        adminxmlhttp.success=x=="true"?true:false;
                        //console.log(x);
                    }
                }
                //xmlhttp.open("GET", '/' + phpaddr + '?name='+this.name+'&password=', false);
                adminxmlhttp.open("GET", '/myApi' + adminphpaddr + '?name='+this.name+'&password=', false);
                adminxmlhttp.send();
                if(!adminxmlhttp.success) {
                    ElMessage({
                        message: '管理员账号不存在',
                        type: 'error',
                        duration: 1500
                    })
                    return;
                }

                //xmlhttp.open("GET", '/' + phpaddr + '?name='+this.name+'&password='+this.password, false);
                adminxmlhttp.open("GET", '/myApi' + adminphpaddr + '?name='+this.name+'&password='+this.password, false);
                adminxmlhttp.send();

                if(adminxmlhttp.success) {
                    Storage.commit("registUserInfo", {
                        name: this.name,
                        password: this.password
                    })
                    ElMessage({
                        message: '登录成功',
                        type: 'success',
                        duration: 1500
                    })
                    setTimeout(() => {
                        this.$router.push({name: "adminhome"})
                    }, 1500);
                    return;
                }
                else{
                    ElMessage({
                        message: '密码错误，请重新输入',
                        type: 'error',
                        duration: 1500
                    })
                    return;
                }
            }

            let phpaddr = "album/php/login.php";
            var xmlhttp;
            var success=false;
            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    var x=xmlhttp.responseText;
                    success=x=="true"?true:false;
                    //console.log(x);
                }
            }
            //xmlhttp.open("GET", '/' + phpaddr + '?name='+this.name+'&password=', false);
            xmlhttp.open("GET", '/myApi' + phpaddr + '?name='+this.name+'&password=', false);
            xmlhttp.send();
            if(!success) {
                ElMessage({
                    message: '账号不存在，请先注册',
                    type: 'error',
                    duration: 1500
                })
                return;
            }

            //xmlhttp.open("GET", '/' + phpaddr + '?name='+this.name+'&password='+this.password, false);
            xmlhttp.open("GET", '/myApi' + phpaddr + '?name='+this.name+'&password='+this.password, false);
            xmlhttp.send();

            if(success) {
                Storage.commit("registUserInfo", {
                    name: this.name,
                    password: this.password
                })
                ElMessage({
                    message: '登录成功',
                    type: 'success',
                    duration: 1500
                })
                setTimeout(() => {
                    this.$router.push({name: "userhome"})
                }, 1500);
            }
            else{
                ElMessage({
                    message: '密码错误，请重新输入',
                    type: 'error',
                    duration: 1500
                })
                return;
            }
        },
        register(){
            if(this.name.length===0)
            {
                ElMessage({
                    message: '用户名不能为空',
                    type: 'error',
                    duration: 1500
                })
                return;
            }

            if(this.password.length===0||this.password2===0||this.password!==this.password2){
                ElMessage({
                    message: '密码未输入或两次输入不一致，请重新输入',
                    type: 'error',
                    duration: 1500
                })
                return;
            }

            let phpaddr = "album/php/register.php";
            var xmlhttp;
            var success=false;
            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    var x=xmlhttp.responseText;
                    success=x=="true"?true:false;
                    //console.log(x);
                }
            }
            //xmlhttp.open("GET", '/' + phpaddr + '?name='+this.name+'&password=', false);
            xmlhttp.open("GET", '/myApi' + phpaddr + '?name='+this.name+'&password=', false);
            xmlhttp.send();
            if(success) {
                ElMessage({
                    message: '用户名已存在',
                    type: 'error',
                    duration: 1500
                })
                return;
            }

            //xmlhttp.open("GET", '/' + phpaddr + '?name='+this.name+'&password='+this.password, false);
            xmlhttp.open("GET", '/myApi' + phpaddr + '?name='+this.name+'&password='+this.password, false);
            xmlhttp.send();

            if(success) {
                Storage.commit("registUserInfo", {
                    name: this.name,
                    password: this.password
                })
                ElMessage({
                    message: '注册成功，自动进行登录',
                    type: 'success',
                    duration: 1500
                })
                setTimeout(() => {
                    this.$router.push({name: "userhome"})
                }, 1500);
            }
            else{
                ElMessage({
                    message: '注册失败',
                    type: 'error',
                    duration: 1500
                })
                return;
            }

        }
    },

}
</script>

<style scoped>
#container {
    height: 100%;
    width: 100%;
    position: absolute;
}

#title {
    text-align: center;
    color: azure;
    margin-top: 200px;
}

* {
    /* 初始化 */
    margin: 0;
    padding: 0;
}

body {
    /* 100%窗口高度 */
    height: 100vh;
    /* 弹性布局 水平+垂直居中 */
    display: flex;
    justify-content: center;
    align-items: center;
    /* 渐变背景 */
    background: linear-gradient(200deg, #f3e7e9, #e3eeff);
}


.container {
    background-color: #fff;
    width: 812px;
    height: 519px;
    /* 相对定位 */
    position: absolute;
    border-radius: 5px;
    /* 阴影 */
    box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.1);
    margin: auto;
    top: 0;
    bottom: 0;
    right: 0;
    left: 0;
}


.form-box {
    /* 绝对定位 */
    position: absolute;
    top: -10%;
    left: 5%;
    background-color: #92afc5;
    width: 400px;
    height: 625px;
    border-radius: 5px;
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
    /* 动画过渡 加速后减速 */
    transition: 0.5s ease-in-out;
    z-index: 2;
    display: flex;
    justify-content: center;
    align-items: center;
}

.register-box, .login-box {
    /* 弹性布局 垂直排列 */
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
}

.hidden {
    display: none;
    /* 动画过渡 */
    transition: 0.5s;
}

h1 {
    text-align: center;
    margin-bottom: 25px;
    /* 转大写 */
    text-transform: uppercase;
    color: #fff;
    /* 字间距 */
    letter-spacing: 5px;
}

input {
    background-color: transparent;
    width: 90%;
    color: #fff;
    border: none;
    /* 下边框样式 */
    border-bottom: 1px solid rgba(255, 255, 255, 0.4);
    padding: 10px 0;
    text-indent: 10px;
    margin: 8px 0;
    font-size: 14px;
    letter-spacing: 2px;
}
.input {
    float: right;
    width: 70%;
}

input::placeholder {
    color: #fff;
}

input:focus {
    color: #7073ad;
    outline: none;
    border-bottom: 1px solid #7073ad80;
    transition: 0.5s;
}

input:focus::placeholder {
    opacity: 0;
}

.form-box button {
    width: 70%;
    margin-top: 35px;
    background-color: #f6f6f6;
    outline: none;
    border-radius: 8px;
    padding: 13px;
    color: #7073ad;
    letter-spacing: 2px;
    border: none;
    cursor: pointer;
}

.form-box button:hover {
    background-color: #7073ad;
    color: #f6f6f6;
    transition: background-color 0.5s ease;
}

.con-box {
    width: 50%;
    /* 弹性布局 垂直排列 居中 */
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    /* 绝对定位 居中 */
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
}

.con-box.left {
    left: -2%;
}

.con-box.right {
    right: -2%;
}

.con-box h2 {
    color: #8e9aaf;
    font-size: 25px;
    font-weight: bold;
    letter-spacing: 3px;
    text-align: center;
    margin-bottom: 4px;
}

.con-box p {
    font-size: 12px;
    letter-spacing: 2px;
    color: #8e9aaf;
    text-align: center;
}

.con-box span {
    color: #92afc5;
}

.con-box img {
    width: 150px;
    height: 150px;
    opacity: 0.9;
    margin: 40px 0;
}

.con-box button {
    margin-top: 3%;
    background-color: #fff;
    color: #7073ad;
    border: 1px solid #92afc5;
    padding: 6px 10px;
    border-radius: 5px;
    letter-spacing: 1px;
    outline: none;
    cursor: pointer;
}

.con-box button:hover {
    background-color: #92afc5;
    color: #fff;
}

</style>