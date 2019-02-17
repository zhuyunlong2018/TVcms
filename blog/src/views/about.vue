<template>
  <div class="main f-l">
    <div class="about">
      <div class="content" v-html="about"  >
      </div>
    </div>
  </div>
</template>


<script>
import { get } from '@/api/about'
import simplemde from 'simplemde'
export default {
  data() {
    return {
      about: ''
    }
  },
  methods: {
    get() {
      get(1).then(response => {
        this.about = simplemde.prototype.markdown(response.data.data.about_content);
      })
    }
  },
  created(){
    this.get()
  },
  computed: {
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
