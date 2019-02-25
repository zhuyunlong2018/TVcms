import axios from 'axios'
import router from '../routes.js'
import { getStorage, setStorage, rermoveStorage } from '@/utils/storage'
import { get as getWebData, addPraise } from '@/api/webData'




const _axios= params => {
  return axios({
      method: "post",
      url: 'www.bianquan.com/index.php/index',
      data: params
    })
}

const actions = {

//获取网站基本统计数据
  getWebData({commit}) {
    getWebData().then(response => {
      commit("GET_WEB_DATA",response.data.data);
    })
  },

  //点赞
  addPraise({commit},id) {
    //判断是否点赞
    let add_praise = id+'_add_praise';
    return new Promise((resolve, reject) => {
      if(getStorage(add_praise)) {
        commit('SHOW_ALERT','试试点赞其他文章吧！');
        reject()
      }else {
        setStorage(add_praise,'点赞成功！');
        const data = { id }
        addPraise(data).then(response => {
          commit("ADD_PRAISE",id);
          commit("SHOW_MESSAGE",'点赞成功')
          resolve()
        })
      }
    })
  },







   //获取所有图片地址
 get_all_imgs:function({commit,state}) {
   let params = {
     'act':'get_all_imgs'
   }
   _axios(params).then(function (res) {
     //console.log('成功了');
     //console.log(res.data);
     if(res.data.result) {
       commit('GET_ALL_IMGS',res.data.data);
     }
     if(!res.data.login) {
       router.push('/');
       commit('change');
       commit('SHOW_ALERT','登录超时，请重新登录');
       commit('logout');
     }

   })
     .catch(function (err) {
       console.log(err);
       console.log('失败了');
     });

 },



  //搜索文章
  searchfor:function({commit,state},key) {
    let params = {
      'act':'searchfor',
      'key': key
    }
    _axios(params).then(function(res){
      if(res.data.result) {
        // console.log(res.data.data);
      }
    })
    .catch(function(err) {
      console.log('失败了');
    })
  }
  }

  export default actions
