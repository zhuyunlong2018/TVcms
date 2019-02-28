import request from '@/utils/request'

export function getList(query) {
  return request({
    url: '/blog/article/getList',
    method: 'get',
    params: query
  })
}

export function getOne(ID) {
  return request({
    url: '/blog/article/getOne',
    method: 'get',
    params: { ID }
  })
}

export function getAll(query=null) {
  return request({
    url: '/blog/article/getAllPublished',
    method: 'get',
    params: query
  })
}

export function getTitleList(query=null) {
  return request({
    url: '/blog/article/getTitleList',
    method: 'get',
    params: query
  })
}

export function changePublish(data) {
  return request({
    url: '/blog/article/changePublish',
    method: 'post',
    data
  })
}

export function delArticle(data) {
  return request({
    url: '/blog/article/del',
    method: 'post',
    data
  })
}

export function addArticle(data) {
  return request({
    url: '/blog/article/add',
    method: 'post',
    data
  })
}

export function updateArticle(data) {
  return request({
    url: '/blog/article/update',
    method: 'post',
    data
  })
}

export function getBing(query=null) {
  return request({
    url: '/blog/article/getBing',
    method: 'get',
    params: query
  })
}
