import request from '@/utils/request'

export function loginByUsername(username, password) {
  const data = {
    username,
    password
  }
  return request({
    url: '/adminApi/admin/login',
    method: 'post',
    data
  })
}

export function logout() {
  return request({
    url: '/adminApi/admin/logout',
    method: 'post'
  })
}

export function getUserInfo(token) {
  return request({
    url: '/adminApi/mock/info',
    method: 'get',
    params: { token }
  })
}

