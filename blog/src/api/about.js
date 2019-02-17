import request from '@/utils/request'

export function get(user_id) {
    return request({
      url: '/blogApi/about/getOne',
      method: 'get',
      params: { user_id }
    })
  }