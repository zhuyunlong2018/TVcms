<template>
  <div class="main f-l">
    <div class="project">
		<div class="project-container clearfix">
			<a class="enter-detail" :href="show_production.src" target="view_window" >进入详情</a>
			<div class="main-title">
				<h2>实验室</h2>
					<ul>
						<li v-if="item.pr_published==1?true:false" @click="_change_production(index)" v-for="(item,index) in production" :key="index" ><a :class="{'selected':show_item==index}" >{{item.pr_name}}</a></li>
					</ul>
			</div>
			<div class="project-container-main">
					<transition-group name="change-page">
							<div v-show="show_page == _index" v-for="(text,_index) in show_production.content" :key="_index" class="project-container-text">
								<h2>
									<span>{{show_production.name}}</span>
									<span class="project-container_span1">{{_index+1}}</span>
									<span>/</span>
									<span>{{show_production.content.length}}</span>
								</h2>
								<p v-html="text" ></p>
							</div>>
							<div v-show="show_page == index_" v-for="(img,index_) in show_production.imgs" :key="img" class="project-container-img">
								<img :src="img">
							</div>
					</transition-group>
			</div>
		</div>
		<ul class="project-container-bottom" >
      <li @click="change_page('minus')" ><i class="glyphicon glyphicon-circle-arrow-left" ></i></li>
      <li @click="change_page('add')" ><i class="glyphicon glyphicon-circle-arrow-right" ></i></li>
    </ul>


    </div>
  </div>
</template>



<script>
import { mapState,mapActions,mapMutations } from 'vuex';
export default {
	data() {
		return {
			show_page: 0,
			show_item: 0,
			change: null
		}
	},
	methods: {
		...mapActions(['get_production']),
		...mapMutations(['change_production']),
		change_page:function(change) {
			clearInterval(this.change);
			if(change == 'add') {
					if(this.show_page >= this.show_production.content.length-1) {
					this.show_page = this.show_production.content.length-1;
					return;
				} else {
					this.show_page++;
				}
			}
				if(change == 'minus') {
					if(this.show_page <= 0) {
					this.show_page = 0;
					return;
				} else {
					this.show_page--;
				}
				
			}	
			setTimeout(() => {
				this.turn_page();
			}, 3000);
		},
		_change_production(index) {
			clearInterval(this.change);
			this.show_page = 0;
			this.show_item = index;
			this.change_production(index);
			setTimeout(() => {
				this.turn_page();
			}, 3000);
		},
		turn_page:function() {
			clearInterval(this.change);
			this.change=setInterval(() => {
				if(this.show_page >= this.show_production.content.length-1) {
					this.show_page = 0;
				} else {
					this.show_page++;
				}            
      }, 3000)
		}
	},
	computed: {
		...mapState(['production','show_production'])
	},
	mounted() {
		this.turn_page();
	},
	created() {
		clearInterval(this.change);
		this.get_production();
	}
}
</script>

<style>
  .main .project {
    width: 100%;
    margin: 15px 0;
    background: #fff;
		overflow: hidden;
    border-radius: 10px;
    box-shadow: 3px 3px 8px 2px #ccc;
  }


.displayblock {
	display: block !important;
}


.project-container {
	width: 100%;
	border: 1px solid #dddddd;
	border-bottom: none;
  overflow: hidden;
	position: relative;
	z-index: 3;
}

.enter-detail {
	position: absolute;
	top: 60px;
	right: 20px;
	color: #ff0000;
	font-weight: 600;
	font-size: 20px;
	text-decoration: none;
}
.enter-detail:hover,
.enter-detail:active,
.enter-detail:visited {
		text-decoration: none;
}
.main-title {
	width: 100px;
	height: 100%;
	float: left;
	overflow: hidden;
	position: relative;
	z-index: 3;
}
.selected {
	color: rgb(245, 4, 4);
}

.main-title h2 {
	height: 55px;
	line-height: 55px;
	width: 100%;
	font-family: "微软雅黑";
	color: white;
	font-size: 24px;
	background: #999;
	text-align: center;
	position: absolute;
	left: 0;
	top: 0;
	z-index: 6;
}

.main-title ul {
	width: 100%;
	height: 100%;
	padding-top: 60px;
	position: relative;
	background: white;
	z-index: 5;
}

.main-title ul li {
	width: 100%;
	text-align: center;
	height: 55px;
	line-height: 55px;
}

.main-title ul li a {
	cursor: pointer;
	text-align: left;
  text-decoration: none;
}

.main-title ul li a:hover {
	color: rgb(0, 160, 253);
}

.project-container-main {
	width: 85%;
	height: 100%;
	float: left;
  border-left: 1px solid #999;
}

.project-container-text {
	width: 23%;
  margin-left: 10px;
	float: left;
}

.project-container-text h2 {
	width: 300%;
	margin-top: 45px;
	height: 55px;
	line-height: 55px;
	color: #3c3c3c;
	font-family: "微软雅黑";
	font-size: 18px;
	border-bottom: 1px solid #ededed;
}

.project-container-text h2 span {
	font-size: 30px;
	color: #A8A8A8;
	display: inline-block;
	float: left;
}

.project-container-text h2 span:first-child {
	display: inline-block;
	color: #3c3c3c;
	font-family: "微软雅黑";
	font-size: 18px;
	max-width: 250px;
	overflow: hidden;
	text-overflow: ellipsis;
	word-break: normal;
	white-space: nowrap;
}

.project-container_span1 {
	color: #56b7a4 !important;
	margin-left: 6px;
}

.project-container-img {
	width: 75%;
	height: 100%;
	float: left;
	overflow: hidden;
}

.project-container-img img {
	width: 100%;
	margin-top: 99px;
  padding-top: 10px;
  border-top: 1px solid #ededed;
  margin-bottom: 20px;
}

.project-container-bottom {
	width: 100%;
  font-size: 25px;
	margin-top: 10px;
	text-align: center;
	border-top: 1px solid #dddddd;
}
.project-container-bottom li {
  display: inline-block;
  cursor: pointer;
  width: 25px;
  height: 25px;
  line-height: 25px;
	margin: 20px;
}

      .change-page-enter-active {
        transition: all .8s ease;
      }
      .change-page-enter {
        transform: translateX(100px);
        opacity: 0;
      }

		 .change-page-leave  {
				opacity: 0;
				display: none;
			}





@media only screen and (max-width: 1366px) {
  .project-container-text {
    width: 100%;
  }
  .project-container-img {
    width: 100%;
    margin-left: 10px;
  }
  .project-container-img img {
    margin-top: 10px;
    border: none;
    padding: 0;
  }
  
}

@media only screen and (max-width: 1024px) {
	.project-container-main {
		width: 96%;
	}
	.main-title {
		width: 100%;
		height: 55px;
	}
	.main-title ul {
		padding-top: 0;
		padding-left: 100px;
		border-bottom: 1px solid #ccc;
	}
	.main-title ul li {
		float: left;
		width: 90px;
		height: 55px;
	}
	.main-title h2 {
		width: 90px;
	}
	.project-container-text h2 {
		margin-top: 10px;
	}
	.project-container-main {
		border: none;
	}
	.enter-detail {
		top: 80px;
	}

}


</style>
