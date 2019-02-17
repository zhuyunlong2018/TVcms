import axios from 'axios'
import router from '../routes.js'

const common = require('./common');

const _axios= params => {
  return axios({
      method: "post",
      url: 'www.bianquan.com/index.php/index',
      // url: state.URL,
      data: params
    })
}



const actions = {

 //获取所有文章列表
 getList:function({commit,state}) {
   //console.log(commit);
   //console.log(params);
   let list=[];
   let params = {
     'act':'get'
   }
   _axios(params).then(function (res) {
     //console.log('成功了');
     //console.log(res.data);
     if(res.data.result) {
       let result = res.data.data;
       for(let i=0;i<result.length;i++) {
         list.push({
           id: result[i].a_id,
           title: result[i].a_title,
           author: result[i].a_author,
         // content: result[i].content,
           time: result[i].a_time,
           tag: result[i].a_tag,
           published: result[i].a_published
         })
       }
       commit('GETLIST',list);
     }
     if(!res.data.login) {
       router.push('/');
       commit('change');
       commit('SHOW_ALERT','登录超时，请重新登录');
       commit('logout');
     }

    // console.log(result);
   })
     .catch(function (err) {
       console.log(err);
       console.log('失败了');
     });
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
 //获取需要展示文章内容
//  getShowArticle:function({commit,state},id) {
//    let params = {
//      'act':'getOne',
//      'id':id
//    }
//    _axios(params).then(function (res) {
//      //console.log('成功了');
//      //console.log(res.data.data[0]);
//      if(res.data.result) {
//        commit('GETSHOWARTICLE',res.data.data);
//      }

//    })
//    .catch(function (err) {
//      console.log(err);
//      console.log('失败了');
//    });
//  },
 //获取选中需编辑文章内容
 getOneArticle:function({commit,state},id){
   let params = {
     'act':'getOne',
     'id':id
   }
   _axios(params).then(function (res) {
     //console.log('成功了');
     if(res.data.result) {
       commit('GETONEARTICLE',res.data.data);
       router.push('/admin/write');
     }
     if(res.data.error == 1) {
       commit('SHOW_ALERT','权限不足，无法编辑');
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
   //发布或下架选中文章
 publish: function({commit,state},data) {
   let index = data.index;
   let params = {
     'act':'publish',
     'id':data.id,
     'publish':data.publish
   }
   _axios(params).then(function (res) {
     //console.log('成功了');
     //console.log(res.data);
     if(res.data.result == 'success') {
       let data = {};
       data.publish = res.data.publish;
       data.index = index;
       commit('PUBLISH',data);
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
//点赞
add_praise: function({commit,state},id) {
//判断是否点赞
let add_praise = id+'_add_praise';
if(sessionStorage.getItem(add_praise)) {
  commit('SHOW_ALERT','试试点赞其他文章吧！');
  return;
}else {
  sessionStorage.setItem(add_praise,'点赞成功！');
}
let params = {
  'act':'add_praise',
  'id':id
}
_axios(params).then(function (res) {
  if(res.data.result) {
    commit("ADD_PRAISE",id);
  }
})
  .catch(function (err) {
    console.log(err);
    console.log('失败了');
  });

},
//获取网站基本统计数据
get_webdata: function({commit,state}) {
let params = {
  'act':'get_webdata'
}
_axios(params).then(function (res) {
  //console.log('成功了');
  //console.log(res.data);
  if(res.data.result) {
    commit("GET_WEBDATA",res.data.data[0]);
  }

})
  .catch(function (err) {
    console.log(err);
    console.log('失败了');
  });

},//获取所有评论内容
get_all_comment: function({commit,state}) {
  let params = {
    'act':'get_all_comment'
  }
  _axios(params).then(function (res) {
    if(res.data.result) {
    commit("GET_ALL_COMMENT",res.data.data);
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
  //屏蔽或解封评论
  comment_publish: function({commit,state},data) {
    let params = {
      'act':'toggle_comment',
      'id':data.id,
      'publish':data.publish
    }
    _axios(params).then(function (res) {
      if(res.data.result) {
        let _data = {};
        _data.id = res.data.data.c_id;
        _data.index = data.index;
        _data._index = data._index;
        _data.publish = res.data.publish;
      commit("CLOSE_COMMENT",_data);
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
  //显示所有用户列表
  show_all_user: function({commit,state}) {
    let params = {
      'act':'show_all_user'
    }
    _axios(params).then(function (res) {
      if(res.data.result) {
      commit("SHOW_ALL_USER",res.data.data);
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
  //获取所有标签
  getTags: function({commit,state}) {
    let params = {
      'act':'get_tags'
    }
    _axios(params).then(function (res) {
      //console.log('成功了');
      //console.log(res.data.data);
      if(res.data.result) {
      commit("GET_TAGS",res.data.data);
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
  //获取所有友情链接
  get_neighbors: function({commit,state}) {
    let params = {
      'act':'get_neighbors'
    }
    _axios(params).then(function (res) {
      //console.log('成功了');
    // console.log(res.data.data);
      if(res.data.result) {
      commit("GET_NEIGHBORS",res.data.data);
      }

    })
      .catch(function (err) {
        // console.log(err);
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
  //获取所有上架文章的列表
  get_all_article:function({commit,state}) {
    let params = {
      'act':'get_all_article'
    }
    _axios(params).then(function (res) {
      //console.log('成功了');
      //console.log(res.data.data);
      if(res.data.result) {
      commit("GET_ALL_ARTICLE",res.data.data);
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
