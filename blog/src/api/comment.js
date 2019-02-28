import request from '@/utils/request'

export function add(data) {
  return request({
    url: '/blog/comment/add',
    method: 'post',
    data
  })
}

export function getList(query) {
  return request({
    url: '/blog/comment/getByArticleID',
    method: 'get',
    params: query
  })
}