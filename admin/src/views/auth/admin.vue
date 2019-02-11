<template>
  <div class="app-container">

    <!-- 查询和其他操作 -->
    <div class="filter-container">
      <el-input v-model="listQuery.name" clearable class="filter-item" style="width: 200px;" placeholder="请输入管理员名称"/>
      <el-button class="filter-item" type="primary" icon="el-icon-search" @click="handleFilter">查找</el-button>
      <el-button class="filter-item" type="primary" icon="el-icon-edit" @click="handleCreate">添加</el-button>
    </div>

    <!-- 查询结果 -->
    <el-table v-loading="listLoading" :data="list" size="small" element-loading-text="正在查询中。。。" border fit highlight-current-row>
      <el-table-column align="center" label="管理员ID" prop="admin_id" sortable/>

      <el-table-column align="center" label="管理员名称" prop="admin_name"/>

      <el-table-column align="center" label="绑定用户ID" prop="user_id"/>
      <el-table-column align="center" label="绑定用户头像" prop="user">
        <template slot-scope="scope">
          <img v-if="scope.row.user.user_avatar" :src="scope.row.user.user_avatar" width="40">
        </template>
      </el-table-column>
      <el-table-column align="center" label="绑定用户名" prop="user.user_name"/>
      <el-table-column align="center" label="绑定用户邮箱" prop="user.user_email"/>
      <el-table-column align="center" label="绑定角色" prop="roles">
        <template slot-scope="scope">
          <el-tag :key="role.role_id" v-for="role in scope.row.roles">
            {{role.role_name}}
          </el-tag>
        </template>
      </el-table-column>
      <el-table-column align="center" label="操作" class-name="small-padding fixed-width">
        <template slot-scope="scope">
          <el-button type="primary" size="mini" @click="handleUpdate(scope.row)">编辑</el-button>
          <el-button type="danger" size="mini" @click="handleDelete(scope.row)">删除</el-button>
        </template>
      </el-table-column>
    </el-table>

    <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" />

    <!-- 添加或修改对话框 -->
    <el-dialog :title="textMap[dialogStatus]" :visible.sync="dialogFormVisible">
      <el-form ref="dataForm" :rules="rules" :model="dataForm" status-icon label-position="left" label-width="100px" style="width: 400px; margin-left:50px;">
        <el-form-item label="管理员名称" prop="admin_name">
          <el-input v-model="dataForm.admin_name"/>
        </el-form-item>
        <el-form-item label="关联用户" prop="user">
          <el-tag type="info" v-if="dataForm.user.user_name" >name:{{dataForm.user.user_name}}</el-tag>
          <el-tag type="success" v-if="dataForm.user.user_email">email:{{dataForm.user.user_email}}</el-tag>
          <el-input size="mini" placeholder="请输入内容" v-model="searchUser.value" class="input-with-select">
            <el-select v-model="searchUser.type" slot="prepend" placeholder="请选择">
              <el-option label="name" value="user_name"></el-option>
              <el-option label="email" value="user_email"></el-option>
            </el-select>
            <el-button slot="append" icon="el-icon-search" @click="findUser"></el-button>
          </el-input>
        </el-form-item>
        <el-form-item label="关联角色" prop="role">
          <el-tag
          :key="role.role_id"
          v-for="(role,index) in dataForm.roles"
          closable
          :disable-transitions="false"
          @close="handleClose(index)">
          {{role.role_name}}
        </el-tag>
        <el-input
          class="input-new-tag"
          v-if="inputVisible"
          v-model="inputValue"
          ref="saveTagInput"
          size="small"
          @keyup.enter.native="handleInputConfirm"
          @blur="handleInputConfirm"
        >
        </el-input>
        <el-button v-else class="button-new-tag" size="small" @click="showInput">+ New Role</el-button>
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

<style>
.avatar-uploader .el-upload {
  border: 1px dashed #d9d9d9;
  border-radius: 6px;
  cursor: pointer;
  position: relative;
  overflow: hidden;
}
.avatar-uploader .el-upload:hover {
  border-color: #20a0ff;
}
.avatar-uploader-icon {
  font-size: 28px;
  color: #8c939d;
  width: 120px;
  height: 120px;
  line-height: 120px;
  text-align: center;
}
.avatar {
  width: 120px;
  height: 120px;
  display: block;
}
.el-tag + .el-tag {
  margin-left: 10px;
}
.el-tag + .el-tag {
  margin-left: 10px;
}
.button-new-tag {
  margin-left: 10px;
  height: 32px;
  line-height: 30px;
  padding-top: 0;
  padding-bottom: 0;
}
.input-new-tag {
  width: 90px;
  margin-left: 10px;
  vertical-align: bottom;
}
 
</style>

<script>
import { listAdmin, createAdmin, updateAdmin, deleteAdmin } from '@/api/admin'
import { findRole } from '@/api/role'
import { findUser } from '@/api/user'
import { uploadPath } from '@/api/storage'
import { getToken } from '@/utils/auth'
import Pagination from '@/components/Pagination' // Secondary package based on el-pagination
import { deepClone } from '@/utils'

export default {
  name: 'Admin',
  components: { Pagination },
  data() {
    return {
      uploadPath,
      list: null,
      total: 0,
      listLoading: true,
      listQuery: {
        page: 1,
        limit: 20,
        name: undefined,
        sort: 'create_time',
        order: 'desc'
      },
      dataForm: {
        admin_id: undefined,
        admin_name: undefined,
        roles: [],
        user: {}
      },
      dialogFormVisible: false,
      dialogStatus: '',
      textMap: {
        update: '编辑',
        create: '创建'
      },
      searchUser: {
        type: 'user_name',
        value: ''
      },
      rules: {
        admin_name: [
          { required: true, message: '管理员名称不能为空', trigger: 'blur' }
        ]
      },
      inputVisible: false,
      inputValue: '',
      downloadLoading: false
    }
  },
  created() {
    this.getList()
  },
  methods: {
    getList() {
      this.listLoading = true
      listAdmin(this.listQuery)
        .then(response => {
          this.list = response.data.data.data
          this.total = response.data.data.total
          this.listLoading = false
        })
        .catch(() => {
          this.list = []
          this.total = 0
          this.listLoading = false
        })
    },
    handleFilter() {
      this.listQuery.page = 1
      this.getList()
    },
    resetForm() {
      this.dataForm = {
        admin_id: undefined,
        admin_name: undefined,
        roles: [],
        user: {}
      }
      this.searchUser = {
        type: 'user_name',
        value: ''
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
          createAdmin(this.dataForm)
            .then(response => {
              this.dataForm.admin_id = response.data.data.admin_id
              this.dataForm.user_id = response.data.data.user_id
              this.list.push(deepClone(this.dataForm))
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
      this.dataForm = deepClone(row)
      this.searchUser = {
        type: 'user_name',
        value: ''
      }
      this.dialogStatus = 'update'
      this.dialogFormVisible = true
      this.$nextTick(() => {
        this.$refs['dataForm'].clearValidate()
      })
    },
    updateData() {
      this.$refs['dataForm'].validate(valid => {
        if (valid) {
          updateAdmin(this.dataForm)
            .then(() => {
              for (const v of this.list) {
                if (v.admin_id === this.dataForm.admin_id) {
                  const index = this.list.indexOf(v)
                  this.list.splice(index, 1, deepClone(this.dataForm))
                  this.list[index].user_id = this.dataForm.user.user_id
                  break
                }
              }
              this.dialogFormVisible = false
              this.$notify.success({
                title: '成功',
                message: '更新管理员成功'
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
    handleDelete(row) {
      deleteAdmin(row)
        .then(response => {
          this.$notify.success({
            title: '成功',
            message: '删除管理员成功'
          })
          const index = this.list.indexOf(row)
          this.list.splice(index, 1)
        })
        .catch(response => {
          this.$notify.error({
            title: '失败',
            message: response.data.msg
          })
        })
    },
    handleClose(index) {
      this.dataForm.roles.splice(index, 1);
    },

    showInput() {
      this.inputVisible = true;
      this.$nextTick(_ => {
        this.$refs.saveTagInput.$refs.input.focus();
      });
    },

    handleInputConfirm() {
      let inputValue = this.inputValue;
      if (inputValue) {
        let check = this.dataForm.roles.every(element => {
          if(element.role_name == inputValue) {
            return false
          } else {
            return true
          }
        });
        if(!check) {
          return this.$notify.error({
            title: '失败',
            message: '添加的角色不能重复'
          })
        }
        findRole({name: inputValue}).then(response => {
          let data = response.data.data
          this.dataForm.roles.push(data)
        })
      }
      this.inputVisible = false;
      this.inputValue = '';
    },
    findUser() {
      if(!this.searchUser.value) {
        return this.$notify.error({
          title: '失败',
          message: '请填写要检索用户名或邮箱'
        })
      }
      findUser(this.searchUser).then(response => {
        this.dataForm.user = response.data.data
      })
    }
  }
}
</script>
