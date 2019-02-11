import request from '@/utils/request'

export function info(query) {
  return request({
    url: '/mock/home',
    method: 'get',
    params: query
  })
}
