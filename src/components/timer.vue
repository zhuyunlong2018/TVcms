<template>
  <div class="main f-l">
    <div class="timer">
      <h2 class="title">边泉博客时间轴</h2>
        <div class="timelineContainer clearfix">
          <div v-for="(year,index) in timer" :key='index' class="timeline-year">
            <p class="timeline-title"><i class="line" ></i><span>{{year.year}}</span></p>
            <dl v-for="(month,_index) in year.month" :key="_index" class="timeline-month">
              <dt>
                <i class="line-month" ></i>
                <a>{{month.month}}</a>
              </dt>
              <dd class="timeline-article">
                <p @click="show_detail(list.id)" v-for="(list,index_) in month.list" :key="index_" > {{list.a_time}} {{list.a_title}}</p>
              </dd>
            </dl>
          </div>
        </div>
    </div>
  </div>
</template>


<script>
import { mapState, mapActions,mapMutations } from 'vuex';

export default {
  data(){
    return {

    }
  },
  methods: {
    ...mapActions(['get_all_article','getShowArticle']),
    show_detail:function(id) {
      this.getShowArticle(id);
      let routeData = this.$router.resolve({name:'article',params:{id:id}});
      window.open(routeData.href,'_blank');
    }
  },
  computed: {
    ...mapState(['timer'])
  },
  created:function(){
    this.get_all_article();
  }
}
</script>


<style>
  .main .timer {
    width: 100%;
    margin: 15px 0;
    padding: 15px 0;
    background: #fff;
    border-radius: 10px;
    box-shadow: 3px 3px 8px 2px #ccc;
  }

  

  .main .timer .title {
    color: rgba(33,33,33,0.8);
    cursor: pointer;
    height: 50px;
    margin: 0px 20px;
    text-shadow: 3px 3px 2px #ccc;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .main .timer .title:hover {
    color: #000;
  }

.timelineContainer {
  width: 90%;
	border-left:2px solid rgb(85, 85, 85);
	margin:20px auto;
}


div.timeline-year {
	float:left;
	margin:0 0 12px;
	width:100%;
}

.timeline-title {
		font-family:Palatino,"Times New Roman", Times, serif;
    cursor: pointer;
    font-size: 35px;
		font-weight:500;
    height: 50px;
    line-height: 50px;
  }
  .timeline-year .timeline-title .line {
    display: inline-block;
    width: 30px;
    height: 2px;
    margin-bottom: 10px;
    background: #333;
  }

	.timeline-year .timeline-title span {
		background:#ccc;
		-webkit-border-radius:4px;
		-moz-border-radius:4px;
		border-radius:4px;
		color:#131313;
		letter-spacing:5px;
		padding:3px 5px 1px;
	}

dl.timeline-month {
	float:left;
	margin:0 12px 0 0;
	padding:4px 4px 4px 0;
	position:relative;
  width:100%;
   border-bottom: 1px solid #aaa;
}
.line-month {
  display: inline-block;
  width: 15px;
  height: 2px;
  background: #333;
  margin-bottom: 10px;
}
	.timeline-month dt {
		font-size:25px;
		list-style-type:none;
		line-height:1.2em;
		margin:0 0 12px;
		white-space:nowrap;
	}

		.timeline-month dt a {
      padding-left: 10px;
			color:#999;
      cursor:pointer;
      text-decoration: none;
     
		}
    .timeline-article p:hover,
		.timeline-month dt a:hover {
			color:#7DBADF;
		}

	.timeline-month dd {
		padding-left:40px;
    
	}

.timeline-article p {
  margin: 5px 0;
  cursor: pointer;
}





</style>
