<template>
  <div class="main f-l">
    <div class="article">
      <h3 class="title">
        {{ article.a_title }}
      </h3>
      <ul class="tag">
            <li>
              <i class="glyphicon glyphicon-tag" ></i>
               {{article.a_tag}}
            </li>
            <li>
              <i class="glyphicon glyphicon-pencil" ></i>{{article.a_author}}</li>
            <li>
              <i class="glyphicon glyphicon-calendar" ></i>{{article.a_time}}
            </li>
            <li>
              <i class="glyphicon glyphicon-comment" ></i>{{article.a_comment}}
            </li>
            <li>
              <i class="glyphicon glyphicon glyphicon-heart" ></i>{{article.a_praise}}
            </li>
      </ul>
      <div class="content" v-html="article.a_content" v-highlight></div>
      <p class="praise" >
        <i class="glyphicon glyphicon-thumbs-up" @click="_add_praise" ></i>
      </p>
      <p class="praise" ><span>累计获得{{article.a_praise}}个赞</span></p>
      <comment :articleID='article.a_id'></comment>
    </div>
  </div>
</template>

<script>
  import { mapState,mapActions,mapMutations } from 'vuex'
  import comment from '@/views/components/comment.vue'
  import { getOne } from '@/api/article'
  import simplemde from 'simplemde'
  //import markdownEditor from 'vue-simplemde/src/markdown-editor';
  export default {
    data() {
      return {
        article: {
          a_id: null,
        }
      }
    },
    components: {
      comment
    },
    methods: {
      ...mapActions(["getComment","add_praise"]),
      ...mapMutations(['CHANGE_CRUMBS']),
      getOne() {
        getOne(this.article.a_id).then(response => {
          let content = response.data.data.a_content
          response.data.data.a_content = simplemde.prototype.markdown(content)
          this.article = response.data.data
          let obj = {
            tag: this.article.a_tag,
            title: this.article.a_title
          }
          this.CHANGE_CRUMBS(obj)
        }).catch(error => {
            this.SHOW_ALERT(error.response.data.msg)
        })
      },
      _add_praise:function() {
        let id = this.$route.params.id;
        this.add_praise(id);
      }
    },
    created:function() {
      this.article.a_id = this.$route.params.id
    },
    mounted() {
      this.getOne()
    }
  }
</script>

<style>
  .main .article .content h1 {
    font-size: 30px;
  }
  .main .article .content p img {
    max-width: 100%;
  }
  .main .comment .commentBox .markdown-editor .CodeMirror, 
  .main .comment .commentBox .markdown-editor .CodeMirror-scroll {
    min-height: 100px;
  }
   .article .praise {
      text-align: center;
      margin-top: 10px;
      height: 40px;
      line-height: 40px;
    }
    .article .praise span {
      display: inline-block;
    }
    .article .praise i {
      cursor: pointer;
      color: #ec919d;
      font-size: 40px;
    }

      .article .praise i:hover {
        font-size: 50px;
        color: #ec5057;
        transition:  0.6s all;
      }


</style>



<style scoped>
  /*@import '~simplemde/dist/simplemde.min.css';*/
  .main .article {
    width: 100%;
    margin: 15px 0;
    padding: 15px 0;
    background: #fff;
    border-radius: 10px;
    box-shadow: 3px 3px 8px 2px #ccc;
  }


  .main .article .title {
    color: rgba(33,33,33,0.8);
    cursor: pointer;
    max-height: 60px;
    overflow: hidden;
    line-height: 30px;
    margin: 0 20px;
    text-shadow: 3px 3px 2px #ccc;
  }

  .main .article .title:hover {
    color: #000;
  }

 .main .article .tag {
   height: 30px;
   line-height: 30px;
   border-bottom: 1px solid #ccc;
   width: 90%;
   padding: 0 15px;
   margin: auto;
   margin-bottom: 20px;
 }
    .main .article .tag li {
    display: inline-block;
    padding: 0 8px;
  }
    .main .article .tag li i {
      margin-right: 5px;
    }

  .main .article .content {
    margin: 0 20px;
  }


  @media only screen and (max-width: 600px) {
    .main .article .title {
      box-shadow: none;
      font-size: 18px;
      margin-top: 0;
      margin-bottom: 0;
    }

    .main .article .tag {
      margin-top: 10px;
      height: 60px;
      padding: 0;
    }
    .main .article .tag li {
      float: left;
      width: 50%;
    }
       .main .article .tag li:nth-child(4),
       .main .article .tag li:nth-child(5) {
      width: 25%;
    }
    .main .article .tag li i {
      margin-right: 2px;
    }
  }

</style>
