import request from '@/utils/request'

export function listMenu(query) {
  return request({
    url: '/admin/menu/getList',
    method: 'get',
    params: query
  })
}

export function getUserRouter(query) {
  return request({
    url: '/admin/menu/getRouter',
    method: 'get',
    params: query
  })
}

export function getMenu(query) {
  return request({
    url: '/admin/menu/getMenu',
    method: 'get',
    params: query
  })
}

export function update(data) {
  return request({
    url: '/admin/menu/update',
    method: 'post',
    data
  })
}

export function create(data) {
  return request({
    url: '/admin/menu/create',
    method: 'post',
    data
  })
}
