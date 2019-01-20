import request from '@/utils/request'

export function login(email, password) {
  return request({
    url: 'blogApi/user/login',
    method: 'post',
    data: {
      email,
      password
    }
  })
}

export function register(name,email,password) {
  return request({
    url: 'blogApi/user/register',
    method: 'post',
    data: {
      name,email,password
    }
  })
}