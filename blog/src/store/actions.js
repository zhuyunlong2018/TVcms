import axios from 'axios'
import router from '../routes.js'
import { getStorage, setStorage, rermoveStorage } from '@/utils/storage'
import { get as getWebData, addPraise } from '@/api/webData'


const common = require('./common');

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
    if(getStorage(add_praise)) {
      commit('SHOW_ALERT','试试点赞其他文章吧！');
      return;
    }else {
      setStorage(add_praise,'点赞成功！');
    }
    const data = {
      id
    }
    addPraise(data).then(response => {
      commit("ADD_PRAISE",id);
    })
  },








 //添加文章
 addArticle:function({commit,state}){
   if(!(state.title && state.content &&state.article_background)) {
     commit('SHOW_ALERT','请确保信息完整');
     return;
   }
   let content = state.content;
   let params = {
     'act':'add',
     'name':state.commenter,
     'title':state.title,
     'content':content,
     'tag':state.tag,
     'time':common.getTime(),
     'article_background':state.article_background
   }
   _axios(params).then(function (res) {
     //console.log('成功了');
     //console.log(res);
     if(res.data.result) {
       router.push('/admin/editor');
       commit('UPDATEARTICLE');
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
 //删除选中文章
 delArticle:function({commit,state},obj){
   //console.log(obj);
   let params = {
     'act':'del',
     'id':obj.id
   }
   _axios(params).then(function (res) {
     //console.log('成功了');
     if(res.data.result) {
       commit('DELARTICLE',obj.index);
     }
     if(res.data.error == 1) {
        commit('SHOW_ALERT','权限不足,无法删除文章');
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
 
 //更新选中的文章内容
 updateArticle:function({commit,state}){
  // console.log(state.id);
  if(!(state.title && state.content &&state.article_background)) {
     commit('SHOW_ALERT','请确保信息完整');
     return;
   }
   let content = state.content;
   let params = {
     'act':'update',
     'title':state.title,
     'content':content,
     'tag':state.tag,
     'id':state.id,
     'article_background':state.article_background
   }
   _axios(params).then(function (res) {
     //console.log('成功了');
     if(res.data.result) {
       router.push('/admin/editor');
       commit('UPDATEARTICLE');
     }
     if(res.data.error == 1) {
       commit('SHOW_ALERT','权限不足');
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
 

  //新增标签
  add_tags: function({commit,state},tag) {
    let params = {
      'act':'add_tags',
      'name':tag
    }
    _axios(params).then(function (res) {
      //console.log('成功了');
      //console.log(res.data.result);
      if(res.data.result) {
      commit("ADD_TAGS",tag);
      }
      if(res.data.error == 1) {
        commit('SHOW_ALERT','权限不足');
    }

    })
      .catch(function (err) {
        console.log('失败了');
      });

    },
//移除标签
  del_tags: function({commit,state},obj) {
    let params = {
      'act':'del_tags',
      'name':obj.tag
    }
    _axios(params).then(function (res) {
      if(res.data.result) {
      commit("DEL_TAGS",obj.index);
      }
      if(res.data.error == 1) {
        commit('SHOW_ALERT','权限不足');
    }

    })
      .catch(function (err) {
        console.log('失败了');
      });

    },
//新增友情链接
  add_neighbors: function({commit,state},obj) {
    let time = common.getTime();
    let params = {
      'act':'add_neighbors',
      'nb_name':obj.name,
      'nb_url':obj.url,
      'nb_icon':obj.icon,
      'nb_time':time,
      'nb_published':obj.publish,
    }
    _axios(params).then(function (res) {
      //console.log('成功了');
      //console.log(res.data.result);
      if(res.data.result) {
      commit("ADD_NEIGHBORS",params);
      }
      if(res.data.error == 1) {
        commit('SHOW_ALERT','权限不足');
    }

    })
      .catch(function (err) {
        console.log(err);
        console.log('失败了');
      });

    },
 

  //删除友情链接
    del_neighbors:function({commit,state},index) {
    let params = {
      'act':'del_neighbors',
      'name':state.all_neighbors[index].nb_name
    }
    _axios(params).then(function (res) {
      if(res.data.result) {
      commit("DEL_NEIGHBORS",index);
      }
      if(res.data.error == 1) {
        commit('SHOW_ALERT','权限不足');
    }
    })
      .catch(function (err) {
        console.log(err);
        console.log('失败了');
      });

    },

  //更新about页数据
  update_about:function({commit,state}) {
    //  let about = escape(state.about_markdown);
    let about = state.about_markdown;
    let params = {
      'act':'update_about',
      'content':about
    }
    _axios(params).then(function (res) {
      if(res.data.result) {
      commit("SHOW_MESSAGE",'内容更新成功');
      commit('UPDATE_ABOUT');
      } else {
        commit('SHOW_ALERT','更新失败');
      }
      if(res.data.error == 1) {
        commit('SHOW_ALERT','权限不足');
    }
    })
      .catch(function (err) {
        console.log(err);
        console.log('失败了');
      });
    },

  //删除图片
  del_img:function({commit,state},index) {
    let params = {
      'act':'del_img',
      'url':state.all_images.src[index],
    }
    //console.log(state.all_images.src[index]);
    _axios(params).then(function (res) {;
      if(res.data.result) {
      commit("DEL_IMG",index);
      }
      if(res.data.error == 1) {
        commit('SHOW_ALERT','权限不足,无法删除图片');
    }
    })
      .catch(function (err) {
        console.log(err);
        console.log('失败了');
      });
    },
  //获取bing图片
  get_bing:function({commit,state}) {
    let params = {
      'act':'get_bing'
    }
    _axios(params).then(function (res) {
      if(res.data.result) {
        commit("GET_BING",res.data.data);
      }
    })
      .catch(function (err) {
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
