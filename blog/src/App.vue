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
    ...mapMutations(['GET_HOW_LONG'])
  },
  mounted:function() {
    this.GET_HOW_LONG();
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
