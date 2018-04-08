<template>
  <div class="outline">
    <div class="row">
      <div class="col-sm-4 col-md-4">
        <div class="thumbnail">
          <div class="caption">
            <div class="icon article" >
              <i class="glyphicon glyphicon-file" ></i>
            </div>
            <div class="text">
              <span class="num" >{{ webdata.article }}</span>
              <span class="des" >文章总数</span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-4 col-md-4">
        <div class="thumbnail">
          <div class="caption">
            <div class="icon comment" >
              <i class="glyphicon glyphicon-comment" ></i>
            </div>
            <div class="text">
              <span class="num" >{{ webdata.comment }}</span>
              <span class="des" >评论总数</span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-4 col-md-4">
        <div class="thumbnail">
          <div class="caption">
            <div class="icon praise" >
              <i class="glyphicon glyphicon-heart" ></i>
            </div>
            <div class="text">
              <span class="num" >{{ webdata.praise }}</span>
              <span class="des" >点赞总数</span>
            </div>
          </div>
        </div>
      </div>
    </div>
      <div class="message" >
          <ul>
             <li><span> 博客名称</span>
              <i class="glyphicon glyphicon-text-color" ></i>
                边泉博客管理平台
            </li>
            <li><span>系统基础</span>
              <i class="glyphicon glyphicon-wrench" ></i>
                PHP+MySQL+VUE全家桶
            </li>
            <li><span> 当前时间</span>
            <i class="glyphicon glyphicon-time" ></i>{{now_time}}</li>
            <li> <span>本站已运行</span>
            <i class="glyphicon glyphicon-calendar" ></i>{{how_long}}天</li>
          </ul>
      </div>
  </div>
</template>

<script>
  import { mapState } from 'vuex';
  export default {
      computed: {
        ...mapState(["webdata","now_time","how_long"])
      }
  }
</script>



<style>
  .outline {
    width: 80%;
    margin: 0 auto;

  }
  .outline .row {
    margin-top: 40px;
  }
  .caption {
    text-align: center;
    cursor: pointer;
  }

@media only screen and (max-width: 900px) {
    .outline {
    width: 95%;
  }
  
}





</style>



<style scoped>

  .caption .icon {
    width: 40%;
    height: 80px;
    display: inline-block;
    font-size: 70px;
    -webkit-transition: all 1s, -webkit-transform 1s; /* For Safari 3.1 to 6.0 */
    transition: all 1s, transform 1s;
  }
  .caption:hover .icon {
    color: rgb(155, 68, 255);
    -webkit-transform: rotate(360deg); /* Chrome, Safari, Opera */
    transform: rotate(360deg);
  }
  .caption:hover .text {
    color: #f829ee
  }
  .caption .article {
     color: #4df;
  }
  .caption .comment {
     color: rgb(107, 252, 139);
  }
  .caption .praise {
     color: rgb(255, 127, 68);
  }
  .caption .text {
    width: 50%;
    display: inline-block;
  }
  .caption .text .num {
    font-size: 45px;
    display: block;
  }
  .message {
    width: 100%;
    background: #fff;
    padding: 10px;
  }
  .message ul li {
    border: 1px solid #aaa;
    margin-bottom: -1px;
    
  }
  .message ul li span {
    text-align: center;
    display: inline-block;
    padding: 10px;
    width: 30%;
    height: 100%;
    border-right: 1px solid #aaa;
  }
  .message ul li i {
    padding: 0 20px;
  }


@media only screen and (max-width:600px) {
    .message ul li span {
    padding: 10px 0;
  }
  .message ul li i {
    padding: 0 5px;
  }
  .message ul li {
    height: 46px;
    overflow: hidden;
  }
}




</style>
