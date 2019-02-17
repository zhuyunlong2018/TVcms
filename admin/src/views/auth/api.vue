<template>
  <div class="tab-container">
    <el-tag>mounted times ：{{ createdTimes }}</el-tag>
    <el-alert :closable="false" style="width:200px;display:inline-block;vertical-align: middle;margin-left:30px;" title="Tab with keep-alive" type="success"/>
    <el-tabs v-model="activeName" style="margin-top:15px;" type="border-card">
      <el-tab-pane v-for="item in tabMapOptions" :label="item.label" :key="item.key" :name="item.key">
        <keep-alive>
          <tab-pane v-if="activeName==item.key" @changeApiType='changeApiType' :changed='changed' :type="item.key" @create="showCreatedTimes"/>
        </keep-alive>
      </el-tab-pane>
    </el-tabs>
  </div>
</template>

<script>
import tabPane from './components/tabPane'

export default {
  name: 'Tab',
  components: { tabPane },
  data() {
    return {
      tabMapOptions: [
        { label: '权限收录', key: '3' },
        { label: 'Auth白名单', key: '2' },
        { label: 'token白名单', key: '1' },
        { label: '未注册', key: '0' }
      ],
      activeName: '3',
      createdTimes: 0,
      changed: [false,false,false,false]
    }
  },
  methods: {
    showCreatedTimes() {
      this.createdTimes = this.createdTimes + 1
    },
    changeApiType(type,val) {
      if(val) {
        this.changed = [val,val,val,val]
      } else {
        this.changed[type] = val
      }
    }
  }
}
</script>

<style scoped>
  .tab-container{
    margin: 30px;
  }
</style>
