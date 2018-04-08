<template>
  <div id="app">
    <components></components>
    <router-view></router-view>
  </div>
</template>

<script>

import components from './components/components.vue';
import { mapActions,mapMutations } from 'vuex';

export default {
  components: {
    components
  },
  methods: {
    ...mapActions(['get_webdata','get_tags','get_neighbors']),
    ...mapMutations(['get_now_time','get_how_long'])
  },
  created:function(){
        this.get_webdata();
        this.get_tags();
        this.get_neighbors();
        clearInterval(setInterval);
        setInterval(() => {
       this.get_now_time()
       }, 1000);

  },
  mounted:function() {
    this.get_how_long();
  }
}

</script>


<style>
  @import '~simplemde/dist/simplemde.min.css';


  pre {
    border: none;
    background: none;
  }
</style>


<style scoped>


</style>
