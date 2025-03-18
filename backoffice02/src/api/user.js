import request from '@/utils/request'

export function loginApi(data) {
  return request({
    url: 'reqAccount.php',
    method: 'post',
    data: "username="+data.username+"&password="+data.password
  })
}

export function getInfoApi(token) {
  return request({
    url: 'reqUserInfo.php',
    method: 'get',
    params: { token:token }
  })
}

export function logoutApi(token) {
  return request({
    url: 'reqlogout.php',
    method: 'post',
    data:"token="+token,
  })
}
