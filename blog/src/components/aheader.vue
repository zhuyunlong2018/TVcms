<template>
  <div class="header">
    <div class="nav">
      <h2>欢迎使用边泉博客管理系统</h2>
      <ul>
        <li><router-link to="/admin/outline">概要</router-link></li>
        <li><router-link to="/admin/write">发布文章</router-link></li>
        <li><router-link to="/admin/editor">文章管理</router-link></li>
        <li><router-link to="/articleList">网站</router-link></li>
      </ul>
    </div>

  </div>
</template>


<style scoped>
  /* .header {
    width: 100%;
    height: 70px;
    background-color: rgba(33,33,33,0.8);
    color: #fff;

    position: absolute;
    top: 0;
    right: 0;
    left: 0;
  } */
  /* .header .nav {
    width: 80%;
    margin: 0 auto;
  }
  .header .nav ul {
    margin-top: 4px;
  } */
  /* .header .nav ul li {
    display: inline-block;
  }

  .header .nav ul li a {
    display: block;
    padding: 10px 15px 10px 15px;
    border-left: 2px solid #aaa;
    color: #ccc;
  }

  .header .nav ul li a:hover {
    color: #fff;
    background-color: #444;
  } */

</style>
