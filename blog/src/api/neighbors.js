import request from '@/utils/request'

export function getList(query) {
  return request({
    url: 'blogApi/neighbors/getList',
    method: 'get',
    params: query
  })
}