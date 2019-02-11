<template>
  <div class="comment">
    <div class="commentBox">
      <h3 id="publish" >发表评论</h3>
      <b v-show="target.show">你回复&nbsp;{{target.name}}</b>
      <input v-if="!token" type="text" v-model="queryData.user.name" placeholder="昵称:">
      <input v-if="!token" type="email" v-model="queryData.user.email" ref="input_mail" @change="checkMail" name="user_email" placeholder="邮箱(用于通知回复信息):" />
      <span class="check_mail" v-if="!token" v-show="!check_mail" >*邮箱格式不正确</span>
      <markdown-editor v-model="queryData.content" ref="markdwonEditor" :configs="configs" :highlight="true"></markdown-editor>
      <p class="notice" v-show="disabled">*请填写完整信息！</p>
      <button class="btn" @click="addComment" >发表</button>
      <button class="btn" @click="canelComment">取消</button>
    </div>
    <div class="commentBox">
      <h3>评论</h3>
      <p v-if="list===null">暂无评论，欢迎添加评论！</p>
      <div v-else>
        <div class="comment" v-for="(item,index) in list" :key="item.id" v-bind:index="index" >
          <b>#{{index+1}}&nbsp;&nbsp;{{item.user_name}}<span>{{item.create_time}}</span></b>
          <div class="commemt-text" @click="changeCommenter(item,item)" v-html="item.content" >
          </div>
          <div v-if="item.reply.length > 0">
            <div class="reply" v-for="(reply,num) in item.reply" :key="reply.id" >
              <b>#{{index+1}}.{{num+1}}&nbsp;&nbsp;{{reply.user_name}}<span>回复</span> &nbsp;&nbsp;{{reply.target.user_name}}<span>{{reply.create_time}}</span></b>
              <div class="commemt-text" @click="changeCommenter(item,reply)">{{reply.content}}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex';
  import { getStorage } from '@/utils/storage'
  import { add, getList } from '@/api/comment'
  export default {
    props: ['articleID'],
    data() {
      return {
        check_mail: false,
        configs: {
          toolbar:false,
          placeholder:"添加评论……",
          status:false,
          spellChecker: false,
          renderingConfig: {
            singleLineBreaks: true
          }
        },
        list: null,
        queryData: {
          articleID: 0,
          user: {
            id: getStorage('user').user_id,
            name: getStorage('user').user_name,
            email: getStorage('user').user_email
          },
          content: null,
          oldComment: {
            fatherID: 0,
            targetID: 0
          }
        },
        target: {
          show: false,
          name: null
        }
      }
    },
    methods: {
      changeCommenter(father,target) {
        let publish = document.getElementById("publish");
        window.scrollTo(0,publish.offsetTop);
        this.target = {
          show: true,
          name: target.user_name
        }
        this.queryData.oldComment = {
          fatherID: father.id,
          targetID: target.id
        }
      },
      resetQueryData() {
        this.queryData.content = ''
        this.canelComment()
      },
      canelComment() {
        this.target = {
        show: false,
        name: null
        }
        this.queryData.oldComment = {
          fatherID: 0,
          targetID: 0
        }
      },
      checkMail:function() {
        this.check_mail = false;
        let email = this.$refs.input_mail.value;
        if(email) {
          let reg = new RegExp("^[a-z0-9]+([._\\-]*[a-z0-9])*@([a-z0-9]+[-a-z0-9]*[a-z0-9]+.){1,63}[a-z0-9]+$"); //正则表达式
          if(!reg.test(email)) {
            console.log('邮箱格式不正确');
          } else {
            this.check_mail = true;
            console.log('邮箱正确');
          }       
        } else {
          console.log('邮箱不能为空');
        }
      },
      addComment() {
        this.queryData.articleID = this.articleID
        // console.log(this.queryData)
        add(this.queryData).then(response => {
          let data = response.data.data
          let fatherID = data.father_id
          let targetID = data.target_id
          if(fatherID === 0) {
            data.reply = []
            this.list.push(data)
          } else {
            let fatherIndex,targetIndex
            for (const v of this.list) {
              if(fatherID == v.id) {
                fatherIndex = this.list.indexOf(v)
              }
            }
            if(targetID == fatherID) {
              data.target = this.list[fatherIndex]
            } else {
              for(const k of this.list[fatherIndex].reply) {
                if(targetID == k.id) {
                  data.target = k
                }
              }
            }
            this.list[fatherIndex].reply.push(data)
          }
          this.resetQueryData()
        })
      },
      getList() {
        let query = {id: this.articleID}
        getList(query).then(response => {
          this.list = response.data.data
        })
      }
    },
    computed: {
      ...mapGetters(['token']),
      //评论内容不为空时，激活评论发表按钮
      disabled() {
        if(this.token) {
          if(this.commenter && this.commenterEmail && this.commentText) {
          return false;
          } else {
          return true;
          }
        } else {
            if(this.commenter && this.commenterEmail && this.commentText && this.check_mail) {
            return false;
          } else {
            return true;
          }
        }
      }
    },
    created() {
      this.getList()
      
    }
  }



</script>


<style scoped>

  .commentBox {margin:10px 20px 50px;}
  .commentBox h3 {color: #333; background: #f1f1f1;border-radius: 5px; padding: 8px 15px; text-align: left; font-size: 16px;}
  .commentBox>p {color: #333;}
  /* .comment {margin-bottom:15px;} */
  .comment + .comment, .reply + .reply{border-top:1px solid #999;}
  .comment b{color:rgb(255, 147, 58); font-size:16px; display:block; margin:5px 0;}
  .comment b span {color:rgb(238, 120, 120); font-size:14px; margin-left:20px;}
  .commemt-text { cursor: pointer; margin-bottom: 10px; }
  .comment div {font-size:16px; color:#333;height: 100%;word-wrap:break-word;}
  .commentBox .notice {float:left; color: #990000}
  .commentBox input {width: 50%; margin: 5px 0; padding: 3px; padding-left: 15px;}
  .commentBox button {float:right; margin-left:20px;padding:5px 30px; background:#333; border-radius:5px; color:#fff; font-size:16px;}
  .commentBox button:hover {color:#fff; background:#999}
  .reply {margin:15px 0 0 50px;}
  .check_mail {
    color:#990000;
  }
  .main .CodeMirror .cm-spell-error:not(.cm-url):not(.cm-comment):not(.cm-tag):not(.cm-word) {
    background: rgba(250, 250, 250, 0)
  }

  .main .CodeMirror {
  background: rgba(250, 250, 250, 0)
  }

  @media only screen and (max-width: 500px) {
     .commentBox .notice {
       float: none;
     }
    .commentBox input {
      width: 100%; 
    }
    .reply {
      margin:15px 0 0 20px;
      }
  }





</style>
