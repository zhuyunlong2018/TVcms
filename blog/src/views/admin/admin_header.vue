<template>
  <div class="admin-header" click="stopProp" >
    <p class="user" @click="SHOW_LOGOUT_BOX" >
      <i class="glyphicon glyphicon-user"></i>
      <span>{{ user.user_name }}</span>
      <i class="glyphicon glyphicon-menu-down"></i>
    </p>
  </div>
</template>

<script>
import { mapState,mapMutations,mapGetters } from 'vuex';

  export default {
    data() {
      return {
      };
    },
    methods: {
      ...mapMutations(['SHOW_LOGOUT_BOX']),
      stopProp: function(e) {
        console.log("header");
            e = e || event;
            e.stopPropagation();
      }
    },
    computed: {
      ...mapGetters(['user'])
    }
  }
</script>


<style scoped>
.admin-header {
  position: absolute;
	top: 0;
	left: 230px;
  right: 0;
	height: 38px;
  line-height: 38px;
  padding: 0 20px;
	width:auto;
  text-align: right;
	z-index: 810;
	background-color: #ffffff;
}

.admin-header .user {
  cursor:pointer; 
}

 @media only screen and (max-width: 1024px) {
     .admin-header {
         left: 130px;
     }
 }

 @media only screen and (max-width: 500px) {
      .admin-header {
         left: 0px;
     }
 }

</style>
