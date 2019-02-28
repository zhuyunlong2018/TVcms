import request from '@/utils/request'

export function fetchList(query) {
  return request({
    url: 'blog/Article/getTitleListByPage',
    method: 'get',
    params: query
  })
}

export function changeStatus(data) {
  return request({
    url: 'blog/Article/changeStatus',
    method: 'post',
    data
  })
}
