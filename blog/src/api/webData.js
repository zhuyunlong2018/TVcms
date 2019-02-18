import request from '@/utils/request'

export function get(query) {
  return request({
    url: 'adminApi/Web_Data/getData',
    method: 'get',
    params: query
  })
}

export function addPraise(data) { 
  return request({
    url: 'blogApi/Web_Data/addPraise',
    method: 'post',
    data
  })
}