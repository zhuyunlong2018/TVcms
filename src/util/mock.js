/**
 * Created by HAGM on 2018/2/9.
 */
import Mock from 'mockjs';

const data = Mock.mock('/api',{
  'article|3-10': [{
    'title': "江小白完结啦",
    "summary": "这是测试摘要，内容随意，江小白完结啦！江小白完结啦！江小白完结啦！江小白完结啦！江小白完结啦！江小白完结啦！江小白完结啦！江小白完结啦！江小白完结啦！江小白完结啦！江小白完结啦！江小白完结啦！这是测试摘要，内容随意，江小白完结啦！江小白完结啦！江小白完结啦！江小白完结啦！江小白完结啦！江小白完结啦！江小白完结啦！江小白完结啦！江小白完结啦！江小白完结啦！江小白完结啦！江小白完结啦！",
    "author": "边泉",
    "img": "../../static/imgs/jiangxiaobai.jpg",
    "time": "@time",
    "view": 1,
    "comment": 2
  }],
  "sales|1-5": [{
    // 属性 id 是一个自增数，起始值为 1，每次增 1
    'name': "@ctitle(2,10)",
    "img": "@image('600x600',#b7ef7c)",
    "brief": "@csentence(1,50)",
    "price|0-100.0-2": 1,
    "num": 0,
    "minusFlag": true,
    "time": "@time",
    "peisongfei|0-100.0-2": 1,
    "limit|0-100": 1
  }]
})

export default {
  data
}
