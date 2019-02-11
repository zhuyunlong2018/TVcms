import request from '@/utils/request'

export function login(data) {
  return request({
    url: 'adminApi/user/login',
    method: 'post',
    data
  })
}

export function register(data) {
  return request({
    url: 'adminApi/user/register',
    method: 'post',
    data
  })
}