import Cookies from 'js-cookie'

const TokenKey = 'vue_admin_template_token'
const DbUrl='DbUrl';
const EcUrl='EcUrl';

export function getToken() {
  return Cookies.get(TokenKey)
}

export function setToken(token) {
  return Cookies.set(TokenKey, token)
}

export function removeToken() {
  return Cookies.remove(TokenKey)
}
//從cookies讀取電商路徑
export function getEcUrl(retcode='db_Url') {
  let cookData;
  switch (retcode){
    case 'db_Url':
      cookData=Cookies.get(DbUrl);
      break;
    case 'ec_Url':
      cookData=Cookies.get(EcUrl);
      break;
  };
  return (cookData);
}
//將電商路徑存入cookies
export function setEcUrl(serverUrl) {
  Cookies.set(DbUrl, serverUrl.db_Url);
  Cookies.set(EcUrl, serverUrl.ec_Url);
  return ;
}
//從cookies移除電商路徑
export function removeEcUrl() {
  Cookies.remove(DbUrl);
  Cookies.remove(EcUrl);
  return 
}
