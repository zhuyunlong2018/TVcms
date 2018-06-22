<template>
  <div class="main f-l">
    <div class="about">
      <div class="content" v-html="about_html" v-highlight >
      </div>
    </div>
  </div>
</template>


<script>
import { mapState,mapActions } from 'vuex';
export default {
  methods: {
    ...mapActions(['get_about'])
  },
  created(){
    if(!this.about_html) {
    this.get_about();
    }
  },
  computed: {
    ...mapState(['about_html'])
  }
}
</script>


<style scoped>
  .main .content {
    padding: 10px 20px;
  }
  .main .about {
    width: 100%;
    margin: 15px 0;
    padding: 15px 0;
    background: #fff;
    border-radius: 10px;
    box-shadow: 3px 3px 8px 2px #ccc;
  }
  .main .about img {
    max-width: 100%;
  }


</style>
