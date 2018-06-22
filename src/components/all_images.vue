<template>
  <div class="all-images-box">
    <transition name="show-all-images">
      <div class="mask" v-show="all_images.box" @click="close_all_imgs" >
        <div class="all-images"  >
              <div v-for="(img,index) in all_images.src"  :key="index" class="imgContainer">
                <img :src="img.i_src" alt="">
                <p v-show="all_images.write" class="set-background" @click="_set_background(index)" >设为封面</p>
                <p v-show="all_images.write" @click="_add_img_article(index)" >加入正文</p>
                <p v-show="!all_images.write" @click="_add_lab_imgs(index)" >加入项目</p>
              </div> 
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
import { mapState,mapMutations } from 'vuex';
export default {
    data() {
        return {}
    },
    methods: {
        ...mapMutations(['close_all_imgs','add_img_article','set_background','add_lab_imgs']),
        stopProp: function(e) {
        e = e || event;
        e.stopPropagation();
        },
        _add_img_article:function(index) {
          let url = this.all_images.src[index].i_src;
          this.add_img_article(url);
        },
        _set_background:function(index) {
          let url = this.all_images.src[index].i_src;
          this.set_background(url);
        },
        _add_lab_imgs:function(index) {
          let url = this.all_images.src[index].i_src;
          if(this.lab_imgs.length>0) {
            for(let i=0;i<this.lab_imgs.length;i++) {
              if(url == this.lab_imgs[i]) {
                return;
              }
            }
          }
          this.add_lab_imgs(url);
        }
    },
  computed: {
      ...mapState(['all_images','lab_imgs'])
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
    z-index: 9;
    background: rgba(30,30,30,0.9);
  }

.all-images-box {
	position: absolute;
	z-index: 999;
}

.all-images {
	width: 80%;
	height: 80%;
	background: rgba(255, 255, 255, 1);
	position: absolute;
	left: 0;
	top: 0;
	right: 0;
	bottom: 0;
	margin: auto;
  overflow: scroll;
  text-align: center;
	border-radius: 20px;
    -ms-overflow-style:none;
    /* overflow:-moz-scrollbars-none; */
 }
 ::-webkit-scrollbar{width:0px}


.imgContainer { 
    border: 1px solid rgba(0,0,0,0.3); 
    display: inline-block; 
    width: 150px; 
    height: 150px; 
    margin-left: 1%; 
    border-radius: 10px;
    overflow: hidden;
    position: relative; 
    margin-top: 20px; 
    box-sizing: border-box; 
} 


.imgContainer img{ 
    width: 100%; 
    height: 100%; 
    cursor: pointer; 
} 
.imgContainer p{ 
    position: absolute; 
    bottom: -1px; 
    left: 0; 
    width: 100%; 
    height: 30px; 
    background: rgba(0,0,0,0.5); 
    text-align: center; 
    line-height: 30px; 
    color: white; 
    font-size: 16px; 
    font-weight: bold; 
    cursor: pointer; 
    display: none; 
} 

.imgContainer p.set-background { 
    position: absolute; 
    top: -1px; 
    left: 0; 
    width: 100%; 
    height: 30px; 
    background: rgba(0,0,0,0.5); 
    text-align: center; 
    line-height: 30px; 
    color: white; 
    font-size: 16px; 
    font-weight: bold; 
    cursor: pointer; 
    display: none; 
} 
.imgContainer:hover p{ 
    display: block; 
} 
 .show-all-images-enter-active {
  animation: bounce-in .8s;
}
.show-all-images-leave-active {
  animation: bounce-in .8s reverse;
}
@keyframes bounce-in {
  0% {
    transform: scale(0);
  }
  50% {
    transform: scale(1.1);
  }
  100% {
    transform: scale(1);
  }
}

</style>
