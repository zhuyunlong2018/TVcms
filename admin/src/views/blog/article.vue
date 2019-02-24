<template>
  <div class="app-container">

    <!-- 查询和其他操作 -->
    <div class="filter-container">
      <el-input v-model="listQuery.title" clearable class="filter-item" style="width: 200px;" placeholder="请输入文章名"/>
      <el-input v-model="listQuery.author" clearable class="filter-item" style="width: 200px;" placeholder="请输入作者名"/>
      <el-input v-model="listQuery.tag" clearable class="filter-item" style="width: 200px;" placeholder="请输入标签名"/>
      <el-button class="filter-item" type="primary" icon="el-icon-search" @click="handleFilter">查找</el-button>
      <el-button :loading="downloadLoading" class="filter-item" type="primary" icon="el-icon-download" @click="handleDownload">导出</el-button>
    </div>

    <!-- 查询结果 -->
    <el-table v-loading="listLoading" :data="list" size="small" element-loading-text="正在查询中。。。" border fit highlight-current-row>
      <el-table-column align="center" width="100px" label="文章ID" prop="a_id" sortable/>

      <el-table-column align="center" label="标题" prop="a_title"/>

      <el-table-column align="center" label="作者" prop="user_name"/>


      <el-table-column align="center" label="标签" prop="tag_name"/>

      <el-table-column align="center" label="发布日期" prop="create_time"/>

      <el-table-column align="center" label="状态" prop="status">
        <template slot-scope="scope">
          <el-tag>{{ statusDic[scope.row.status] }}</el-tag>
        </template>
      </el-table-column>

      <el-table-column align="center" label="操作" width="200" class-name="small-padding fixed-width">
        <template slot-scope="scope">
          <el-button :type="typeDic[scope.row.status]" size="mini" @click="updateData(scope.row)">{{ updateDic[scope.row.status] }}</el-button>
        </template>
      </el-table-column>
    </el-table>

    <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" />
  </div>
</template>

<script>
import { fetchList, changeStatus } from '@/api/article'
import Pagination from '@/components/Pagination' // Secondary package based on el-pagination

export default {
  name: 'Article',
  components: { Pagination },
  data() {
    return {
      list: null,
      total: 0,
      listLoading: true,
      listQuery: {
        page: 1,
        limit: 20,
        title: '',
        author: '',
        tag: '',
        sort: 'create_time',
        order: 'desc'
      },
      downloadLoading: false,
      updateDic: ['审核', '封禁', '解封'],
      typeDic: ['success', 'warning', 'danger'],
      statusDic: ['审核中', '已审核', '封禁']
    }
  },
  created() {
    this.getList()
  },
  methods: {
    getList() {
      this.listLoading = true
      fetchList(this.listQuery).then(response => {
        this.list = response.data.data.data
        this.total = response.data.data.total
        this.listLoading = false
      }).catch(() => {
        this.list = []
        this.total = 0
        this.listLoading = false
      })
    },
    handleFilter() {
      this.listQuery.page = 1
      this.getList()
    },
    updateData(row) {
      let article = { id: row.a_id }
      switch(parseInt(row.status)) {
        case 0:
          article.status = 1
          break;
        case 1:
          article.status = 2
          break;
        case 2:
          article.status = 1
          break;
      }
      changeStatus(article).then(() => {
        row.status = article.status
        this.$notify.success({
          title: '成功',
          message: '更新成功'
        })
      }).catch(response => {
        this.$notify.error({
          title: '失败',
          message: response.data.msg
        })
      })
    },
    handleDownload() {
      this.downloadLoading = true
      import('@/vendor/Export2Excel').then(excel => {
        const tHeader = ['文章标题', '作者', '标签', '发布日期', '状态']
        const filterVal = ['a_title', 'user_name', 'tag_name', 'create_time', 'status']
        excel.export_json_to_excel2(tHeader, this.list, filterVal, '博客文章')
        this.downloadLoading = false
      })
    }
  }
}
</script>
