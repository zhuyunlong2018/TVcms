<template>
  <div class="app-container">

    <!-- 查询和其他操作 -->
    <div class="filter-container">
      <el-input v-model="listQuery.username" clearable class="filter-item" style="width: 200px;" placeholder="请输入用户名"/>
      <el-input v-model="listQuery.mobile" clearable class="filter-item" style="width: 200px;" placeholder="请输入手机号"/>
      <el-button class="filter-item" type="primary" icon="el-icon-search" @click="handleFilter">查找</el-button>
      <el-button :loading="downloadLoading" class="filter-item" type="primary" icon="el-icon-download" @click="handleDownload">导出</el-button>
    </div>

    <!-- 查询结果 -->
    <el-table v-loading="listLoading" :data="list" size="small" element-loading-text="正在查询中。。。" border fit highlight-current-row>
      <el-table-column align="center" width="100px" label="用户ID" prop="user_id" sortable/>

      <el-table-column align="center" label="用户名" prop="user_name"/>
      <el-table-column align="center" label="用户头像" prop="user_avatar">
        <template slot-scope="scope">
          <img v-if="scope.row.user_avatar" :src="scope.row.user_avatar" width="40">
        </template>
      </el-table-column>
      <el-table-column align="center" label="邮箱" prop="user_email"/>

      <el-table-column align="center" label="性别" prop="gender">
        <template slot-scope="scope">
          <el-tag >{{ genderDic[scope.row.gender] }}</el-tag>
        </template>
      </el-table-column>

      <el-table-column align="center" label="状态" prop="user_status">
        <template slot-scope="scope">
          <el-tag>{{ statusDic[scope.row.user_status] }}</el-tag>
        </template>
      </el-table-column>

      <el-table-column align="center" label="操作" width="200" class-name="small-padding fixed-width">
        <template slot-scope="scope">
          <el-button :type="typeDic[scope.row.user_status]" size="mini" @click="updateData(scope.row)">{{ updateDic[scope.row.user_status] }}</el-button>
        </template>
      </el-table-column>
    </el-table>

    <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" />
  </div>
</template>

<script>
import { fetchList, changeStatus } from '@/api/user'
import Pagination from '@/components/Pagination' // Secondary package based on el-pagination

export default {
  name: 'User',
  components: { Pagination },
  data() {
    return {
      list: null,
      total: 0,
      listLoading: true,
      listQuery: {
        page: 1,
        limit: 20,
        username: undefined,
        mobile: undefined,
        sort: 'add_time',
        order: 'desc'
      },
      downloadLoading: false,
      updateDic: ['审核', '封禁', '解封'],
      typeDic: ['success', 'warning', 'danger'],
      genderDic: ['未知', '男', '女'],
      statusDic: ['审核中', '正常', '封禁']
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
      let user = { id: row.user_id }
      switch(parseInt(row.user_status)) {
        case 0:
          user.status = 1
          break;
        case 1:
          user.status = 2
          break;
        case 2:
          user.status = 1
          break;
      }
      changeStatus(user).then(() => {
        row.user_status = user.status
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
        const tHeader = ['用户名', '邮箱', '性别', '状态']
        const filterVal = ['user_name', 'user_email', 'gender', 'user_status']
        excel.export_json_to_excel2(tHeader, this.list, filterVal, '用户信息')
        this.downloadLoading = false
      })
    }
  }
}
</script>
