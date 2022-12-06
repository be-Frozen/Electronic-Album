import mockjs from "mockjs";
import router from "@/tools/Router";
import Storage from "@/tools/Storage";
const Mock = {
    // 模拟获取订单数据
    // type: 订单类型 0为普通订单 1为秒杀订单
    getOrder(type) {
        let array = [];
        for (let i = 0; i < mockjs.Random.integer(5,10); i ++) {
            array.push(mockjs.mock({
                'name':type == 0 ? '普通商品 ' : "秒杀商品" + i,
                'price':mockjs.Random.integer(20,500) + '元',
                'buyer':mockjs.Random.cname(),
                'time':mockjs.Random.datetime('yyyy-MM-dd A HH:mm:ss'),
                'role':mockjs.Random.boolean(),
                'state':mockjs.Random.boolean(),
                'payType':mockjs.Random.boolean(),
                'source':mockjs.Random.url(),
                'phone':mockjs.mock(/\d{11}/)
            }))
        }
        return array;
    },
    getManagerOrder() {
        let array = [];
        for (let i = 0; i < mockjs.Random.integer(5,10); i ++) {
            array.push(mockjs.mock({
                'state':'店长订单',
                'name':mockjs.Random.csentence(),
                'id':mockjs.Random.string(11),
                'manager':mockjs.Random.cname(),
                'count':mockjs.Random.integer(20,500),
                'price':mockjs.Random.integer(20000,50000000) + '元',
                'coin':mockjs.Random.integer(2000,50000) + '元',
                'payTime':mockjs.Random.datetime('yyyy-MM-dd A HH:mm:ss'),
                'sendTime':mockjs.Random.datetime('yyyy-MM-dd A HH:mm:ss')
            }))
        }
        return array;
    },
    // 模拟获取商品数据
    // type: 商品类型 1为普通订单 2为秒杀订单 3为今日推荐


    getThings(type) {
        let array = [];
        for (let i = 0; i < mockjs.Random.integer(5,10); i ++) {
            array.push(mockjs.mock({
                'name':(type == 0 ? '普通商品 ' : type == 1 ? "秒杀商品":"今日推荐") + i,
                'img':mockjs.Random.dataImage('60x100', '商品示例图'),
                'price':mockjs.Random.integer(20,500) + '元',
                'sellCount':mockjs.Random.integer(10,100),
                'count':mockjs.Random.integer(10,100),
                'back':mockjs.Random.integer(10,100),
                'backPrice':mockjs.Random.integer(0,5000) + '元',
                'owner':mockjs.Random.cname(),
                'time':mockjs.Random.datetime('yyyy-MM-dd A HH:mm:ss'),
                'state':mockjs.Random.boolean()
            }))
        }
        return array;
    },
    getGoods(type) {

        console.log(type);
        console.log(Storage.state.album_info[type]);
        Storage.commit("getAlbumName",Storage.state.album_info[type]);
        let phpaddr = "album/php/outdir.php";
        var xmlhttp;
        xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                //console.log(JSON.parse(xmlhttp.responseText));
                var x=xmlhttp.responseText;
                Storage.commit("getPhotoInfo", JSON.parse(xmlhttp.responseText));
                console.log(x);
                console.log(Storage.state.photo_info);
            }
        }
        xmlhttp.open("GET", '/myApi' + phpaddr + '?readall=1&type=1&addr=原神/'+Storage.state.album_info[type], true);

        xmlhttp.send();
    },
    getManagerList() {
        let array = [];
        for (let i = 0; i < mockjs.Random.integer(5,10); i ++) {
            array.push(mockjs.mock({
                'people':mockjs.Random.csentence(),
                'weixin':mockjs.Random.string(7, 10),
                'state':mockjs.Random.boolean(),
                'income':mockjs.Random.integer(0,500000) + '元',
                'back':mockjs.Random.integer(0,1000) + '元',
                'backPrice':mockjs.Random.integer(0,5000) + '元',
                'source':'站内',
                'customer':mockjs.Random.integer(0,50),
                'time':mockjs.Random.datetime('yyyy-MM-dd A HH:mm:ss'),
            }))
        }
        return array;
    },
    getManagerReqList() {
        let array = [];
        for (let i = 0; i < mockjs.Random.integer(5,10); i ++) {
            array.push(mockjs.mock({
                'people':mockjs.Random.csentence(),
                'state':mockjs.Random.boolean(),
                'reqTime':mockjs.Random.datetime('yyyy-MM-dd A HH:mm:ss'),
                'time':mockjs.Random.datetime('yyyy-MM-dd A HH:mm:ss'),
            }))
        }
        return array;
    },
    getTradeInfo() {
        let array = [];
        for (let i = 0; i < mockjs.Random.integer(5,10); i ++) {
            array.push(mockjs.mock({
                'name':mockjs.Random.csentence(),
                'id':mockjs.Random.string(11),
                'user':mockjs.Random.cname(),
                'payType':mockjs.Random.boolean() ? '网络支付' : '线下支付',
                'time':mockjs.Random.datetime('yyyy-MM-dd A HH:mm:ss'),
            }))
        }
        return array;
    },
    getTradeList() {
        let array = [];
        for (let i = 0; i < mockjs.Random.integer(5,10); i ++) {
            array.push(mockjs.mock({
                'info':mockjs.Random.csentence(),
                'income':mockjs.Random.integer(0,5000) + '元',
                'expend':mockjs.Random.integer(0,5000) + '元',
                'time':mockjs.Random.datetime('yyyy-MM-dd A HH:mm:ss'),
            }))
        }
        return array;
    },
    getChartsData() {
        let array = [];
        for (let i = 0; i < 6; i ++) {
            array.push(mockjs.Random.integer(0,100))
        }
        return array;
    },
    getTradeData() {
        return mockjs.mock({
            'allTra':mockjs.Random.integer(10000,50000),
            'speTra':mockjs.Random.integer(0,5000),
            'norTra':mockjs.Random.integer(0,5000),
            'userCount':mockjs.Random.integer(0,1000),
            'managerCount':mockjs.Random.integer(0,100),
            'time':mockjs.Random.datetime('yyyy-MM-dd A HH:mm:ss'),
        })
    }
}
export default Mock;