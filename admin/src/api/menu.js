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

export function linkApi(data) {
  return request({
    url: '/admin/menu/linkApi',
    method: 'post',
    data
  })
}

export function unLinkApi(data) {
  return request({
    url: '/admin/menu/unLinkApi',
    method: 'post',
    data
  })
}

export function getMenu(query) {
  return request({
    url: '/admin/menu/getMenu',
    method: 'get',
    params: query
  })
}
