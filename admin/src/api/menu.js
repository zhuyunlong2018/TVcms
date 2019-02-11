import request from '@/utils/request'

export function listMenu(query) {
  return request({
    url: '/adminApi/menu/getList',
    method: 'get',
    params: query
  })
}

export function getUserRouter(query) {
  return request({
    url: '/adminApi/menu/getRouter',
    method: 'get',
    params: query
  })
}

export function linkApi(data) {
  return request({
    url: '/adminApi/menu/linkApi',
    method: 'post',
    data
  })
}

export function unLinkApi(data) {
  return request({
    url: '/adminApi/menu/unLinkApi',
    method: 'post',
    data
  })
}

export function getMenu(query) {
  return request({
    url: '/adminApi/menu/getMenu',
    method: 'get',
    params: query
  })
}
