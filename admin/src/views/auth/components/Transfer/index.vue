<template>
  <div>
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
      ></el-transfer>
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
    };
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
        return [];
      }
    },
    menuApi: {
      type: Array,
      default() {
        return [];
      }
    }
  },
  watch: {
    menuApi: {
      handler(newValue, oldValue) {
        //父组件param对象改变会触发此函数
        this.value = newValue
      },
      deep: true
    }
  },
  methods: {
    handleChange(value, direction, movedKeys) {
      // console.log(value, direction, movedKeys);
      this.$emit('changeApi',value)
    }
  }
};
</script>