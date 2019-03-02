<template>
  <div class="app-container">

     <!-- 查询和其他操作 -->
    <div class="filter-container">
      <el-button class="filter-item" type="primary" icon="el-icon-edit" @click="handleCreate">添加</el-button>
    </div>
    <tree-table :data="data" :eval-func="func" :eval-args="args" :expand-all="expandAll" border>
      <el-table-column label="系统菜单">
        <template slot-scope="scope">
          <span style="color:sandybrown">{{ scope.row.title }}</span>
        </template>
      </el-table-column>
      <el-table-column label="路由">
        <template slot-scope="scope">
          <span style="color:sandybrown">{{ scope.row.path }}</span>
        </template>
      </el-table-column>
      <el-table-column label="关联组件">
        <template slot-scope="scope">
          <span style="color:sandybrown">{{ scope.row.component }}</span>
        </template>
      </el-table-column>
      <el-table-column label="操作" width="200">
        <template slot-scope="scope">
          <el-button type="text" @click="handleUpdate(scope.row)">编辑</el-button>
        </template>
      </el-table-column>
    </tree-table>
    <el-dialog :title="dialogTitle" width="1000px" :visible.sync="dialogFormVisible">
      
      <el-form ref="dataForm" :rules="rules" :model="dataForm" status-icon label-position="left" label-width="100px" style="width: 400px; float: left; margin-left:50px;">
        <el-form-item label="菜单栏标题" prop="title">
          <el-input v-model="dataForm.title"/>
        </el-form-item>
        <el-form-item label="组件名称" prop="name">
          <el-input v-model="dataForm.name"/>
        </el-form-item>
        <el-form-item label="图标" prop="icon">
          <el-input v-model="dataForm.icon"/>
        </el-form-item>
        <el-form-item label="关联父菜单" prop="father_id">
          <el-select v-model="dataForm.father_id" placeholder="请选择">
          <el-option
            v-for="menu in fatherMenus"
            :key="menu.menu_id"
            :label="menu.title"
            :value="menu.menu_id">
          </el-option>
  </el-select>
        </el-form-item>
      </el-form>
      <el-form ref="dataForm" :rules="rules" :model="dataForm" status-icon label-position="left" label-width="100px" style="width: 400px; float:left; margin-left:50px;">
        <el-form-item label="前端路由" prop="path">
          <el-input v-model="dataForm.path"/>
        </el-form-item>
        <el-form-item label="组件地址" prop="component">
          <el-input v-model="dataForm.component"/>
        </el-form-item>
        <el-form-item label="排序" prop="sort">
          <el-input v-model="dataForm.sort"/>
        </el-form-item>
      </el-form>
      <Transfer 
      :apiList="apiList" 
      :menuApi="dataForm.api"
      v-show="dataForm.father_id!==0"
      @changeApi="changeApi" />
      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormVisible = false">取消</el-button>
        <el-button v-if="dialogStatus=='create'" type="primary" @click="createData">确定</el-button>
        <el-button v-else type="primary" @click="updateData">确定</el-button>
      </div>
    </el-dialog>
  </div>
</template>

<script>
/**
  Auth: Lei.j1ang
  Created: 2018/1/19-14:54
*/
import treeTable from '@/components/TreeTable'
import Transfer from './components/Transfer'
import treeToArray from './customEval'
import { listMenu, update, create } from '@/api/menu'
import { fetchList } from '@/api/api'
import { deepClone } from '@/utils'
export default {
  name: 'CustomTreeTableDemo',
  components: { treeTable, Transfer },
  data() {
    return {
      func: treeToArray,
      expandAll: false,
      data:[],
      fatherMenus: [],
      args: [null, null, 'timeLine'],
      listQuery: {
        page: 1,
        limit: 20,
        name: undefined,
        sort: 'sort',
        order: 'asc'
      },
      dialogFormVisible: false,
      dialogStatus: '',
      dialogTitle: '编辑菜单',
      dataForm: {
        menu_id: undefined,
        father_id: 0,
        title: undefined,
        name: undefined,
        path: undefined,
        icon: undefined,
        component: undefined,
        sort: 255,
        api: []
      },
      apiList: [],
      rules: {
        title: [{ required: true, message: '菜单标题不能为空', trigger: 'blur' }],
        name: [{ required: true, message: '关联组件名称不能为空', trigger: 'blur' }],
        path: [{ required: true, message: '关联前端路由地址不能为空', trigger: 'blur' }],
        component: [{ required: true, message: '前端组件地址不能为空', trigger: 'blur' }],
      },
    }
  },
  created() {
    this.getList()
    let query = {
      type: 3
    }
    fetchList(query).then(response => {
      this.apiList = response.data.data
    })
  },
  methods: {
    changeApi(arr) {
      this.dataForm.api = arr
    },
    getList() {
      this.listLoading = true
      listMenu(this.listQuery)
        .then(response => {
          this.data = response.data.data
          this.fatherMenus = deepClone(this.data)
          this.fatherMenus.unshift({
            menu_id: 0,
            title: '根菜单'
          })
          this.listLoading = false
        })
        .catch(() => {
          this.listLoading = false
        })
    },
    resetForm() {
      this.dataForm = {
        menu_id: undefined,
        father_id: 0,
        title: undefined,
        name: undefined,
        path: undefined,
        icon: undefined,
        component: undefined,
        sort: 255,
        api: []
      }
    },
    handleCreate() {
      this.resetForm()
      this.dialogStatus = 'create'
      this.dialogFormVisible = true
      this.$nextTick(() => {
        this.$refs['dataForm'].clearValidate()
      })
    },
    createData() {
      this.$refs['dataForm'].validate(valid => {
        if (valid) {
          create(this.dataForm)
            .then(response => {
              this.getList()
              this.dialogFormVisible = false
              this.$notify.success({
                title: '成功',
                message: '添加管理员成功'
              })
            })
            .catch(response => {
              this.$notify.error({
                title: '失败',
                message: response.data.msg
              })
            })
        }
      })
    },
    handleUpdate(row) {
      this.dataForm = {
        menu_id: row.menu_id,
        father_id: row.father_id,
        title: row.title,
        name: row.name,
        path: row.path,
        icon: row.icon,
        component: row.component,
        sort: 255,
      }
      this.dialogFormVisible = true
      let api = []
      if(typeof row.api !== 'undefined') {
        for(const v of row.api) {
          api.push(v.api_id)
        }
      }
      this.dataForm.api = api
    },
    updateData() {
      this.$refs['dataForm'].validate(valid => {
        if (valid) {
          update(this.dataForm)
            .then(() => {
              this.getList()
              this.dialogFormVisible = false
              this.$notify.success({
                title: '成功',
                message: '更新菜单成功'
              })
            })
            .catch(response => {
              this.$notify.error({
                title: '失败',
                message: response.data.msg
              })
            })
        }
      })
    },
  }
}
</script>
