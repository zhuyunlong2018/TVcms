import request from '@/utils/request'

export function listRole(query) {
  return request({
    url: '/admin/role/getList',
    method: 'get',
    params: query
  })
}

export function updateRole(data) {
  return request({
    url: '/admin/role/update',
    method: 'post',
    data
  })
}

export function createRole(data) {
  return request({
    url: '/admin/role/create',
    method: 'post',
    data
  })
}

export function deleteRole(data) {
  return request({
    url: '/admin/role/delete',
    method: 'post',
    data
  })
}

export function findRole(query) {
  return request({
    url: '/admin/role/findByName',
    method: 'get',
    params: query
  })
}
