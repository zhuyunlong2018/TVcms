<template>
  <div class="member">
    <div class="row">
      <div class="col-sm-6 col-md-4" v-for="(user,index) in all_user" :key="index" >
        <div class="thumbnail">
          <div class="icon"><i class="glyphicon glyphicon-user"></i></div>
          <div class="name">
            <h2>000{{user.u_id}}</h2>
            <h4><span>{{user.name}}</span>
              <span class="status" >{{user.u_status=='admin'?'管理员':user.u_status=='member'?'会员':'游客'}}</span>
            </h4>

          </div>
          <p>邮箱:{{user.u_email?user.u_email:'暂无权限查看邮箱'}}</p>
          <p>注册时间:{{user.u_time?user.u_time:'未注册'}}</p>
        </div>
      </div>


    </div>
  </div>
</template>

<script>
  import { mapState,mapActions } from 'vuex';


export default {
  data() {
    return {
      
    }
  },
  methods:{
    ...mapActions(["show_all_user"])

  },
  computed:{
    ...mapState(["all_user"])
  },
  created:function() {
   this.show_all_user();

  },
  mounted:function() {


  }
}
</script>

<style scoped>
  .member {
    width: 100%;
  }
  .member .row {
    padding: 20px 40px;
  }
  .thumbnail {
    height: 200px;
     box-shadow: 0 0 1px 1px   rgba(0, 0, 0, .1);
  }
    .thumbnail:hover {
      box-shadow: inset 0 0 2px 1px   rgba(0, 0, 0, .1);
      background: #f5f2f1;

    }

     .thumbnail .icon {
       float: left;
       width: 80px;
       height: 80px;
       margin: 20px;
       line-height: 80px;
       text-align: center;
       font-size: 50px;
       border-radius: 50%;
       color: rgba(0, 0, 0, .1);
       border: 1px solid rgba(0, 0, 0, .1);
     }
     .thumbnail .name {
       margin-top: 30px;
       float: right;
       width: 50%;
       height: 80px;
       line-height: 80px;
       
     }
     .thumbnail .name h4 {
       font-weight: 600;
       
     }
     .thumbnail p {
       float: left;
       width: 100%;
       margin-top: 10px;
       margin-left: 30px;
     }
     .status {
       color: #c02f03;
       
     }

@media only screen and (min-width: 768px) and (max-width: 1280px) {
 .thumbnail .icon {
   margin: 10px 0 30px 10px;
   width: 50px;
   height: 50px;
   font-size: 30px;
    line-height: 50px;
 }
     .thumbnail .name {
       margin-top: 10px;
       float: right;
       width: 70%;
       height: 50px;
       line-height: 50px;
     }

     .thumbnail p {
       margin-left: 10px;
     }

}


@media only screen and (max-width: 400px) {
  .member .row {
    padding: 20px;
  }

}
 


</style>
