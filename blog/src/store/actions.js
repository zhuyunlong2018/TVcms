
import { getStorage, setStorage } from '@/utils/storage'
import { get as getWebData, addPraise } from '@/api/webData'

const actions = {

// 获取网站基本统计数据
  getWebData({ commit }) {
    getWebData().then(response => {
      commit('GET_WEB_DATA', response.data.data)
    })
  },

  // 点赞
  addPraise({ commit }, id) {
    // 判断是否点赞
    const add_praise = id + '_add_praise'
    return new Promise((resolve, reject) => {
      if (getStorage(add_praise)) {
        commit('SHOW_ALERT', '试试点赞其他文章吧！')
        reject()
      } else {
        setStorage(add_praise, '点赞成功！')
        const data = { id }
        addPraise(data).then(response => {
          commit('ADD_PRAISE', id)
          commit('SHOW_MESSAGE', '点赞成功')
          resolve()
        })
      }
    })
  }

}

export default actions
