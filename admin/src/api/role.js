import request from '@/utils/request'

export function listRole(query) {
  return request({
    url: '/adminApi/role/getList',
    method: 'get',
    params: query
  })
}

export function updateRole(data) {
  return request({
    url: '/adminApi/role/update',
    method: 'post',
    data
  })
}

export function createRole(data) {
  return request({
    url: '/adminApi/role/create',
    method: 'post',
    data
  })
}

export function deleteRole(data) {
  return request({
    url: '/adminApi/role/delete',
    method: 'post',
    data
  })
}

export function findRole(query) {
  return request({
    url: '/adminApi/role/findByName',
    method: 'get',
    params: query
  })
}
