import request from '@/utils/request'

export function add(data) {
  return request({
    url: '/blogApi/comment/add',
    method: 'post',
    data
  })
}

export function getList(query) {
  return request({
    url: '/blogApi/comment/getByArticleID',
    method: 'get',
    params: query
  })
}