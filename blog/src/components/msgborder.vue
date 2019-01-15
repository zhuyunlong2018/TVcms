<template>
  <div class="main f-l">
    <div class="msgborder">
      <h2 class="title">我xxx到此一游！O(∩_∩)O哈哈~</h2>
      <!--留言-->
      <comment></comment>
    </div>
  </div>
</template>

<script>
import comment from "./comment.vue";
import { mapState,mapActions,mapMutations } from "vuex";
  export default {
      data() {
          return{}

      },
      components: {
        comment
      },
    methods: {
          ...mapActions(["getComment"]),
          ...mapMutations(["changeCommentPage"]),
          _changeCommentPage:function() {
            let p_id = 0;
            this.changeCommentPage(p_id);
          },
          _getMsg: function(){
            this.getComment(0);
          }
      },
    mounted() {
      this._getMsg();
      this._changeCommentPage()
    }
  }

</script>
<style>
  .main .comment .commentBox .markdown-editor .CodeMirror, 
  .main .comment .commentBox .markdown-editor .CodeMirror-scroll {
    min-height: 100px;
  }
</style>


<style scoped>
  .main .msgborder {
    width: 100%;
    margin: 15px 0;
    padding: 15px 0;
    background: #fff;
    border-radius: 10px;
    box-shadow: 3px 3px 8px 2px #ccc;
  }


  .main .msgborder .title {
    color: rgba(33,33,33,0.8);
    cursor: pointer;
    height: 50px;
    margin: 0px 20px;
    text-shadow: 3px 3px 2px #ccc;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .main .msgborder .title:hover {
    color: #000;
  }



  @media only screen and (max-width: 500px) {
    .main .msgborder .title {
      font-size: 18px;
      height: 25px;
    }
  }


</style>
