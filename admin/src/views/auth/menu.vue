<template>
  <div class="app-container">

    <el-tag style="margin-bottom:20px;">
      <a >Documentation</a>
    </el-tag>

    <tree-table :data="data" :eval-func="func" :eval-args="args" :expand-all="expandAll" border>
      <el-table-column label="系统菜单">
        <template slot-scope="scope">
          <span style="color:sandybrown">{{ scope.row.title }}</span>
          
        </template>
      </el-table-column>
      <el-table-column label="绑定api">
        <template slot-scope="scope">
          <p v-for="api in scope.row.api" :key="api.api_id" >
            <el-tag>{{ api.api_path}}</el-tag>
            <span style="color:sandybrown">{{ api.api_name }}</span>
          </p>
          
        </template>
      </el-table-column>
      <el-table-column label="操作" width="200">
        <template slot-scope="scope">
          <el-button type="text" v-if='scope.row.father_id != 0' @click="changeApi(scope.row)">更改关联api接口</el-button>
        </template>
      </el-table-column>
    </tree-table>


    <el-dialog :title="dialogTitle" width="70%" :visible.sync="dialogFormVisible">
      <code>菜单栏目名称：{{selectedMenu.title}}</code>
      <dnd-list :list1="selectedMenu.menuApi" :list2="selectedMenu.apiList" :menu_id="selectedMenu.id" list1-title="已关联api" list2-title="未关联api"/>
    </el-dialog>


  </div>
</template>

<script>
/**
  Auth: Lei.j1ang
  Created: 2018/1/19-14:54
*/
import treeTable from '@/components/TreeTable'
import DndList from '@/views/auth/components/DndList'
import treeToArray from './customEval'
import { listMenu } from '@/api/menu'
import { fetchList } from '@/api/api'
export default {
  name: 'CustomTreeTableDemo',
  components: { treeTable, DndList },
  data() {
    return {
      func: treeToArray,
      expandAll: false,
      data:[],
      args: [null, null, 'timeLine'],
      listQuery: {
        page: 1,
        limit: 20,
        name: undefined,
        sort: 'create_time',
        order: 'desc'
      },
      dialogFormVisible: false,
      dialogTitle: '编辑菜单api',
      selectedMenu: {
        id: 0,
        title: '',
        apiList: [],
        menuApi: []
      },
    }
  },
  created() {
    this.getList()
    let query = {
      type: 3
    }
    fetchList(query).then(response => {
      this.selectedMenu.apiList = response.data.data
    })
  },
  methods: {
    getList() {
      this.listLoading = true
      listMenu(this.listQuery)
        .then(response => {
          this.data = response.data.data
          this.listLoading = false
        })
        .catch(() => {
          this.listLoading = false
        })
    },
    changeApi(row) {
      this.selectedMenu.title = row.title
      this.selectedMenu.id = row.menu_id
      this.selectedMenu.menuApi = row.api
      this.dialogFormVisible = true
    }
  }
}
</script>
