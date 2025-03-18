const getters = {
  sidebar: state => state.app.sidebar,
  device: state => state.app.device,
  token: state => state.user.token,
  avatar: state => state.user.avatar,
  name: state => state.user.name,
  // 增加管理者個人資訊到getters
  person: state => state.user.person,
  db_Url: state => state.settings.ecPlatForm.db_Url,
  ec_Url: state => state.settings.ecPlatForm.ec_Url,
}
export default getters
