import request from '@/utils/request'

export function fetchList(query) {
  return request({
    url: '/blog/neighbors/getAll',
    method: 'get',
    params: query
  })
}

export function addNeighbor(data) {
  return request({
    url: '/blog/neighbors/add',
    method: 'post',
    data
  })
}

export function updateNeighbor(data) {
  return request({
    url: '/blog/neighbors/update',
    method: 'post',
    data
  })
}

export function delNeighbor(data) {
  return request({
    url: '/blog/neighbors/del',
    method: 'post',
    data
  })
}
