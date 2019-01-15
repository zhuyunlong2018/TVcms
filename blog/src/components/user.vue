<template>
  <div class="user-center">
    <div class="background"></div>
    <div class="icon"><img src="../../static/imgs/1.jpg" alt=""></div>
    <div class="content">
      <p class="name"  >
      <span>{{commenter}}</span>
      </p>
      <p > <i class="glyphicon glyphicon-envelope" ></i>
      <span>{{commenterEmail}}</span>
      </p>
      <p class="message" > <i class="glyphicon glyphicon-bell" ></i>
      <span>暂无消息</span>
      </p>
    </div>
  </div>
</template>

<script>
  import { mapState } from 'vuex';
  export default {
      computed: {
        ...mapState(["commenter","commenterEmail"])
      }
  }
</script>

<style scoped>
  .user-center {
    width: 100%;
    height: 100%;
    position: fixed;
    overflow: hidden;
  }
  .background {
    width: 100%;
    height: 100%;
    -moz-filter: blur(15px);
    -webkit-filter: blur(15px);
    -o-filter: blur(15px);
    -ms-filter: blur(15px);
    filter: blur(15px);
    background: url(../../static/imgs/1.jpg) no-repeat fixed ;
    background-size: cover;
  }
  .icon {
    position: absolute;
    width: 150px;
    height: 150px;
    border-radius: 50%;
    cursor: pointer;
    overflow: hidden;
    top: 80px;
    left: 0;
    right: 230px;
    margin: auto;
    border: 5px solid #fff;
  }
  .icon img {
    width: 200px;
  }

  .content {
    color: #eee;
    position: absolute;
    width: 60%;
    left: 0;
    right: 230px;
    margin: auto;
    top: 250px;
    text-align: center;
  }
  .content p {
    font-size: 20px;
    line-height: 20px;
    margin-top: 10px;
  }
  .content p.name {
    font-size: 35px;
    line-height: 35px;
  }

   @media only screen and (max-width: 1024px) {
    .icon,
    .content {
      right: 130px;
    }

}

  @media only screen and (max-width: 500px) {
  .icon,
  .content {
    right: 0;
  }
  .content {
    width: 90%;
  }


  }





</style>
