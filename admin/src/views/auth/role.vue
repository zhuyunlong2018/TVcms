<template>
  <div class="app-container">
    <!-- 查询和其他操作 -->
    <div class="filter-container">
      <el-input
        v-model="listQuery.name"
        clearable
        class="filter-item"
        style="width: 200px;"
        placeholder="请输入角色名称"
      />
      <el-button class="filter-item" type="primary" icon="el-icon-search" @click="handleFilter">查找</el-button>
      <el-button class="filter-item" type="primary" icon="el-icon-edit" @click="handleCreate">添加</el-button>
    </div>

    <!-- 查询结果 -->
    <el-table
      v-loading="listLoading"
      :data="list"
      size="small"
      element-loading-text="正在查询中。。。"
      border
      fit
      highlight-current-row
    >
      <el-table-column align="center" label="角色ID" prop="role_id" sortable/>

      <el-table-column align="center" label="角色名称" prop="role_name"/>

      <el-table-column align="center" label="角色描述" prop="role_desc"/>

      <el-table-column align="center" label="操作" class-name="small-padding fixed-width">
        <template slot-scope="scope">
          <el-button type="primary" size="mini" :disabled="scope.row.role_name=='admin'" @click="handleUpdate(scope.row)">编辑</el-button>
          <el-button type="danger" size="mini" :disabled="scope.row.role_name=='admin'" @click="handleDelete(scope.row)">删除</el-button>
        </template>
      </el-table-column>
    </el-table>

    <pagination
      v-show="total>0"
      :total="total"
      :page.sync="listQuery.page"
      :limit.sync="listQuery.limit"
      @pagination="getList"
    />

    <!-- 添加或修改对话框 -->
    <el-dialog :title="textMap[dialogStatus]" :visible.sync="dialogFormVisible">
      <el-form
        ref="dataForm"
        :rules="rules"
        :model="dataForm"
        status-icon
        label-position="left"
        label-width="100px"
        style="max-width: 400px; margin-left:20px;"
      >
        <el-form-item label="角色名称" prop="role_name">
          <el-input v-model="dataForm.role_name"/>
        </el-form-item>
        <el-form-item label="角色描述" prop="role_desc">
          <el-input v-model="dataForm.role_desc"/>
        </el-form-item>
        <el-form-item label="权限设置" prop="write_auth">
          <el-switch
          v-model="auth"
          active-text="读写模式"
          inactive-text="只读模式">
          </el-switch>
        </el-form-item>
      </el-form>
      <div class="checkbox-group" v-for='(menu,index) in menus' :key="menu.menu_id">
        <el-checkbox
        :indeterminate="dataForm.menus[index].isIndeterminate"
        v-model="dataForm.menus[index].checkAll"
        @change="((val) => { handleCheckAllChange(val, index) })"
        >{{menu.title}}</el-checkbox>
        <el-checkbox-group class="el-checkbox-group" v-model="dataForm.menus[index].children" @change="((val) => { handleCheckedMenusChange(val, index, menu) })">
          <el-checkbox v-for="subMenu in menu.children" :label="subMenu.menu_id" :key="subMenu.menu_id">{{subMenu.title}}</el-checkbox>
        </el-checkbox-group>
      </div>
      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormVisible = false">取消</el-button>
        <el-button v-if="dialogStatus=='create'" type="primary" @click="createData">确定</el-button>
        <el-button v-else type="primary" @click="updateData">确定</el-button>
      </div>
    </el-dialog>
  </div>
</template>

<style>
.el-tag + .el-tag {
  margin-left: 10px;
}
.checkbox-group {
  margin-top: 10px;
  margin-left: 20px;
}
</style>

<script>
import { listRole, createRole, updateRole, deleteRole } from "@/api/role"
import { getMenu } from '@/api/menu'
import Pagination from "@/components/Pagination"; // Secondary package based on el-pagination
import { deepClone } from '@/utils'

export default {
  name: "Role",
  components: { Pagination },
  data() {
    return {
      list: null,
      total: 0,
      listLoading: true,
      listQuery: {
        page: 1,
        limit: 20,
        name: undefined,
        sort: "create_time",
        order: "desc"
      },
      dataForm: {
        role_id: undefined,
        role_name: undefined,
        role_desc: undefined,
        write_auth: 0,
        menus: undefined
      },
      dialogFormVisible: false,
      dialogStatus: "",
      textMap: {
        update: "编辑",
        create: "创建"
      },
      rules: {
        role_name: [
          { required: true, message: "角色名称不能为空", trigger: "blur" }
        ],
        role_desc: [{ required: true, message: "角色描述不能为空", trigger: "blur" }]
      },
      auth: false,
      menus: [],
      handleMenus: []
    };
  },
  created() {
    this.getList()
    this.getMenu()
  },
  methods: {
    getList() {
      this.listLoading = true
      listRole(this.listQuery)
        .then(response => {
          this.list = response.data.data.data
          this.total = response.data.data.total
          this.listLoading = false
        })
        .catch(() => {
          this.list = []
          this.total = 0
          this.listLoading = false
        });
    },
    handleFilter() {
      this.listQuery.page = 1
      this.getList()
    },
    resetForm() {
      let menus = deepClone(this.handleMenus)
      menus.forEach(element => {
        element.children = []
        element.checkAll = false
        element.isIndeterminate = false
      })
      this.auth = false
      this.dataForm = {
        role_id: undefined,
        role_name: undefined,
        role_desc: undefined,
        write_auth: 0,
        menus
      }

    },
    handleCreate() {
      this.resetForm();
      this.dialogStatus = "create";
      this.dialogFormVisible = true;
      this.$nextTick(() => {
        this.$refs["dataForm"].clearValidate();
      })
    },
    createData() {
      this.$refs["dataForm"].validate(valid => {
        if (valid) {
          this.dataForm.write_auth = this.auth?1:0
          createRole(this.dataForm)
            .then(response => {
              let menus = deepClone(this.dataForm.menus)
                menus.forEach((element,index) => {
                  let children = []
                  let data
                  element.children.forEach(ele => {
                    data = {}
                    data.menu_id = ele
                    children.push(data)
                  })
                  menus[index].children = children
                });
              response.data.data.menus = menus
              this.list.push(response.data.data);
              this.dialogFormVisible = false;
              this.$notify.success({
                title: "成功",
                message: "添加角色成功"
              });
            })
            .catch(response => {
              this.$notify.error({
                title: "失败",
                message: response.data.msg
              });
            });
        }
      });
    },
    handleUpdate(row) {
      let data = deepClone(row)
      data.menus = this.handleMenusChildren(row.menus)
      data.menus.forEach((element,index) => {
        let checkedCount = element.children.length
        element.checkAll = checkedCount === this.handleMenus[index].children.length;
        element.isIndeterminate = checkedCount > 0 && checkedCount < this.handleMenus[index].children.length;
      });
      this.auth = data.write_auth==1?true:false
      this.dataForm = data
      this.dialogStatus = "update";
      this.dialogFormVisible = true;
      this.$nextTick(() => {
        this.$refs["dataForm"].clearValidate();
      });
    },
    updateData() {
      this.$refs["dataForm"].validate(valid => {
        if (valid) {
          this.dataForm.write_auth = this.auth?1:0
          updateRole(this.dataForm)
            .then(() => {
              for (const v of this.list) {
                if (v.role_id === this.dataForm.role_id) {
                  v.role_name = this.dataForm.role_name
                  v.role_desc = this.dataForm.role_desc
                  v.write_auth = this.dataForm.write_auth
                  let menus = deepClone(this.dataForm.menus)
                  menus.forEach((element,index) => {
                    let children = []
                    let data
                    element.children.forEach(ele => {
                      data = {}
                      data.menu_id = ele
                      children.push(data)
                    })
                    v.menus[index].children = children
                  });
                  break;
                }
              }
              this.dialogFormVisible = false;
              this.$notify.success({
                title: "成功",
                message: "更新角色成功"
              });
            })
            .catch(response => {
              this.$notify.error({
                title: "失败",
                message: response.data.msg
              });
            });
        }
      });
    },
    handleDelete(row) {
      deleteRole(row)
        .then(response => {
          this.$notify.success({
            title: "成功",
            message: "删除角色成功"
          });
          const index = this.list.indexOf(row);
          this.list.splice(index, 1);
        })
        .catch(response => {
          this.$notify.error({
            title: "失败",
            message: response.data.msg
          });
        });
    },
    handleCheckAllChange(val,index) {
      this.dataForm.menus[index].children = val ? this.handleMenus[index].children : [];
      this.dataForm.menus[index].isIndeterminate = false;
    },
    handleCheckedMenusChange(value,index,menu) {
      let checkedCount = value.length;
      this.dataForm.menus[index].checkAll = checkedCount === this.handleMenus[index].children.length;
      this.dataForm.menus[index].isIndeterminate = checkedCount > 0 && checkedCount < this.handleMenus[index].children.length;
    },
    getMenu() {
      this.listLoading = true;
      getMenu('').then(response => {
        let data = response.data.data
        this.listLoading = false;
        this.handleMenus = this.handleMenusChildren(data)
        this.resetForm()
        this.menus = data
          // resolve()
        }).catch(() => {
          this.listLoading = false;
          // reject()
        });
    },
    handleMenusChildren(arr) {
      let data = deepClone(arr)
      data.forEach(element => {
        let children = []
        element.children.forEach(ele => {
          children.push(ele.menu_id)
        });
        element.children = children
      })
      return data
    }
  }
};
</script>
