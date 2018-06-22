<template>
    <div class="main f-l">
      <article class="clearfix" v-for="(item,index) in page_items" :key="index">
        <div class="pic f-l t-c" >
          <a href="javascript:;"><img :src="item.a_img" alt="">
          </a>
        </div>
        <div class="content f-l">
          <a @click="SHOWARTICLE(index)" href="javascript:scroll(0,0)">
            <h3 class="title">{{item.a_title}}</h3>
          </a>
          <p class="summary" v-html="item.a_content" v-highlight ></p>
          <ul class="tag">
            <li  @click="_get_article_by_tag(item.a_tag)"><i class="glyphicon glyphicon-tag" ></i>{{item.a_tag}}</li>
            <li><i class="glyphicon glyphicon-pencil" ></i>{{item.a_author}}</li>
            <li><i class="glyphicon glyphicon-calendar" ></i>{{item.a_time}}</li>
            <li><i class="glyphicon glyphicon-comment" ></i>{{item.a_comment}}</li>
            <li><i class="glyphicon glyphicon glyphicon-heart" ></i>{{item.a_praise}}</li>
          </ul>
        </div>
      </article>

      <div class="page t-c">
        <ul>
          <li><a href="javascript:scroll(0,0);" @click="_changePage(0)" >首页</a></li>
          <li class="list-before" ><a href="javascript:scroll(0,0);" @click="_changePage('before')" >上一页</a></li>
          <li v-for="(count,index) in page_count" @click="_changePage(index)" :key="index" v-if="range(index)" ><a href="javascript:scroll(0,0); " :class="{actived:index==page_index}">{{ count }}</a></li>
          <li class="list-next"><a href="javascript:scroll(0,0);" @click="_changePage('next')" >下一页</a></li>
          <li><a href="javascript:scroll(0,0);" @click="_changePage(page_count.length-1)" >末页</a></li>
        </ul>
      </div>
    </div>

</template>


<script>
  import { mapActions,mapState,mapMutations } from 'vuex';
  export default {
    name: 'articleList',
    data(){
        return{
        };
    },
    methods:{
      ...mapActions(["getPage","getPageCount"]),
      ...mapMutations(["SHOWARTICLE","changePage","CHANGE_CRUMBS"]),
      _changePage: function(str) {
            if (str === "next") {
                if (this.page_index < this.page_count.length-1) {
                  //console.log(this.page_index);
                  //console.log(this.page_count.length-1);
                     let index = this.page_index + 1;
                     this.changePage(index);
                }
            } else if (str === "before") {
                if (this.page_index > 0) {
                    let index = this.page_index - 1;
                    this.changePage(index);
                }
            } else if (typeof str === "number") {
                this.changePage(str);
            } else {
              return;
            }
            this.getPage();
      },
      _get_article_by_tag:function(tag) {
            //console.log(this._crumbs);
            let obj = {};
            obj.tag = tag;
            obj.title = '';
            this.CHANGE_CRUMBS(obj);
            this.changePage(0);
            this.getPageCount();
            this.getPage(0);
            this.$router.push('/');
      },
      range: function(k) {
            let pageStart;
            let pageEnd;
            let pageRange = 5;
            let x = (pageRange-1)/2;
            let max = this.page_count.length-1;
            let index = this.page_index;
            //尾部区间
            if (index > (max - x)) {
                pageStart = max - x-2;
                pageEnd = max;
            }
            // 中间区间
            if (index >= x && index <= (max - x)) {
                pageStart = index - x;
                pageEnd = index + x;
            }
            // 开始区间
            if (index <= x) {
                pageStart = 0;
                pageEnd = pageRange;
            }

            if (pageStart && pageEnd) {
                return k <= pageEnd && k >= pageStart;
            } else {
                return k < pageRange;
            }
        }
    },
    computed: {
      ...mapState(["page_count","page_items","page_index"])
    },
    created:function(){
      this.getPage();
      this.getPageCount();
    },

    components: {

    }
  }

</script>

<style scoped>
  .main article {
    width: 100%;
    margin: 15px 0;
    background: #fff;
    border-radius: 10px;
    box-shadow: 3px 3px 8px 2px #ccc;
  }


  .main article .pic {
    width: 26%;
    height: 140px;
    margin:20px;
    overflow: hidden;
  }
  .main article .pic a img {
    width: 100%;
    height: auto;
    transition: all  0.3s linear;
    -webkit-transition: all  0.3s linear;
  }

  .main article:hover .pic a img {
    transform: scale(1.05);
    -webkit-transform: scale(1.1);
  }

  .main article .content {
    width: 64%;
    height: 140px;
  }
  .main article .content a {
    text-decoration: none;
  }

  .main article .content .title {
    color: rgba(33,33,33,0.8);
    cursor: pointer;
    height: 30px;
    text-shadow: 3px 3px 2px #ccc;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .main article .content .title:hover {
    color: #008888;
  }

  .main article .content .summary {
    height: 70px;
    margin-bottom: 10px;
    border-top:1px solid #aaa;
    white-space: pre-line;
    overflow : hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    word-break: break-all;
  }

  .main article .content .tag li {
    display: inline-block;
    padding: 0 10px;
    cursor: pointer;
  }
    .main article .content .tag li i {
      margin-right: 5px;
    }



main .page ul {
	margin: 20px;
}

main .page ul li {
	display: inline-block;
}
main .page ul li a {
	display:block;
  height: 25px;
  padding: 0 8px;
  margin: 0 5px;
	line-height: 25px;
	font-size: 16px;
	border-radius: 5px;
	background: #fff;
	box-shadow: 3px 3px 8px 2px #ccc;
  color: #111;
  text-decoration: none;
}
main .page ul li a:hover,
main .page ul li .actived {
	background:rgba(33,33,33,0.8);
	color: rgba(230,230,230,0.8);
}



  @media only screen and (min-width: 768px) and (max-width: 1024px) {
  .main article .content .tag li:nth-child(2) {
     display: none;
   }
    .main article .content .tag li {
    padding: 0 5px;
  }
  }


  @media only screen and (min-width: 560px) and (max-width: 760px) {

  .main article .content .tag li {
    padding: 0 5px;
  }
   .main article .content .tag li:nth-child(2) {
     display: none;
   }

  .list-before,
  .list-next {
    display: none !important;
  }


}


  @media only screen and (max-width: 560px) {
    .main article .pic {
      float: none !important;
      margin: 0 auto;
      margin-top: 20px;
      width: 90%;
    }
    .main article .content {
      float: none !important;
      margin: 0 auto;
    width: 90%;
  }

  .main article .content .title {
    text-shadow: none;
    font-size: 18px;
    margin-top: 10px;
    margin-bottom: 5px;
    height: 20px;
    line-height: 20px;
  }

  .main article .content .summary {
    height: 50px;
  }
  .main article .content .tag li {
    float: left;
    width: 50%;
  }
    .main article .content .tag li:nth-child(4),
    .main article .content .tag li:nth-child(5) {
    width: 25%;
  }

  .list-before,
  .list-next,
  main .page ul li:first-child,
  main .page ul li:last-child {
    display: none !important;
  }





  }



</style>
