<template>
  <div class="lab">
        <div class="row">
      <div class="col-md-12">
        <div class="thumbnail">
          <p><i class="glyphicon glyphicon-wrench" ></i>实验室管理</p>
          <div class="addBox">
            <input v-model="lab.name" type="text" class="form-control" placeholder="项目名称">
            <input v-model="lab.url" type="text" class="form-control" placeholder="地址:../../static/lab/项目名称.html">
            <textarea v-model="lab.content" rows="10" placeholder="段落描述(用英文,来分页)分页数量必须与图片数量一致" ></textarea>
            <div class="img">
              <ul>
                <li v-for="(img,index) in lab_imgs" :key="index" >
                  <img :src="img" alt="">
                  <p @click="_remove_lab_img(index)" >删除</p>
                </li>
              </ul>
            </div>
             <button @click="_get_all_imgs" type="button"  class="btn btn-default">
                <i class="glyphicon glyphicon-plus-sign" ></i>
                打开图库
              </button>
              <button v-show="lab.change_btn" type="button" @click="_production(true)" class="btn btn-default">
                <i class="glyphicon glyphicon-plus-sign" ></i>
                添加项目
              </button>
             <button v-show="!lab.change_btn" type="button" @click="_production(false)" class="btn btn-default">
                <i class="glyphicon glyphicon-plus-sign" ></i>
                修改项目
              </button>
          </div>
          <div class="list">
            <ul>
              <li v-for="(item,index) in production" :key="index" >
                <i class="glyphicon glyphicon-paperclip" ></i>
                <span class="name" >name:</span><span :class="{'unpublished':item.pr_published==0?true:false}" >{{item.pr_name}}</span>
                 <i @click="change_production(index)" class="glyphicon glyphicon-pencil" ></i>
                 <i @click="publish_production(item.pr_id,0)" v-show="item.pr_published==1?true:false" class="glyphicon glyphicon-remove-circle" ></i>
                 <i @click="publish_production(item.pr_id,1)" v-show="item.pr_published==0?true:false" class="glyphicon glyphicon-ok-circle" ></i>
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
      lab: {
        name: '',
        content: '',
        url: '',
        change_btn: true,
        id:''
      }
    }
  },
  methods:{
    ...mapActions(["get_all_imgs",'get_production']),
    ...mapMutations(["show_alert","show_all_imgs","remove_lab_img","clear_lab_img","show_alert_notice"]),
    _production:function(boole) {
      if(this.lab.name && this.lab.url && this.lab.content && this.lab_imgs.length>0) { 
        //console.log(this.lab_imgs);
        let params = {
                    'name': this.lab.name,
                    'url': this.lab.url,
                    'content': this.lab.content,
                    'imgs': this.lab_imgs.toString(),
                    'time': this.now_time,
                    'publish': 0
                  };
        if(boole) {
          params.act = 'add_production';
        } else {
           params.act = 'edit_production';
           params.id = this.lab.id;
        }
        //console.log(this.lab.content);
        let _this = this
        this.$http({
              method: "post",
              url: this.URL,
              data: params
            }).then(function (res) {
              if(res.data.result) {
                _this.show_alert_notice('操作项目成功');
                let data = [];
                _this.clear_lab_img(data);
                _this.lab.name = '';
                _this.lab.url = '';
                _this.lab.content = '';
                _this.lab.change_btn = true;
                _this.get_production();
              }
              if(res.data.error == 'Permission denied') {
                  _this.show_alert('权限不足');
                }

            })
              .catch(function (err) {
                console.log(err);
                console.log('失败了');
              });

      } else {
        this.show_alert('请确保信息完整');
      }
    },
    _get_all_imgs:function() {
        if(this.all_images.src.length == 0) {
          this.get_all_imgs();
        }
        this.show_all_imgs(false);
      },
      _remove_lab_img:function(index) {
        this.remove_lab_img(index);
      },
      change_production:function(index) {
        this.lab.name = this.production[index].pr_name;
        this.lab.content = this.production[index].pr_content.toString();
        this.lab.url = this.production[index].pr_src;
        this.lab.id = this.production[index].pr_id;
        this.clear_lab_img(this.production[index].pr_img);
        this.lab.change_btn = false;
      },
      publish_production:function(id,publish) {
        let params = {
          'act': 'toggle_production',
          'id':id,
          'publish': publish
        }
        let _this = this;
        this.$http({
              method: "post",
              url: this.URL,
              data: params
            }).then(function (res) {
              if(res.data.result) {
                _this.show_alert_notice('操作项目成功')
                _this.get_production();
              }
              if(res.data.error == 'Permission denied') {
                  _this.show_alert('权限不足');
                }
            })
              .catch(function (err) {
                console.log(err);
                console.log('失败了');
              });
      }

  },
  computed:{
    ...mapState(["lab_imgs","all_images","URL","now_time","production"]),

  },
  created:function() {
      this.get_production();
    },
  mounted:function() {
    }
}
</script>

<style scoped>
  .lab {
    width: 100%;
    margin-bottom: 30px;
  }
  .lab .row {
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
.list li {
  margin-left: 25px;
}
.list li i  {
  cursor: pointer;
  color: #aaa;
  padding: 5px;

}
.list li i:hover {
  color: #4db8ff
}

.list li span.name {
  font-weight: 600;
  padding: 5px;
  color: #d55;
}

textarea {
  width: 70%;
  border: 1px solid #ccc;
  border-radius: 5px;
  padding: 10px;
}

.img {
  width: 100%;
  height: 150px;
  margin-bottom: 10px;
  overflow: hidden;
}
.img ul li {
  position: relative;
  float: left;
  width: 200px;
  height: 150px;
  border: 1px solid #ccc;
  margin-right: 10px;
  overflow: hidden;
  border-radius: 5px;
}
.img ul li img {
  width: 200px;
}

.img ul li p{ 
  position: absolute;
  bottom: 0;
    width: 100%; 
    height: 30px; 
    margin: 0;
    background: rgba(0,0,0,0.5); 
    text-align: center; 
    line-height: 30px; 
    color: white; 
    font-size: 16px; 
    font-weight: bold; 
    cursor: pointer; 
} 

.unpublished {
  text-decoration: line-through;
    color: #666;
}

  @media only screen and (max-width: 768px) {
 
  .lab .row {
    padding: 10px 10px;
  }

  .addBox input {
  width: 100%;
  }
  .tagCon ul li {
    margin-bottom: 5px;
    margin-left: 5px;
  }
  textarea {
    width: 100%;
  }




  } 


</style>
