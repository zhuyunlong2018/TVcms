<template>
  <div class="dndList" >
    <div :style="{width:width1}" class="dndList-list">
      <h3>{{ list1Title }}</h3>
      <draggable :list="list1" @add='linkApi' @remove='unLinkApi' :move="changeApi" :options="{group:'api'}" class="dragArea">
        <div v-for="element in list1" :key="element.api_id" class="list-complete-item">
          <div class="list-complete-item-handle">[{{ element.api_path }}] {{ element.api_name }}</div>
          <div style="position:absolute;right:0px;">
            <span style="float: right ;margin-top: -20px;margin-right:5px;" @click="deleteEle(element)">
              <i style="color:#ff4949" class="el-icon-delete"/>
            </span>
          </div>
        </div>
      </draggable>
    </div>
    <div :style="{width:width2}" class="dndList-list">
      <h3>{{ list2Title }}</h3>
      <draggable :list="filterList2" :move="changeApi" :options="{group:'api'}" class="dragArea">
        <div v-for="element in filterList2" :key="element.api_id" class="list-complete-item">
          <div class="list-complete-item-handle2" @click="pushEle(element)"> [{{ element.api_path }}] {{ element.api_name }}</div>
        </div>
      </draggable>
    </div>
  </div>
</template>

<script>
import draggable from 'vuedraggable'
import { linkApi, unLinkApi } from '@/api/menu'
import { resolve } from 'q';
export default {
  name: 'DndList',
  components: { draggable },
  data() {
    return {
      data: {
        menu: 0,
        api: 0
      }
    }
  },
  props: {
    list1: {
      type: Array,
      default() {
        return []
      }
    },
    list2: {
      type: Array,
      default() {
        return []
      }
    },
    menu_id: {
      type: Number,
      default() {
        return 0
      }
    },
    list1Title: {
      type: String,
      default: '已绑定API'
    },
    list2Title: {
      type: String,
      default: '权限API'
    },
    width1: {
      type: String,
      default: '48%'
    },
    width2: {
      type: String,
      default: '48%'
    }
  },
  computed: {
    filterList2() {
      return this.list2.filter(v => {
        if (this.isNotInList1(v)) {
          return v
        }
        return false
      })
    }
  },
  methods: {
    isNotInList1(v) {
      return this.list1.every(k => v.api_id !== k.api_id)
    },
    isNotInList2(v) {
      return this.list2.every(k => v.api_id !== k.api_id)
    },
    deleteEle(ele) {
      this.data.menu = this.menu_id
      this.data.api = ele.api_id
      this.unLinkApi().then(response => {
        for (const item of this.list1) {
          if (item.api_id === ele.api_id) {
            const index = this.list1.indexOf(item)
            this.list1.splice(index, 1)
            break
          }
        }
        if (this.isNotInList2(ele)) {
          this.list2.unshift(ele)
        }
      })
      
    },
    pushEle(ele) {
      this.data.menu = this.menu_id
      this.data.api = ele.api_id
      this.linkApi().then(response => {
        this.list1.push(ele)
      })
      
    },
    changeApi(evt) {
      const api_id = evt.draggedContext.element.api_id
      this.data.menu = this.menu_id
      if (this.data.api != api_id) {
        this.data.api = api_id
      }
    },
    linkApi() {
      return linkApi(this.data).then(response => {
        resolve()
      })
    },
    unLinkApi() {
      return unLinkApi(this.data).then(response => {
        resolve()
      })
    }
  }
}
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
.dndList {
  background: #fff;
  padding-bottom: 40px;
  &:after {
    content: "";
    display: table;
    clear: both;
  }
  .dndList-list {
    float: left;
    padding-bottom: 30px;
    &:first-of-type {
      margin-right: 2%;
    }
    .dragArea {
      margin-top: 15px;
      min-height: 50px;
      padding-bottom: 30px;
    }
  }
}

.list-complete-item {
  cursor: pointer;
  position: relative;
  font-size: 14px;
  padding: 5px 12px;
  margin-top: 4px;
  border: 1px solid #bfcbd9;
  transition: all 1s;
}

.list-complete-item-handle {
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  margin-right: 50px;
}

.list-complete-item-handle2 {
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  margin-right: 20px;
}

.list-complete-item.sortable-chosen {
  background: #4AB7BD;
}

.list-complete-item.sortable-ghost {
  background: #30B08F;
}

.list-complete-enter,
.list-complete-leave-active {
  opacity: 0;
}
</style>
