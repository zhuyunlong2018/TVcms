import request from '@/utils/request'

export function fetchList(query) {
  return request({
    url: '/adminApi/user/getList',
    method: 'get',
    params: query
  })
}

export function createUser(data) {
  return request({
    url: '/adminApi/user/create',
    method: 'post',
    data
  })
}

export function readUser(data) {
  return request({
    url: '/adminApi/user/detail',
    method: 'get',
    data
  })
}

export function updateUser(data) {
  return request({
    url: '/user/update',
    method: 'post',
    data
  })
}

export function findUser(query) {
  return request({
    url: '/adminApi/user/getOne',
    method: 'get',
    params: query
  })
}
