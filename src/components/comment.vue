<template>
  <div class="comment">
    <div class="commentBox">
      <h3 id="publish" >发表评论</h3>
      <b v-show="type">你回复&nbsp;{{oldComment}}</b>
      <input v-if="!token" type="text" v-model="commenter" placeholder="昵称:">
      <input v-if="!token" type="email" v-model="commenterEmail" ref="input_mail" @change="_check_mail" name="user_email" placeholder="邮箱(用于通知回复信息):" />
      <span class="check_mail" v-if="!token" v-show="!check_mail" >*邮箱格式不正确</span>
      <markdown-editor v-model="commentText" ref="markdwonEditor" :configs="configs" :highlight="true"></markdown-editor>
      <p class="notice" v-show="disabled">*请填写完整信息！</p>
      <button class="btn" @click="addComment" :disabled="disabled" >发表</button>
      <button class="btn" @click="canelComment">取消</button>
    </div>
    <div class="commentBox">
      <h3>评论</h3>
      <p v-if="comment.length==0">暂无评论，欢迎添加评论！</p>
      <div v-else>
        <div class="comment" v-for="(item,index) in comment" :key="item.index" v-bind:index="index" >
          <b>#{{index+1}}&nbsp;&nbsp;{{item.name}}<span>{{item.time}}</span></b>
          <div class="commemt-text" @click="_changeCommenter(item.name,index)" v-html="item.content" >
          </div>
          <div v-if="item.reply.length > 0">
            <div class="reply" v-for="(reply,num) in item.reply" :key="reply.num" >
              <b>#{{index+1}}.{{num+1}}&nbsp;&nbsp;{{reply.responder}}<span>回复</span> &nbsp;&nbsp;{{reply.reviewers}}<span>{{reply.time}}</span></b>
              <div class="commemt-text" @click="_changeCommenter(reply.responder,index)">{{reply.content}}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
  import { mapState,mapMutations,mapActions } from 'vuex';
  export default {
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
        }
      }
    },
    methods: {
      ...mapMutations(["changeCommenter","canelComment"]),
      ...mapActions(["addComment"]),
      _changeCommenter:function(name,index) {
          let publish = document.getElementById("publish");
          //console.log(publish.offsetTop);
          window.scrollTo(0,publish.offsetTop);
          let obj = {};
          obj.name = name;
          obj.index = index;
          this.changeCommenter(obj);
      },
      _check_mail:function() {
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
    },
    computed: {
      ...mapState(["show_article","type","oldComment","chosedIndex","comment","commentTime",'token']),
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

      },
      commenter: {
        get () {
          return this.$store.state.commenter
        },
        set (value) {
          this.$store.commit('updatecommenter', value)
        }
      },
      commenterEmail: {
        get () {
          return this.$store.state.commenterEmail
        },
        set (value) {
          this.$store.commit('updatecommenterEmail', value)
        }
      },
      commentText: {
        get () {
          return this.$store.state.commentText
        },
        set (value) {
          this.$store.commit('updatecommentText', value)
        }
      }
    },
    mounted() {
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
