import axios from 'axios'
import router from '../routes.js'
const common = require('./common');

const _axios= params => {
  return axios({
      method: "post",
      url: 'http://localhost:80/bianquan/servers/public/index.php/index',
      // url: state.URL,
      data: params
    })
}



const actions = {
   //验证用户是否登录
   check_login({state,commit}) {
    //console.log(state.token);
    let params = {
      'act':'check_login'
    }
    _axios(params).then(function (res) {
      //console.log('成功了');
      //console.log(res.data);
      if (res.data.login) {
       router.push('/admin');
      } else {
        commit('change');
        commit('logout');
        commit('show_login_box');
      }
    })
      .catch(function (err) {
        console.log(err);
        console.log('失败了');
      });

  },



 //用户提交登录
 login({commit,state}) {
   let params = {
     'act':'login',
     'email':state.userEmail,
     'pwd':state.userPwd
   }
   _axios(params).then(function (res) {
     if (res.data.result && res.data.data) {
       //本地存储token
       let result = res.data.data;
       axios.defaults.headers.common['X-token'] = result.jwt;
       localStorage.setItem('bianquan_token',result.jwt);
       localStorage.setItem('bianquan_user',result.name);
       localStorage.setItem('bianquan_email',result.email);
       localStorage.setItem('bianquan_status',result.userstatus);
       //同步token到store中
       commit('token',result);
       commit('change');
       let data = '登录成功！'
       commit('show_alert_notice',data);
     } else{
       if(res.data.message) {
         commit('show_alert',res.data.message);
       } else {
         commit('show_alert','密码或邮箱错误！');
       }

     }
     if(res.data.login) {
       commit('change');
     }
   })
     .catch(function (err) {
       console.log(err);
       console.log('失败了');
     });

 },
//用户提交注册
 register({commit,state}) {
   // console.log(state.userPwd);
   let params = {
         'act':'register',
         'email':state.userEmail,
         'name':state.userName,
         'pwd':state.userPwd,
         'time':common.getTime()
   }
   _axios(params).then(function (res) {
     if(!res.data.result){ return; }
     if(res.data.data.msg) {
       commit('show_alert',res.data.data.msg);
     } else {
       commit('show_alert','注册失败');
     }

     if (res.data.data.result) {
       commit('show_login_box');
     }
   })
     .catch(function (err) {
       // console.log(err);
       console.log('失败了');
     });

 },

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
       commit('show_alert','登录超时，请重新登录');
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
     commit('show_alert','请确保信息完整');
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
       commit('show_alert','登录超时，请重新登录');
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
        commit('show_alert','权限不足,无法删除文章');
     }
     if(!res.data.login) {
       router.push('/');
       commit('change');
       commit('show_alert','登录超时，请重新登录');
       commit('logout');
     }

   })
     .catch(function (err) {
       console.log(err);
       console.log('失败了');
     });
 },
 //获取需要展示文章内容
 getShowArticle:function({commit,state},id) {
   let params = {
     'act':'getOne',
     'id':id
   }
   _axios(params).then(function (res) {
     //console.log('成功了');
     //console.log(res.data.data[0]);
     if(res.data.result) {
       commit('GETSHOWARTICLE',res.data.data);
     }

   })
   .catch(function (err) {
     console.log(err);
     console.log('失败了');
   });
 },
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
       commit('show_alert','权限不足，无法编辑');
     }
     if(!res.data.login) {
       router.push('/');
       commit('change');
       commit('show_alert','登录超时，请重新登录');
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
     commit('show_alert','请确保信息完整');
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
       commit('show_alert','权限不足');
    }
     if(!res.data.login) {
       router.push('/');
       commit('change');
       commit('show_alert','登录超时，请重新登录');
       commit('logout');
     }

   })
     .catch(function (err) {
       console.log(err);
       console.log('失败了');
     });
 },
 //获取首页文章页数
 getPageCount:function({commit,state}) {
   let params = {
     'act':'getPageCount',
     'tag': state.crumbs.first
   }
   _axios(params).then(function (res) {
     //console.log('获取页面数成功了');
     //console.log(res);
     if(res.data.result) {
       let count = res.data.data;
     commit('GETPAGECOUNT',count);
     }

   })
     .catch(function (err) {
       console.log(err);
       console.log('失败了');
     });
 },
 //获取某一页文章列表数据
 getPage:function({commit,state}) {
   let params = {
     'act':'getPage',
     'page': state.page_index,
     'tag': state.crumbs.first
   }
   _axios(params).then(function (res) {
     //console.log('获取页面列表成功');
     //console.log(res.data.data);
     if(res.data.result) {
       let pageDate = res.data.data;
       commit('GETPAGE',pageDate);
     }

   })
     .catch(function (err) {
       console.log(err);
       console.log('失败了');
     });
 },
 //获取某一篇文章的评论内容
 getComment: function({commit,state},id) {
   let params = {
     'act':'getComment',
     'id':id
   }
   _axios(params).then(function (res) {
     //console.log('获取评论成功了');
     commit('CLEARCOMMENT');
     if(res.data.result) {
       commit('GETCOMMENT',res.data.data);
     }
   })
     .catch(function (err) {
       console.log(err);
       console.log('失败了');
     });
 },
 //对某一篇文章增加评论
 addComment: function({commit,state}) {
   //console.log(this.commentText);
   let commentText = state.commentText;
   let a_id = state.commentArticleId;
   let params = {
     'act':'addComment',
     'commenter':state.commenter,
     'commenterEmail':state.commenterEmail,
     'commentText':commentText,
     'time':common.getTime(),
     'oldComment':state.oldComment,
     'id':a_id,
     'type':state.type,
     'index':state.chosedIndex
   }

   _axios(params).then(function (res) {
     if(res.data.data.msg) {
       commit('show_alert_notice',res.data.data.msg);
       return;
     }
     if(res.data.result) {
       commit("ADDCOMMENT");
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
       commit('show_alert','登录超时，请重新登录');
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
       commit('show_alert','登录超时，请重新登录');
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
         commit('show_alert','试试点赞其他文章吧！');
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
           commit('show_alert','登录超时，请重新登录');
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
               commit('show_alert','登录超时，请重新登录');
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
             commit('show_alert','登录超时，请重新登录');
             commit('logout');
           }

           })
             .catch(function (err) {
               console.log(err);
               console.log('失败了');
             });

           },
         //获取所有标签
         get_tags: function({commit,state}) {
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
               commit('show_alert','权限不足');
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
               commit('show_alert','权限不足');
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
               commit('show_alert','权限不足');
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
               commit('show_alert','权限不足');
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
            commit("show_alert_notice",'内容更新成功');
            commit('UPDATE_ABOUT');
           } else {
             commit('show_alert','更新失败');
           }
           if(res.data.error == 1) {
             commit('show_alert','权限不足');
          }
         })
           .catch(function (err) {
             console.log(err);
             console.log('失败了');
           });
         },
        //获取about页数据
        get_about:function({commit,state}) {
        let params = {
          'act':'get_about'
        }
        _axios(params).then(function (res) {
          if(res.data.result) {
           commit("GET_ABOUT",res.data.data);
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
             commit('show_alert','权限不足,无法删除图片');
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
        //获取作品内容
        get_production:function({commit,state}) {
         let params = {
           'act':'get_production'
         }
         _axios(params).then(function (res) {
           //console.log('成功了');
           if(res.data.result) {
             commit("GET_PRODUCTION",res.data.data);
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
