<template>
  <div class="editor">
		<div class="table">
			<table cellpadding="0" cellspacing="0">
				<thead>
					<tr>
						<th>ID</th>
						<th>标题</th>
						<th>发文时间</th>
						<th>状态</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="article in list" :key="article.a_id" >
						<td width="5%">{{article.a_id}}</td>
						<td >{{article.a_title}}</td>
						<td width="15%">{{article.create_time}}</td>
						<td  width="10%">
              <label  class="el-switch">
                <input  @click="publish(article.a_id)" type="checkbox" name="switch" :checked="article.published==1?'checked':null " >
                <span class="el-switch-style"></span>
              </label>
			      </td>
						<td width="15%">
              <i class="edit glyphicon glyphicon-edit" @click="getOneArticle(article.a_id)" ></i>
              <i class="delete glyphicon glyphicon-trash" @click="confirmDel(article.a_id)" ></i>
            </td>
					</tr>
				</tbody>
			</table>
      <transition name="show-del">
        <div class="mask" v-if="confirm_del" @click="confirm_del=false" >
          <div class="alert" @click="stopProp" >
            <div class="title">
              确认要删除该文章？
            </div>
            <div class="content">
              <button type="button" class="btn btn-warning" @click="delArticle()" >确认</button>
              <button type="button" class="btn btn-info" @click="confirm_del=false" >取消</button>
            </div>
          </div> 
        </div>
      </transition>
		</div>
  </div>
</template>

<script>
import { getTitleList, changePublish, delArticle } from '@/api/article'

export default {
  data() {
    return {
      confirm_del: false,
      id: null,
      published: null,
      list: []
    }
  },
  methods:{
    getList() {
      getTitleList().then(response => {
          this.list = response.data.data
      })
    },
    confirmDel(id) {
      this.confirm_del = true;
      this.id = id;
    },
    publish(id) {
      const data = { id }
      changePublish(data).then(response => {
        for(const v of this.list) {
          if(v.a_id == id) {
            this.list.published = response.data.data.published
            break;
          }
        }
      })
    },
    stopProp: function(e) {
      e = e || event;
      e.stopPropagation();
    },
    //删除该文章
    delArticle() {
      this.confirm_del = false;
      const data = { id: this.id };
      delArticle(data).then(response => {
        for(const v of this.list) {
          if(v.a_id == this.id) {
            const index = this.list.indexOf(v)
            this.list.splice(index,1)
            break;
          }
        }
      })

    },
    //获取要编辑文章的内容
    getOneArticle(id) {
        this.$router.push({name:'write',params:{id}});
    },
  },
  created:function() {
   this.getList();

  },
  mounted:function() {

  }
}
</script>



<style scoped>

  .editor {
    width: 100%;
  }



	.table table {
		width: 90%;
    margin: 40px auto;
		font-size: 14px;
    background: #fff;
    box-shadow: 0 0 1px 1px  rgba(0, 0, 0, .2);
	}
	
	.table {
		padding: 0 10px;
	}
	
	table thead th {
		background: rgba(200, 200, 200, .1);
		padding: 10px;
		text-align: center;
		border-bottom: 1px solid rgb(240,240,240);
		border-right: 1px solid rgb(240,240,240);
	}
  table tbody tr:hover {
		background: #eee;
    box-shadow: inset 0 0 1px 1px  rgba(0, 0, 0, .2);
	}
	
	table tbody td {
		padding: 10px;
		text-align: center;
		border-bottom: 1px solid rgb(240,240,240);
		border-right: 1px solid rgb(240,240,240);
	}
  table thead th:nth-child(2),
  table tbody td:nth-child(2) {
    text-align: left;
  }

	
	table tbody td i {
    font-size: 20px;
		cursor: pointer;
	}
	
	.delete {
		color: red;
	}
	
	.edit {
    margin-right: 8px;
		color: #008cd5;
	}
	.mask {
	background: rgba(0, 0, 0, .5);
	width: 100%;
	height: 100%;
	position: fixed;
	z-index: 9999;
	top: 0;
	left: 0;
 }

.alert {
	width: 300px;
	height: 150px;
	background: rgba(255, 255, 255, 1);
	position: absolute;
	left: 0;
	top: 0;
	right: 0;
	bottom: 0;
	margin: auto;
	z-index: 47;
	border-radius: 5px;
 }

.title {
  text-align: center;
	padding: 10px;
	border-bottom: 1px solid #eee;
 }


.content {
	padding: 10px;
  text-align: center;
 }

 .content button {
   margin: 20px 30px;
 }


.show-del-enter-active {
  animation: bounce-in .8s;
}
.show-del-leave-active {
  animation: bounce-in .1s reverse;
}
@keyframes bounce-in {
  0% {
    transform: scale(0);
  }
  30% {
    transform: scale(1.1);
  }
  100% {
    transform: scale(1);
  }
}




    @media only screen and (max-width: 768px) {
	table tbody td i {
    display: block;
  }
  table tbody td .edit {
    margin-bottom: 10px;
    margin-right: 0;
  }
  .table {
    padding: 0 5px;
  }
  .table table {
    width: 98%;
    margin: 10px auto;
  }
}



</style>
