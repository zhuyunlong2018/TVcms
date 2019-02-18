<template>
  <div id="app">
    <components></components>
    <router-view></router-view>
  </div>
</template>

<script>

import components from '@/views/components/components.vue';
import { mapActions,mapMutations } from 'vuex';

export default {
  components: {
    components
  },
  methods: {
    ...mapActions(['get_webdata']),
    ...mapMutations(['get_how_long'])
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
