import request from '@/utils/request'

export function fetchList(query) {
  return request({
    url: '/adminApi/api/getList',
    method: 'get',
    params: query
  })
}

export function changeType(data) {
  return request({
    url: '/adminApi/api/changeType',
    method: 'post',
    data
  })
}
