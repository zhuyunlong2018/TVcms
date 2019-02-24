<template>
  <div class="app-container">

    <!-- 查询和其他操作 -->
    <div class="filter-container">
      <el-button class="filter-item" type="primary" icon="el-icon-edit" @click="handleCreate">添加</el-button>
      <el-button :loading="downloadLoading" class="filter-item" type="primary" icon="el-icon-download" @click="handleDownload">导出</el-button>
    </div>

    <!-- 查询结果 -->
    <el-table v-loading="listLoading" :data="list" size="small" element-loading-text="正在查询中。。。" border fit highlight-current-row>
      <el-table-column align="center" width="100px" label="站点ID" prop="nb_id" sortable/>

      <el-table-column align="center" label="网站名" prop="nb_name"/>
      <el-table-column align="center" label="图标" prop="user_avatar">
        <template slot-scope="scope">
          <img v-if="scope.row.nb_icon" :src="scope.row.nb_icon" width="40">
        </template>
      </el-table-column>
      <el-table-column align="center" label="地址" prop="nb_url"/>

      <el-table-column align="center" label="状态" prop="nb_published">
        <template slot-scope="scope">
          <el-tag>{{ statusDic[scope.row.nb_published] }}</el-tag>
        </template>
      </el-table-column>

      <el-table-column align="center" label="操作" width="200" class-name="small-padding fixed-width">
        <template slot-scope="scope">
          <el-button type="primary" size="mini" @click="handleUpdate(scope.row)">编辑</el-button>
          <el-button type="danger" size="mini" @click="handleDelete(scope.row)">删除</el-button>
        </template>
      </el-table-column>
    </el-table>
    <!-- 添加或修改对话框 -->
    <el-dialog :title="textMap[dialogStatus]" :visible.sync="dialogFormVisible">
      <el-form ref="dataForm" :rules="rules" :model="dataForm" status-icon label-position="left" label-width="100px" style="width: 400px; margin-left:50px;">
        <el-form-item label="网站名" prop="nb_name">
          <el-input v-model="dataForm.nb_name"/>
        </el-form-item>
        <el-form-item label="网站图标地址" prop="nb_icon">
          <el-input v-model="dataForm.nb_icon"/>
        </el-form-item>
        <el-form-item label="网站地址" prop="nb_url">
          <el-input v-model="dataForm.nb_url"/>
        </el-form-item>
        <el-form-item label="是否展示" prop="nb_published">
          <el-select v-model="dataForm.nb_published">
            <el-option :value="0" label="关闭"/>
            <el-option :value="1" label="展示"/>
          </el-select>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormVisible = false">取消</el-button>
        <el-button v-if="dialogStatus=='create'" type="primary" @click="createData">确定</el-button>
        <el-button v-else type="primary" @click="updateData">确定</el-button>
      </div>
    </el-dialog>

  </div>
</template>

<script>
import { fetchList, addNeighbor, updateNeighbor, delNeighbor } from '@/api/neighbor'
export default {
  name: 'Neighbor',
  data() {
    return {
      list: null,
      listLoading: true,
      dataForm: {
        nb_id: undefined,
        nb_icon: '',
        nb_name: '',
        nb_published: 0,
        user_id: 1,
        nb_url: ''
      },
      dialogFormVisible: false,
      dialogStatus: '',
      textMap: {
        update: '编辑',
        create: '创建'
      },
      rules: {
        nb_name: [{ required: true, message: '网站名不能为空', trigger: 'blur' }],
        nb_url: [{ required: true, message: '网站地址不能为空', trigger: 'blur' }]
      },
      downloadLoading: false,
      statusDic: ['关闭', '展示']
    }
  },
  created() {
    this.getList()
  },
  methods: {
    getList() {
      this.listLoading = true
      fetchList().then(response => {
        this.list = response.data.data
        this.listLoading = false
      }).catch(() => {
        this.list = []
        this.total = 0
        this.listLoading = false
      })
    },
    handleFilter() {
      this.getList()
    },
    resetForm() {
      this.dataForm = {
        nb_id: undefined,
        nb_icon: '',
        nb_name: '',
        nb_published: 0,
        user_id: 1,
        nb_url: ''
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
      this.$refs['dataForm'].validate((valid) => {
        if (valid) {
          addNeighbor(this.dataForm).then(response => {
            this.list.unshift(response.data.data)
            this.dialogFormVisible = false
            this.$notify.success({
              title: '成功',
              message: '添加用户成功'
            })
          }).catch(response => {
            this.$notify.error({
              title: '失败',
              message: response.data.errmsg
            })
          })
        }
      })
    },
    handleUpdate(row) {
      this.dataForm = Object.assign({}, row)
      this.dialogStatus = 'update'
      this.dialogFormVisible = true
      this.$nextTick(() => {
        this.$refs['dataForm'].clearValidate()
      })
    },
    updateData() {
      this.$refs['dataForm'].validate((valid) => {
        if (valid) {
          updateNeighbor(this.dataForm).then(() => {
            for (const v of this.list) {
              if (v.nb_id === this.dataForm.nb_id) {
                const index = this.list.indexOf(v)
                this.list.splice(index, 1, this.dataForm)
                break
              }
            }
            this.dialogFormVisible = false
            this.$notify.success({
              title: '成功',
              message: '更新成功'
            })
          }).catch(response => {
            this.$notify.error({
              title: '失败',
              message: response.data.errmsg
            })
          })
        }
      })
    },
    handleDelete(row) {
      delNeighbor({ id: row.nb_id }).then(response => {
        for (const v of this.list) {
          if (v.nb_id === row.nb_id) {
            const index = this.list.indexOf(v)
            this.list.splice(index, 1)
            break
          }
        }
        this.$notify.success({
          title: '成功',
          message: '更新成功'
        })
      })
    },
    handleDownload() {
      this.downloadLoading = true
      import('@/vendor/Export2Excel').then(excel => {
        const tHeader = ['网站名', '网站地址']
        const filterVal = ['nb_name', 'nb_url']
        excel.export_json_to_excel2(tHeader, this.list, filterVal, '友情链接信息')
        this.downloadLoading = false
      })
    }
  }
}
</script>
