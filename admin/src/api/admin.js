import request from '@/utils/request'

export function listAdmin(query) {
  return request({
    url: '/adminApi/admin/getList',
    method: 'get',
    params: query
  })
}

export function createAdmin(data) {
  return request({
    url: '/adminApi/admin/create',
    method: 'post',
    data
  })
}

export function updateAdmin(data) {
  return request({
    url: '/adminApi/admin/update',
    method: 'post',
    data
  })
}

export function deleteAdmin(data) {
  return request({
    url: '/adminApi/admin/delete',
    method: 'post',
    data
  })
}
