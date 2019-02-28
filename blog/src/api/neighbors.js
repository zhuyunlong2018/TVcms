import request from '@/utils/request'

export function getList(query) {
  return request({
    url: 'blog/neighbors/getList',
    method: 'get',
    params: query
  })
}