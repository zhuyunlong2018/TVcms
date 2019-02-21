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

export function getAll(query=null) {
  return request({
    url: '/blogApi/article/getAllPublished',
    method: 'get',
    params: query
  })
}

export function getTitleList(query=null) {
  return request({
    url: '/blogApi/article/getTitleList',
    method: 'get',
    params: query
  })
}

export function changePublish(data) {
  return request({
    url: '/blogApi/article/changePublish',
    method: 'post',
    data
  })
}

export function delArticle(data) {
  return request({
    url: '/blogApi/article/del',
    method: 'post',
    data
  })
}

export function addArticle(data) {
  return request({
    url: '/blogApi/article/add',
    method: 'post',
    data
  })
}

export function updateArticle(data) {
  return request({
    url: '/blogApi/article/update',
    method: 'post',
    data
  })
}