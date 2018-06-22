<template>
  <div class="others">
    <div class="row">
      <div class="col-md-12">
        <div class="thumbnail">
          <p><i class="glyphicon glyphicon-info-sign" ></i>about other setting</p>
          <markdown-editor v-model="about_markdown" ref="markdwonEditor" :configs="configs" ></markdown-editor>
           <button type="button" @click="update_about" class="about-btn btn btn-default">
                <i class="glyphicon glyphicon-refresh" ></i>
                更新about
              </button>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="thumbnail">
          <p><i class="glyphicon glyphicon-tags" ></i>标签管理</p>
          	<div class="tagCon">
              <ul>
                <li v-for="(tag,index) in options" :key="index" >
                  <i class="glyphicon glyphicon-tag" ></i>
                  {{tag.tag}}
                  <i @click="_del_tags(tag.tag,index)" class="remove glyphicon glyphicon-remove-circle" ></i>
                </li>
              </ul>
            </div>
            <div class="addBox">
              <input type="text" v-model="new_tag" class="form-control" placeholder="add new tags">
              <button type="button" @click="_add_tags" class="btn btn-default">
                <i class="glyphicon glyphicon-plus-sign" ></i>
                添加标签
              </button>
            </div>
        </div>
      </div>
    </div>
        <div class="row">
      <div class="col-md-12">
        <div class="thumbnail">
          <p><i class="glyphicon glyphicon-link" ></i>友情链接管理</p>
          <div class="addBox">
            <input v-model="neighbors.name" type="text" class="form-control" placeholder="name">
            <input v-model="neighbors.icon" type="text" class="form-control" placeholder="icon">
            <input v-model="neighbors.url" type="text" class="form-control" placeholder="url">
              <button type="button" @click="_add_neighbors" class="btn btn-default">
                <i class="glyphicon glyphicon-plus-sign" ></i>
                添加友邻
              </button>
          </div>
          <div class="list">
            <ul>
              <li v-for="(item,index) in all_neighbors" :key="index" >
                <i class="glyphicon glyphicon-paperclip" ></i>
                <span>name:</span>{{item.nb_name}}
                <span>url:</span>{{item.nb_url}}
                <span>icon:</span>{{item.nb_icon}}
                <span>time:</span>{{item.nb_time}}
                 <i @click="_del_neighbors(index)" class="remove glyphicon glyphicon-remove-circle" ></i>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import { mapState,mapActions,mapMutations } from 'vuex';


export default {
  data() {
    return {
      new_tag: '',
      neighbors: {//添加友情链接用容器
        name:'',
        url:'',
        icon:'',
        publish:1
      },
      configs: {
                status: false,
                spellChecker: false,
                placeholder:"about bianquan'blog",
              }
      
    }
  },
  methods:{
    ...mapActions(["add_tags","del_tags","add_neighbors","del_neighbors","update_about","get_about"]),
    ...mapMutations(["show_alert"]),
    _add_tags:function() {
      let tag = this.new_tag;
      if(tag){
        this.add_tags(tag);
        this.new_tag = '';
      } else {
        this.show_alert('请填写要新增标签');
      }
    },
    _del_tags:function(tag,index) {
      let obj = {};
      obj.tag = tag;
      obj.index = index;
      this.del_tags(obj);
    },
    _add_neighbors:function() {
      if(this.neighbors.name && this.neighbors.icon && this.neighbors.icon) {
        let obj = {};
        obj.name = this.neighbors.name;
        obj.icon = this.neighbors.icon;
        obj.url = this.neighbors.url;
        obj.publish = this.neighbors.publish;
        this.add_neighbors(obj);
        this.neighbors.name = '';
        this.neighbors.url = '';
        this.neighbors.icon = '';
      } else {
        this.show_alert('请确保信息完整');
      }

    },
    _del_neighbors:function(index) {
      this.del_neighbors(index);
    }

  },
  computed:{
    ...mapState(["options","all_neighbors"]),
    about_markdown:{
        get () {
          return this.$store.state.about_markdown
        },
        set (value) {
          this.$store.commit('updateabout', value)
        }
      }
  },
  created:function() {
    if(!this.about_markdown) {
      this.get_about();
    }
  },
  mounted:function() {
  }
}
</script>




<style scoped>
  .others {
    width: 100%;
    margin-bottom: 30px;
  }
  .others .row {
    padding: 10px 40px;
  }
  .thumbnail {
    overflow: hidden;
    margin-bottom: 0;
     box-shadow: 0 0 1px 1px   rgba(0, 0, 0, .1);
  }
  .thumbnail p {
    padding-left: 20px;
    margin: 10px 0;
    font-size: 20px;
    font-weight: 600;
    color: #aaa;
  }

  .about-btn {
    margin: 20px;
    color: #888;
  }
  .thumbnail p i {
    margin-right: 5px;
  }
 .addBox{
    width: 100%;
    padding: 5px 25px 10px 30px;
    margin: 10px auto;
    border-radius: 4px;
}
.addBox input {
  margin-bottom: 10px;
  display: inline-block;
  width: 70%;
}
.addBox button {
  display: inline-block;
  color: #aaa;

}
.tagCon{
  width: 100%;
  padding: 10px;
}
.tagCon ul li {
  display: inline-block;
  padding: 8px;
  margin-left: 20px;
  border: 1px solid #eee;
  border-radius: 20px;
  color: #666;
  
}
.tagCon ul li:hover {
  transition: all 1s;
  border: 1px solid #4df;
}
.glyphicon-remove-circle  {
  cursor: pointer;
  color: #aaa;
}
.glyphicon-remove-circle:hover {
  color: #4db8ff
}

.list li {
  padding: 5px 30px;
  color: #666;
}
.list li span {
  font-weight: 600;
  padding: 5px;
  color: #d55;
}



 
 

  @media only screen and (max-width: 768px) {
 
  .others .row {
    padding: 10px 10px;
  }

  .addBox input {
  width: 100%;
  }
  .tagCon ul li {
    margin-bottom: 5px;
    margin-left: 5px;
  }




  } 


</style>
