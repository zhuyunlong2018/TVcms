<template>
    <div class="admin">
      <admin-header></admin-header>
      <all-images></all-images>
      <div class="admin-main" @click="close_logout" >
            <transition name="logoutbox" >
                <p class="logout" @click="stopProp" v-show="logout_box" >
                    <i class="glyphicon glyphicon-off" ></i>
                    <span @click="_logout" >退出登录</span>
                </p>
            </transition>
            <router-view></router-view>
        </div>
        <admin-aside></admin-aside>
        <div class="show-sidebar-btn" @click="_show_sidebar"  >
        <i class="glyphicon" :class="_change_color" ></i>
        </div>
    </div>
</template>



<script>
  import adminHeader from '../components/admin_header.vue';
  import adminAside from '../components/admin_aside.vue';
  import allImages from '../components/all_images.vue';
  import { mapActions,mapState,mapMutations } from 'vuex';

    export default {
        data () {
            return {
                isCollapsed: false
            }
        },
      components: {
              adminHeader,
              adminAside,
               allImages
            },
        methods: {
            ...mapMutations(['close_logout','logout','close_logout','toggle_sidebar']),
            _show_sidebar:function() {

            },
            _logout:function() {
                this.$router.push('/');
                this.close_logout();
                this.logout();
            },
             _show_sidebar:function() {
                 this.toggle_sidebar();
            },
            stopProp: function(e) {
            e = e || event;
            e.stopPropagation();
            }
        },
        computed: {
            ...mapState(['logout_box','show_sidebar']),
            _change_color: function() {
                if(this.show_sidebar) {
                return 'white glyphicon-circle-arrow-left';
                } else {
                return 'black glyphicon-circle-arrow-right';
                }
            }
        }
            
    }
</script>



<style scoped>
.admin-main {
    position: absolute;
	top: 38px;
	left: 230px;
    right: 0;
    bottom: 0;
    height: auto;
	width: auto;
    overflow-y: scroll;
	z-index: 810;
    box-shadow: inset 1px 1px 1px #ccc;
	background-color: #edf1f2;
}
.logout {
  position: fixed;
  top: 40px;
  right: 40px;
  height: 38px;
  line-height: 38px;
  width: 100px;
  text-align: center;
  z-index: 9999;
  background:#fff;
  border-radius: 8px;
  box-shadow: 1px 1px 1px #ccc;
  cursor: pointer;
}

.logoutbox-enter-active {
  transition: all .3s ease;
}
.logoutbox-leave-active {
  transition: all .3s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}
.logoutbox-enter, .logoutbox-leave-to
/* .slide-fade-leave-active for below version 2.1.8 */ {
  transform: translateX(10px);
  opacity: 0;
}

.show-sidebar-btn {
  display: none;
  opacity: 0;
}

.black {
  color: #000;
  left: 5px;
  transition: all 0.5s;
}

.white {
  color: rgb(252, 71, 0);
  left: 140px;
  transition: all 0.5s;
}


 @media only screen and (max-width: 1024px) {
     .admin-main {
         left: 130px;
     }
 }

 @media only screen and (max-width: 500px) {
      .admin-main {
         left: 0px;
     }
 .show-sidebar-btn {
   position: fixed;
  font-size: 30px;
  z-index: 9998;
  display: block;
  bottom: 10px;
  left: 0px;
  opacity: 1;
}
 }



</style>



<style>
.el-switch,
.el-switch-style,
.el-switch-style:before {
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}
.el-switch {
  display: inline-block;
  font-size: 100%;
  height: 1.6em;
  position: relative;
}
.el-switch .el-switch-style {
  height: 1.6em;
  left: 0;
  background: #C0CCDA;
  -webkit-border-radius: 0.8em;
  border-radius: 0.8em;
  display: inline-block;
  position: relative;
  top: 0;
  -webkit-transition: all 0.3s ease-in-out;
  transition: all 0.3s ease-in-out;
  width: 3em;
  cursor: pointer;
}
.el-switch .el-switch-style:before {
  display: block;
  content: '';
  height: 1.4em;
  position: absolute;
  width: 1.4em;
  background-color: #fff;
  -webkit-border-radius: 50%;
  border-radius: 50%;
  left: 0.1em;
  top: 0.1em;
  -webkit-transition: all 0.3s ease-in-out;
  transition: all 0.3s ease-in-out;
}
.el-switch > input[type="checkbox"] {
  display: none;
}
.el-switch > input[type="checkbox"][disabled] + .el-switch-style {
  cursor: not-allowed;
  background-color: #D3DCE6;
}
.el-switch > input[type="checkbox"]:checked + .el-switch-style {
  background-color: #20a0ff;
}
.el-switch > input[type="checkbox"]:checked + .el-switch-style:before {
  left: 50%;
}


.editor-toolbar.fullscreen,
.CodeMirror-fullscreen {
  left: 230px !important;
}
.CodeMirror-sided {
    right: 40%;
    width: auto!important
}
.editor-preview-side {
    width: 40%;
}
.editor-preview-side img {
    max-width: 100%;
}


 @media only screen and (max-width: 1024px) {
     .editor-toolbar.fullscreen,
    .CodeMirror-fullscreen {
    left: 130px !important;
    }
 }

</style>