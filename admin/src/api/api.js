import request from '@/utils/request'

export function fetchList(query) {
  return request({
    url: '/admin/api/getList',
    method: 'get',
    params: query
  })
}

export function changeType(data) {
  return request({
    url: '/admin/api/changeType',
    method: 'post',
    data
  })
}
