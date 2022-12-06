import { createStore } from 'vuex'

const Store = createStore({
    state () {
        return {
            userName:"",
            userPassword:"",
            album_info:"",
            firstphoto:[],
            photo_info:[],
            album:"",
            photolist:[],
            head:null,
            sex:null,
            birthday:null,
            signature:null,
            status:null,
            registertime:null,
            filter:'',
            albumshowtype:'显示图片',
        }
    },
    getters: {
        isLogin: (state) => {
            return state.userName.length > 0
        }
    },
    mutations: {
        clearUserInfo(state) {
            state.userName = "";
            state.userPassword = "";
        },
        registUserInfo(state,{name, password}) {
            state.userName = name;
            state.password = password;
        },
        getAlbumInfo(state,albuminfo){
            state.album_info=albuminfo;
        },
        getPhotoList(state,{album,photolist}){
            state.photolist[album]=photolist;
        },
        getPhotoInfo(state,photo){
            state.photo_info=photo;
            //console.log(photo);
        },
        getAlbumName(state,album){
            state.album=album;
            console.log("albumname: "+album);
        },
        getUserInformation(state,{head, sex, birthday, signature, status, registertime}){
            state.head=head;
            state.sex=sex;
            state.birthday=birthday;
            state.signature=signature;
            //state.status= status;
            state.status= "在线";
            state.registertime=registertime;
        },
        getAlbumFilter(state,filter){
            state.filter=filter;
        },
        getAlbumShowType(state,type){
            state.albumshowtype=type;
        },
        getUserName(state,name){
            state.userName=name;
        },
    }
})

export default Store;