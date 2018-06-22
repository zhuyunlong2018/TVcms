<template>
    <div>
        <!-- 弹出alert -->
      <transition name="show-alert">
      <div class="mask" v-show="alert.show" >
        <div class="alert">
            <div class="title">
            {{ alert.msg }}
            </div>
            <div class="content">
              <button type="button" class="btn btn-info" @click="close_alert" >确认</button>
            </div>
        </div>
      </div>
    </transition>
     <!-- 自动关闭提示窗 -->
      <transition name="show-alert-notice">
      <div class="mask alert-notice" v-show="alert_notice.show" >
        <div class="notice-msg">
           {{alert_notice.msg}}
        </div>
      </div>
    </transition>
    <!-- 查看大图 -->
    <transition name="show-alert">
      <div class="mask" v-show="show_img.box" @click="close_show_img" >
        <i class="glyphicon glyphicon-resize-small" ></i>
        <div class="show_img">
            <img :src="show_img.src" :style="show_width" alt="">
        </div>
      </div>
    </transition>
      <!-- 加载动画 -->
    <transition name="show-alert">
      <div v-show="show_loading" class="mask loading">
        <div class="spinner7">
          <div class="spinner-container container1">
            <div class="circle1"></div>
            <div class="circle2"></div>
            <div class="circle3"></div>
            <div class="circle4"></div>
          </div>
          <div class="spinner-container container2">
            <div class="circle1"></div>
            <div class="circle2"></div>
            <div class="circle3"></div>
            <div class="circle4"></div>
          </div>
          <div class="spinner-container container3">
            <div class="circle1"></div>
            <div class="circle2"></div>
            <div class="circle3"></div>
            <div class="circle4"></div>
          </div>
        </div>
      </div>
    </transition>
    <!-- 弹出搜索框 -->
    <transition name="show-search">
      <div v-show='search.box' class="mask" >
        <div  class="search-box" :class="{'bing-blur': bing_blur }" :style="{backgroundImage:'url('+search.bing+')',backgroundRepeat:'no-repeat', backgroundPosition:'center center', backgroundSize: 'cover' }" >
        </div>
        <div class="search">
          <div class="logo"></div>
          <div class="input">
            <input v-model="searchkey" @focus="input_event(true)" @blur="input_event(false)" type="text" placeholder="Search for..." />
            <input type="submit" value="Go!" @click='_searchfor' />
          </div>
          <div @click="TOGGLE_SEARCH(false)" class="close-search"><i class="glyphicon glyphicon-menu-down" ></i></div>
        </div>
      </div>
    </transition>
    </div>
</template>

<script>

import { mapState,mapMutations,mapActions } from 'vuex';
export default {
       data(){
          return{
              show_width: {
                  width: ''
              },
              bing_blur: false,
              searchkey: ''
          }
      },
  methods: {
    ...mapMutations(['close_alert','take_img_src','close_show_img','TOGGLE_SEARCH']),
    ...mapActions(['searchfor']),
    stopProp: function(e) {
        e = e || event;
        e.stopPropagation();
      },
    input_event:function(bloor) {
        //console.log(bloor);
        this.bing_blur = bloor;
      },
    _searchfor: function() {
      let key = this.searchkey;
      key = key.replace(/\s+/g,"");
      if(key == '') {
         return;
      }
      this.searchfor(key);
    }
  },
  computed: {
    ...mapState(['alert','show_img','show_loading','search','alert_notice'])
  },
  created:function() {
    document.addEventListener('click', (e) => {
    if(e.target.tagName === 'IMG') {
        let w = document.documentElement.clientWidth || document.body.clientWidth;
        let h = document.documentElement.clientHeight || document.body.clientHeight;
        let img_height = e.target.naturalHeight;
        let img_width = e.target.naturalWidth;
        let scale = 0.9;
        let show_width,show_height;
        if(img_height>h*scale) {//判断图片高度
            show_height = h*scale;//如大于窗口高度，图片高度进缩放
            show_width = show_height/img_height*img_width;//等比例缩宽度
            if(show_width>w*scale) {//如宽度扔大于窗口宽度
                show_width = w*scale;//再对宽度进行缩放
            }
        } else if(img_width>w*scale) {//如图片高度合适，判图片宽度
            show_width = w*scale;//如大于窗口宽度，图片宽度进缩放
        } else {//如果图片真实高度和宽度都符合要求，高宽不变
            show_width = img_width;
        }
        this.show_width.width = show_width + 'px';
        this.take_img_src(e.target.src);

    }
})
  }
}
</script>


<style scoped>

  .mask {
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    margin: auto;
    z-index: 99999;
    background: rgba(30,30,30,0.9);
  }

.mask .glyphicon-resize-small {
  font-size: 40px;
  position: absolute;
  top: 30px;
  right: 30px;
  z-index: 50;
  color: #fff;
  cursor: pointer;
  padding: 5px;
  border-radius: 5px;
  border: 3px solid #fff;
}

.alert-notice {
  width: 300px;
  height: 150px;
  border-radius: 5px;
  opacity: 0.7;
}

.notice-msg {
  position: absolute;
  width: 300px;
  height: 50px;
  line-height: 50px;
  top: 0;
  bottom: 0;
  left: 0;
   right: 0;
   margin: auto;
  color: #fff;
  text-align: center;
  font-size: 20px;
}





.mask .glyphicon-resize-small:hover {
  color: #4fd;
  border: 3px solid #4fd;
}
.show_img img {
    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    margin: auto;
}

.alert {
	width: 300px;
	height: 150px;
	background: rgba(255, 255, 255, 1);
	position: absolute;
	left: 0;
	top: 0;
	right: 0;
	bottom: 0;
	margin: auto;
	z-index: 47;
	border-radius: 5px;
 }

.title {
  text-align: center;
  color: #900;
	padding: 10px;
	border-bottom: 1px solid #eee;
 }


.content {
	padding: 10px;
  text-align: center;
 }

 .content button {
   margin: 20px 30px;
   padding-left: 50px;
   padding-right: 50px;
 }

 .show-alert-enter-active {
  animation: bounce-in .8s;
}
.show-alert-leave-active {
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



 .show-alert-notice-enter-active {
  animation: bounce-out .5s reverse;
}
@keyframes bounce-out {
  0% {
    opacity: 1;
  }
  50% {
    opacity: 0.5;
  }
  100% {
    opacity: 0;
  }
}




.loading {
  background: rgba(30,30,30,0);
  width: 80px;
  height: 80px;
}

.spinner7 {
  margin: auto;
  width: 80px;
  height: 80px;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
  position: absolute;
}

.container1 > div, .container2 > div, .container3 > div {
  width: 15px;
  height: 15px;
  background-color: #0099ff;

  border-radius: 100%;
  position: absolute;
  -webkit-animation: bouncedelay 1.2s infinite ease-in-out;
  animation: bouncedelay 1.2s infinite ease-in-out;
  -webkit-animation-fill-mode: both;
  animation-fill-mode: both;
}

.spinner7 .spinner-container {
  position: absolute;
  width: 100%;
  height: 100%;
}

.container2 {
  -webkit-transform: rotateZ(45deg);
  transform: rotateZ(45deg);
}

.container3 {
  -webkit-transform: rotateZ(90deg);
  transform: rotateZ(90deg);
}

.circle1 { top: 0; left: 0; }
.circle2 { top: 0; right: 0; }
.circle3 { right: 0; bottom: 0; }
.circle4 { left: 0; bottom: 0; }

.container2 .circle1 {
  -webkit-animation-delay: -1.1s;
  animation-delay: -1.1s;
}

.container3 .circle1 {
  -webkit-animation-delay: -1.0s;
  animation-delay: -1.0s;
}

.container1 .circle2 {
  -webkit-animation-delay: -0.9s;
  animation-delay: -0.9s;
}

.container2 .circle2 {
  -webkit-animation-delay: -0.8s;
  animation-delay: -0.8s;
}

.container3 .circle2 {
  -webkit-animation-delay: -0.7s;
  animation-delay: -0.7s;
}

.container1 .circle3 {
  -webkit-animation-delay: -0.6s;
  animation-delay: -0.6s;
}

.container2 .circle3 {
  -webkit-animation-delay: -0.5s;
  animation-delay: -0.5s;
}

.container3 .circle3 {
  -webkit-animation-delay: -0.4s;
  animation-delay: -0.4s;
}

.container1 .circle4 {
  -webkit-animation-delay: -0.3s;
  animation-delay: -0.3s;
}

.container2 .circle4 {
  -webkit-animation-delay: -0.2s;
  animation-delay: -0.2s;
}

.container3 .circle4 {
  -webkit-animation-delay: -0.1s;
  animation-delay: -0.1s;
}

@-webkit-keyframes bouncedelay {
  0%, 80%, 100% { -webkit-transform: scale(0.0) }
  40% { -webkit-transform: scale(1.0) }
}

@keyframes bouncedelay {
  0%, 80%, 100% {
    transform: scale(0.0);
    -webkit-transform: scale(0.0);
  } 40% {
    transform: scale(1.0);
    -webkit-transform: scale(1.0);
  }
}

  .bing-blur {
    opacity: 0.8;
    -moz-filter: blur(5px);
    -webkit-filter: blur(5px);
    -o-filter: blur(5px);
    -ms-filter: blur(5px);
    filter: blur(5px);

  }
  .search-box {
    height: 100%;
  }

  .search {
    position: absolute;
    width: 800px;
    height: 300px;
    cursor: pointer;
    overflow: hidden;
    top: 0;
    left: 0;
    right: 0;
    bottom: 100px;
    margin: auto;
  }
  .search .logo {
    float: left;
    width: 175px;
    height: 72px;
    margin-right: 20px;
    opacity: 0.8;
    background: url(../../static/imgs/bian.png) no-repeat;
  }
  .search .input {
    text-align: center;
    width: 500px;
    margin: 30px auto;
  }



.search .input input[type="text"]{
  width: 350px;
  display: inline-block;
  border:none;
  outline: 0;
  font-family: 'Arvo', serif;
  height: 40px;
  padding: 2px 15px 5px 15px;
}

.search .input input[type="submit"]{
  width: 70px;
  font-size: 17px;
  display: inline-block;
  text-align: center;
  font-weight: bold;
  background: #ffd742;
  border: none;
  outline: 0;
  height: 40px;
  padding: 8px 15px 26px 15px;
  cursor: pointer;
  margin-top: -3px;
}

input[type="submit"]:hover{
  opacity: 0.8;
}

  .close-search {
    font-size: 80px;
    margin: 20px auto;
    width: 80px;
    height: 80px;
    -webkit-animation:scaleout 1.5s infinite ease-in-out;
	  animation:scaleout 1.5s infinite ease-in-out;
  }


  @-webkit-keyframes scaleout {
    0% {
         color: rgba(0, 0, 0, 1);

    -webkit-transform: translateY(10px);
    }
    10% {
        color: rgba(0, 0, 0, 0.9);
       -webkit-transform: translateY(12px);
        opacity:1;
      }
    100% {
      -webkit-transform: translateY(30px);
      opacity:0;
      color: rgba(0, 0, 0, 0.9);
    }
}
@keyframes scaleout {
    0% {
    color: rgba(0, 0, 0, 1);
    transform: translateY(10px);
    opacity:0;
  }
  10% {
    color: rgba(0, 0, 0, 0.9);
    transform: translateY(12px);
    opacity:1;
  }
  100% {
    transform: translateY(30px);
    opacity:0;
  }
}



  .show-search-enter-active {
    animation: slide-in .5s;
  }
  .show-search-leave-active {
    animation: slide-in .5s reverse;
  }
  @keyframes slide-in {
    0% {
      opacity: 0;
      transform: translateY(0);
    }
    70% {
      transform: translateY(3px);
    }
    100% {
      opacity: 1;
      transform: translateY(0);
    }
  }



  @media only screen and (max-width: 850px) {
    .search .logo {
      float: none;
      margin: 0 auto;
    }
    .search {
      width: 500px;
    }
  }

  @media only screen and (max-width: 500px) {
    .search .logo {
      float: none;
      margin: 0 auto;
    }
    .search,
    .search .input {
      width: 320px;
    }
    .search .input input[type="text"]{
      width: 250px;
      padding: 2px 15px 5px 15px;
    }

    .search .input input[type="submit"]{
      width: 50px;
      padding: 8px 15px 26px 15px;
    }


.alert-notice {
  width: 200px;
  height: 100px;
}

.notice-msg {
  position: absolute;
  width: 200px;
  height: 50px;
  line-height: 50px;
  font-size: 16px;
}












  }


</style>
