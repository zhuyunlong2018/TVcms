import request from '@/utils/request'

export function login(useremail, password) {
  return request({
    url: 'blogApi/user/login',
    method: 'post',
    data: {
      useremail,
      password
    }
  })
}

export function getInfo(token) {
  return request({
    url: '/user/info',
    method: 'get',
    params: { token }
  })
}

export function logout() {
  return request({
    url: '/user/logout',
    method: 'post'
  })
}
