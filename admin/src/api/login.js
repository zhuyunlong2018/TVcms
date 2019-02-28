import request from '@/utils/request'

export function loginByUsername(username, password) {
  const data = {
    username,
    password
  }
  return request({
    url: '/admin/admin/login',
    method: 'post',
    data
  })
}

export function logout() {
  return request({
    url: '/admin/admin/logout',
    method: 'post'
  })
}

export function getUserInfo(token) {
  return request({
    url: '/admin/mock/info',
    method: 'get',
    params: { token }
  })
}

