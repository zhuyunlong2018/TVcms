import request from '@/utils/request'

export function fetchList(query) {
  return request({
    url: 'blogApi/Article/getTitleListByPage',
    method: 'get',
    params: query
  })
}

export function changeStatus(data) {
  return request({
    url: 'blogApi/Article/changeStatus',
    method: 'post',
    data
  })
}
