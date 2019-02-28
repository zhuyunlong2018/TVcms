import request from '@/utils/request'

export function fetchList(query) {
  return request({
    url: '/admin/user/getList',
    method: 'get',
    params: query
  })
}

export function findUser(query) {
  return request({
    url: '/admin/user/getOne',
    method: 'get',
    params: query
  })
}

export function changeStatus(data) {
  return request({
    url: '/admin/user/changeStatus',
    method: 'post',
    data
  })
}
