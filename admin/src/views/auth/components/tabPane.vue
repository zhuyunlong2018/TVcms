<template>
  <el-table :data="list" border fit highlight-current-row style="width: 100%">

    <el-table-column
      v-loading="loading"
      align="center"
      label="ID"
      width="65"
      element-loading-text="请给我点时间！">
      <template slot-scope="scope">
        <span>{{ scope.row.api_id }}</span>
      </template>
    </el-table-column>

    <el-table-column width="200px" align="center" label="api地址">
      <template slot-scope="scope">
        <span>{{ scope.row.api_path }}</span>
      </template>
    </el-table-column>

    <el-table-column min-width="200px" label="api描述">
      <template slot-scope="scope">
        <span>{{ scope.row.api_name }}</span>
      </template>
    </el-table-column>
  
    <el-table-column width="180px" align="center" label="创建日期">
      <template slot-scope="scope">
        <span>{{ scope.row.create_time | parseTime('{y}-{m}-{d} {h}:{i}') }}</span>
      </template>
    </el-table-column>
    <el-table-column width="180px" align="center" label="修改类型">
      <template slot-scope="scope">
        <el-select v-model="value[scope.row.api_id]" placeholder="修改分组"  @change="changeType(scope.row)">
          <el-option
            v-for="item in options"
            :key="item.value"
            :label="item.label"
            :value="item.value">
          </el-option>
        </el-select>
      </template>
    </el-table-column>
  </el-table>
</template>

<script>
import { fetchList, changeType } from '@/api/api'

export default {
  filters: {
    statusFilter(status) {
      const statusMap = {
        published: 'success',
        draft: 'info',
        deleted: 'danger'
      }
      return statusMap[status]
    }
  },
  props: {
    type: {
      type: String,
      default: '3'
    },
    changed: Array
  },
  data() {
    return {
      list: null,
      listQuery: {
        type: this.type
      },
      loading: false,
      options: [{
        value: '0',
        label: '未注册'
      }, {
        value: '1',
        label: 'token白名单'
      }, {
        value: '2',
        label: 'auth白名单'
      }, {
        value: '3',
        label: '权限收录'
      }],
      value: []
    }
  },
  created() {
    this.options.splice(this.type,1)
    this.getList()
  },
  activated() {
    if(this.changed[this.type]) {
      this.getList()
    }
  },
  methods: {
    getList() {
      this.loading = true
      this.$emit('create') // for test
      fetchList(this.listQuery).then(response => {
        this.list = response.data.data
        this.$emit('changeApiType',this.type,false)
        this.loading = false
      })
    },
    changeType(ele) {
      let targetType = this.value[ele.api_id]
      let nowType = this.type
      if(targetType == nowType) {
        return
      }
      let data = {
        id: ele.api_id,
        type: targetType
      }
      changeType(data).then(response => {
        let index = this.list.indexOf(ele)
        this.list.splice(index,1)
        this.$emit('changeApiType',this.type,true)
      })

    }
  }
}
</script>

