import request from '@/utils/request'

export function upBase64(data) {
  return request({
    url: 'admin/Uploads/determineBase64',
    method: 'post',
    data
  })
}
