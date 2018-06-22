<template>
  <div class="editor">
		<div class="table clearfix" v-for="(item,index) in all_comment" :key=index>
			<p class="clearfix" @click="_show_detail(index)">
        <span class="id" >ID</span>
        <span>所属文章ID:{{item.index}} &nbsp;&nbsp;&nbsp;&nbsp; 标题:{{item.title}} </span>
        <span>状态</span>
      </p>
      <transition-group name='slide-fade' >
      <ul v-show="show_detail == index"  v-for="(comment,_index) in item.content" :key="_index" >
        <li class="line" >
          <ul class="clearfix" >
            <!-- <li><span></span></li> -->
            <li>
              <span class="id">{{comment.c_id}}</span>
              <span :class="{'pull_right': comment.c_oldComment}">
                <span class="name">{{comment.c_user}}</span>
                  <i v-if="comment.c_oldComment">回复</i> 
                  <span class="name">{{comment.c_oldComment}}</span>
                  <span class="time">{{comment.c_time}}</span>
                  <span>{{comment.c_content}}</span>
              </span>
            </li>
            <li>
                <label  class="el-switch">
                  <input  @click="_publish(index,_index,comment.c_id,comment.c_published)" type="checkbox" name="switch" :checked="comment.c_published==1?'checked':null " :disabled="status=='admin'?null:'disabled'" >
                  <span class="el-switch-style"></span>
                </label>
              
            </li>
          </ul>

        </li>
      </ul>
        

        </transition-group> 
		
		</div>
     
  </div>
</template>

<script>
  import { mapState,mapActions } from 'vuex';


export default {
  data() {
    return {
      confirm_del: false,
      index: null,
      published:null,
      show_detail : 0,
    }
  },
  methods:{
    _publish: function(index,_index,id,published) {
      let data = {};
      data.index = index;
      data._index = _index;
      data.id = id;
      data.publish = published == 1?0:1;
      this.comment_publish(data);
    },
    _show_detail(index) {
      this.show_detail = index;
    },
    ...mapActions(["get_all_comment","comment_publish"])

  },
  computed:{
    ...mapState(["all_comment","status"])
  },
  created:function() {
   this.get_all_comment();

  },
  mounted:function() {
  }
}
</script>

<style scoped>

  .editor {
    width: 100%;
  }
  .table {
    background: #fff;
    width: 90%;
    margin: 15px auto;
  }
  .table p {
    cursor: pointer;
  }
  .table p,
  .table ul {
    width: 100%;
  }
  .table p,
  .table ul li {
    border-bottom: 1px solid #ccc;
  }
  .table p span,
  .table ul li ul li {
    float: left;
    border: none;
    padding: 10px 10px;
    line-height: 17px;
  }

 .id {
   display: inline-block;
   width: 30px;
   padding: 5px 0;
 }

  .table p span:nth-child(3),
  .table ul li ul li:nth-child(2) {
    width: 70px;
    float: right;
  }

  label.el-switch {
    margin-bottom: 0;
  }



  .name {
    color: #f37c0c;
    font-weight: 600;
  }
  .time {
    color: rgb(4, 100, 95);
    font-weight: 500;
    margin-right: 20px;
  }
  .pull_right {
    padding-left: 30px;
  } 
      .slide-fade-enter-active {
        transition: all .8s ease;
      }
      .slide-fade-leave-active {
        transition: all .5s ease;
      }
      .slide-fade-enter {
        transform: translateY(-30px);
        opacity: 0;
      }

      .slide-fade-leave-to {
        transform: translateY(10px);
        opacity: 0;
      }

@media only screen and (max-width: 768px) {




    .table {
    width: 98%;
  }
}


</style>
