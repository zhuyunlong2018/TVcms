import request from '@/utils/request'

export function getList(query) {
  return request({
    url: '/blogApi/article/getList',
    method: 'get',
    params: query
  })
}

export function getOne(ID) {
  return request({
    url: '/blogApi/article/getOne',
    method: 'get',
    params: { ID }
  })
}
