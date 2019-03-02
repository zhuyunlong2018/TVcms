import request from '@/utils/request'

export function get(query) {
  return request({
    url: 'admin/Web_Data/getData',
    method: 'get',
    params: query
  })
}

export function addPraise(data) {
  return request({
    url: 'blog/Web_Data/addPraise',
    method: 'post',
    data
  })
}
