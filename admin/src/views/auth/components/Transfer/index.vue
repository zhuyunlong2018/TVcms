<template>
  <div>
    <p style="text-align: center; margin: 0 0 20px">使用 render-content 自定义数据项</p>
    <div style="text-align: center">
      <el-transfer
        style="text-align: left; display: inline-block"
        v-model="value"
        filterable
        :render-content="renderFunc"
        :titles="['全部api', '已关联api']"
        :button-texts="[]"
        :format="{
          noChecked: '${total}',
          hasChecked: '${checked}/${total}'
        }"
        @change="handleChange"
        :data="data"
      >
      </el-transfer>
    </div>



  </div>
</template>

<style>
  .transfer-footer {
    margin-left: 20px;
    padding: 6px 5px;
  }
  .el-transfer-panel {
    width: 400px;
  }
</style>

<script>
export default {
  data() {
    const generateData = list => {
      const data = [];
      for (let i = 0; i < list.length; i++) {
        data.push({
          key: list[i].api_id,
          label: `${list[i].api_name}(${list[i].api_path})`,
          disabled: false
        });
      }
      return data;
    }
    const checked = arr => {
      let data = []
      for(const v of arr) {
        data.push(v)
      }
      return data
    }
    return {
      data: generateData(this.apiList),
      // value: checked(this.menuApi),
      value: this.menuApi,
      renderFunc(h, option) {
        return (
          <span>
            {option.key} - {option.label}
          </span>
        );
      }
    };
  },
  props: {
      apiList: {
        type: Array,
        default() {
          return []
        }
      },
      menuApi: {
        type: Array,
        default() {
          return []
        }
      }
  },

  methods: {
    handleChange(value, direction, movedKeys) {
      console.log(value, direction, movedKeys);
    }
  }
};
</script>