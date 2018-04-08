<template>
  <div class="login-box center-block" v-show="loginbox" @click="change" >
    <transition name="show-login" >
      <div class="wrap" :class="{'login-height':!register_login_btn,'register-height':register_login_btn}" v-show="loginbox" @click="stopProp">
        <i @click="change" class="close-box glyphicon glyphicon-remove-circle" ></i>
        <h2>欢迎登录bianquan'blog</h2>
        <p>
          <input type="text" ref="input_email" @input="check_email" v-model="userEmail" placeholder="邮箱">
          <i class="glyphicon" :class="icon.email" ></i>
        </p>
        <p v-show="register_login_btn" >
          <input type="text"  ref="input_name" @input="check_name" v-model="userName" placeholder="用户名">
          <i class="glyphicon" :class="icon.name" ></i>
        </p>
        <p>
          <input type="password" ref="input_pwd" @input="check_pwd" v-model="userPwd" placeholder="密码">
          <i class="glyphicon" :class="icon.pwd"></i>
        </p> 
        <p v-show="register_login_btn">
          <input type="password" ref="input_cpwd" @input="check_cpwd" v-model="c_userPwd" placeholder="确认密码">
          <i class="glyphicon" :class="icon.cpwd"></i>
        </p> 
         <p v-show="!register_login_btn">
           <button type="button" class="btn btn-info"  @click="login" :disabled="login_btn" >立即登录</button>
          </p> 
          <p v-show="register_login_btn">
            <button type="button" class="btn btn-success" @click="register" :disabled="register_btn">立即注册</button>
          </p>
        <p><a href="javascript:;" @click="change_btn">{{ change_notice }}</a></p>
      </div>
    </transition>
  </div>
</template>

<script>
  import { mapState,mapMutations,mapActions } from "vuex";

  export default{
      data(){
        return {
          c_userPwd: '',
          check_result: {
            email: false,
            name: false,
            pwd: false,
            cpwd: false
          },
          icon: {
            name: '',
            email: '',
            pwd: '',
            cpwd: '',
          }
        }
      },
    methods:{
      ...mapMutations(["change","show_login_box","show_register_box"]),
      ...mapActions(["login","register"]),
      change_btn: function() {
          if(!this.register_login_btn) {
              this.show_register_box();
          } else {
            this.show_login_box();
          }
      },
      check_email:function() {
        this.check_result.email = false;
        let email = this.$refs.input_email.value;
        if(email) {
          let reg = new RegExp("^[a-z0-9]+([._\\-]*[a-z0-9])*@([a-z0-9]+[-a-z0-9]*[a-z0-9]+.){1,63}[a-z0-9]+$"); //正则表达式
          if(!reg.test(email)) {
            this.icon.email = 'glyphicon-remove';
            //console.log('邮箱格式不正确');
          } else {
            this.check_result.email = true;
            this.icon.email = 'glyphicon-ok';
            //console.log('邮箱正确');
          }       
        } else {
          this.icon.email = 'glyphicon-remove';
          //console.log('邮箱不能为空');
        }
      },
      check_name:function() {
        this.check_result.name = false;
        let name = this.$refs.input_name.value;
        if(name) {
          if(name.length<2 || name.length> 20) {
            this.icon.name = 'glyphicon-remove';
             //console.log('用户名不符合要求');
          } else {
            this.check_result.name = true;
            this.icon.name = 'glyphicon-ok';
            //console.log('用户名正确');
          }
         
        } else {
          this.icon.name = 'glyphicon-remove';
          //console.log('用户名不能为空');
        }
      },
      check_pwd:function() {
        this.check_result.pwd = false;
        let pwd = this.$refs.input_pwd.value;
        if(pwd) {
           if(pwd.length<5 || name.length> 20) {
             this.icon.pwd = 'glyphicon-remove';
             //console.log('密码不符合要求');
             this.check_cpwd();
          } else {
            this.check_result.pwd = true;
            this.icon.pwd = 'glyphicon-ok';
            //console.log('密码正确');
          }
        } else {
          this.icon.pwd = 'glyphicon-remove';
          //console.log('密码不能为空');
        }
      },
      check_cpwd:function() {
        this.check_result.cpwd = false;
        let cpwd = this.$refs.input_cpwd.value;
        if(cpwd == this.userPwd && cpwd) {
          this.icon.cpwd = 'glyphicon-ok';
            this.check_result.cpwd = true;
            //console.log('密码验证正确');
          } else {
            this.icon.cpwd = 'glyphicon-remove';
            //console.log('两次输入密码不等');
          }
      },
      //点击登录框阻止事件冒泡
      stopProp: function(e) {
        e = e || event;
        e.stopPropagation();
      },
    },
    computed: {
      ...mapState(["loginbox","register_login_btn","change_notice"]),
      register_btn:function() {
        if(this.check_result.email && this.check_result.name && this.check_result.pwd && this.check_result.cpwd) {
          return false;
        } else {
          return "disabled";
        }
      } ,
      login_btn:function() {
        if(this.check_result.email && this.check_result.pwd) {
          return false;
        } else {
           return "disabled";
        }
      } , 
      userEmail: {
        get () {
          return this.$store.state.userEmail;
        },
        set (value) {
          this.$store.commit('updateuserEmail', value)
        }
      },
      userName: {
        get () {
          return this.$store.state.userName
        },
        set (value) {
          this.$store.commit('updateuserName', value)
        }
      },
      userPwd: {
        get () {
          return this.$store.state.userPwd
        },
        set (value) {
          this.$store.commit('updateuserPwd', value)
        }
      }
    }
  }
</script>

<style scoped>

  .login-box{
    position: fixed;
    width: 100%;
    height:100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 999;
  }

  .login-box .wrap {
    position: absolute;
    width: 400px;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    margin: auto;
    text-align: center;
    background:#fff;
    box-shadow: 3px 3px 8px 2px #555;
    border-radius: 10px;
  }
  .login-box .login-height {
    height: 350px;
  }
  .login-box .register-height {
    height: 450px;
  }

  .login-box .wrap h2 {
    padding-top: 30px;
    padding-bottom: 30px;
  }

  .login-box .close-box {
    display: none;
    position: absolute;
    top: -5px;
    right: 20px;
    font-size: 30px;
    color: rgb(153, 4, 17);
    opacity: 0;
  }


  .login-box .wrap p {
    color: rgba(0, 0, 0,.5);
    height: 60px;
    line-height: 60px;
    margin: 0;
    padding: 0;
  }
  .login-box .wrap input {
    float: left;
    margin-top: 10px;
    margin-left: 70px;
    padding:0 20px;
    width: 250px;
    height:40px;
    border: 1px solid  rgba(0, 0, 0,.5);;
    border-radius: 3px;
    text-decoration: none;
    font-size: 16px;
  }
  .login-box .wrap i {
    float: left;
    margin-top: 22px;
    margin-left: 10px;
  }
  .btn-info,
  .btn-success {
    float: left;
    margin-top: 9px;
    margin-left: 70px;
    width: 250px;
    font-size: 20px;
  }
.result_msg,
.glyphicon-remove {
  color: #900
}

.glyphicon-ok {
  color: #090;
}


.show-login-enter-active {
  animation: bounce-in .8s;
}
.show-login-leave-active {
  animation: bounce-in .1s reverse;
}
@keyframes bounce-in {
  0% {
    transform: scale(0);
  }
  30% {
    transform: scale(1.1);
  }
  100% {
    transform: scale(1);
  }
}



  @media only screen and (max-width: 500px) {

    .login-box .wrap {
    width: 300px;
  }
  .login-box .close-box {
    display: block;
    opacity: 1;

  }
  .login-box .login-height {
    height: 350px;
  }
  .login-box .register-height {
    height: 450px;
  }

    .login-box .wrap h2 {
    padding-top: 20px;
    padding-bottom: 20px;
  }
    .login-box .wrap input {
    float: left;
    margin-top: 10px;
    margin-left: 20px;
  }
    .btn-info,
  .btn-success {
    margin-left: 20px;
  }
    .login-box .wrap i {
    margin-top: 22px;
    margin-left: 5px;
  }

  }


</style>

