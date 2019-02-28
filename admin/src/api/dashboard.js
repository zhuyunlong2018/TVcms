import request from '@/utils/request'

export function getData(query) {
  return request({
    url: '/admin/web_data/getData',
    method: 'get',
    params: query
  })
}
