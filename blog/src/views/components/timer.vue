<template>
  <div class="main f-l">
    <div class="timer">
      <h2 class="title">边泉博客时间轴</h2>
      <div class="timelineContainer clearfix">
        <div v-for="(year,index) in timer" :key="index" class="timeline-year">
          <p class="timeline-title">
            <i class="line"></i>
            <span>{{year.year}}</span>
          </p>
          <dl v-for="(month,_index) in year.month" :key="_index" class="timeline-month">
            <dt>
              <i class="line-month"></i>
              <a>{{month.month}}</a>
            </dt>
            <dd class="timeline-article">
              <p
                @click="showDetail(list.a_id)"
                v-for="(list,index_) in month.list"
                :key="index_"
              >{{list.create_time}} {{list.a_title}}</p>
            </dd>
          </dl>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { getAll } from '@/api/article'

export default {
  data() {
    return {
      timer: null
    }
  },
  methods: {
    showDetail: function(id) {
      const routeData = this.$router.resolve({
        path: 'articleList/article/' + id
      })
      window.open(routeData.href, '_blank')
    },
    getAll() {
      getAll().then(response => {
        const data = response.data.data
        const timer = [] // 用于存储整个时间轴数组[{year:2018,month:[{month:2018-1,list:[]}]}]
        for (let i = 0; i < data.length; i++) {
          const year = data[i].create_time.substr(0, 4)
          const month = data[i].create_time.substr(0, 7)
          const obj = {} // 用于存储年份的对象{year:2018,month:[]}
          obj.year = year
          obj.month = []
          const _obj = {} // 用于存储月份的对象{month:2018-01,list:[]}
          _obj.month = month
          _obj.list = []
          _obj.list.push(data[i])
          obj.month.push(_obj)
          if (timer.length > 0) {
            // 判断时间轴数组是否为空
            let check = false
            for (let j = 0; j < timer.length; j++) {
              if (year === timer[j].year) {
                // 判断本次循环年份是否存在于时间轴数组里
                check = true
                const _month = timer[j].month
                if (_month.length > 0) {
                  // 判断年月份数组是否为空
                  let _check = false
                  for (let k = 0; k < _month.length; k++) {
                    if (month === _month[k].month) {
                      // 判断本次循环月份是否存在于数组中
                      _check = true
                      _month[k].list.push(data[i]) // 将本记录插入月份数组列表中
                    }
                  }
                  if (!_check) {
                    // 本次数据不属于当前数组存在的月份
                    _month.push(_obj)
                  }
                } else {
                  _month.push(_obj)
                }
              }
            }
            if (!check) {
              // 本次数据不属于当前数组存在的年份
              timer.push(obj)
            }
          } else {
            timer.push(obj)
          }
        }
        this.timer = timer
      })
    }
  },
  created: function() {
    this.getAll()
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
  color: rgba(33, 33, 33, 0.8);
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
  border-left: 2px solid rgb(85, 85, 85);
  margin: 20px auto;
}

div.timeline-year {
  float: left;
  margin: 0 0 12px;
  width: 100%;
}

.timeline-title {
  font-family: Palatino, "Times New Roman", Times, serif;
  cursor: pointer;
  font-size: 35px;
  font-weight: 500;
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
  background: #ccc;
  -webkit-border-radius: 4px;
  -moz-border-radius: 4px;
  border-radius: 4px;
  color: #131313;
  letter-spacing: 5px;
  padding: 3px 5px 1px;
}

dl.timeline-month {
  float: left;
  margin: 0 12px 0 0;
  padding: 4px 4px 4px 0;
  position: relative;
  width: 100%;
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
  font-size: 25px;
  list-style-type: none;
  line-height: 1.2em;
  margin: 0 0 12px;
  white-space: nowrap;
}

.timeline-month dt a {
  padding-left: 10px;
  color: #999;
  cursor: pointer;
  text-decoration: none;
}
.timeline-article p:hover,
.timeline-month dt a:hover {
  color: #7dbadf;
}

.timeline-month dd {
  padding-left: 40px;
}

.timeline-article p {
  margin: 5px 0;
  cursor: pointer;
}
</style>
