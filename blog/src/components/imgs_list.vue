<template>
  <div class="member">
    <div class="row">
      <div class="col-xs-6 col-sm-4 col-md-3" v-for="(img,index) in all_images.src" :key="index" >
        <div class="thumbnail">
          <i @click="_del_img(index)" class="glyphicon glyphicon-remove-circle" ></i>
          <img :src="img.i_src" alt="">
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
    ...mapActions(["get_all_imgs","del_img"]),
    _del_img(index) {
      this.del_img(index);
    }
  },
  computed:{
    ...mapState(["all_images"])
  },
  created:function() {
   this.get_all_imgs();

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
    overflow: hidden;
     box-shadow: 0 0 1px 1px   rgba(0, 0, 0, .1);
  }
  .thumbnail i {
    z-index: 50;
    position: absolute;
    right: 30px;
    top: 15px;
    font-size: 20px;
    cursor: pointer;
    color: #666;
    transition: all .3s;
  }
  .thumbnail i:hover {
    font-size: 26px;
    right: 27px;
    top: 12px;
    color: #4fd;
  }

    .thumbnail img {
    width: 100%;
    height: 100%;
    transition: all  0.3s linear;
    -webkit-transition: all  0.3s linear;
  }

  .thumbnail img:hover {
    transform: scale(1.05);
    -webkit-transform: scale(1.1);
  }

  @media only screen and (max-width: 768px) {
     .member .row {
    padding: 10px;
  }
  .thumbnail {
    margin-bottom: 0;
  }

  .col-xs-6 {
    padding:  10px;
  }




  }
 

 


</style>
