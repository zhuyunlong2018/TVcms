import request from '@/utils/request'

export function getList(query) {
  return request({
    url: 'blog/tags/getList',
    method: 'get',
    params: query
  })
}
