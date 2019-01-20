import request from '@/utils/request'

export function getList(tagID,userID,page,limit) {
  return request({
    url: 'blogApi/article/getList',
    method: 'get',
    params: { tagID, userID, page ,limit }
  })
}

export function getOne(ID) {
  return request({
    url: 'blogApi/article/getOne',
    method: 'get',
    params: { ID }
  })
}
