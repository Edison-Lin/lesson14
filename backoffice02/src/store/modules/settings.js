import request from '@/utils/request';
import {getEcUrl,setEcUrl} from '@/utils/auth'
import defaultSettings from '@/settings'

const { showSettings, fixedHeader, sidebarLogo,ecPlatForm } = defaultSettings

const state = {
  showSettings: showSettings,
  fixedHeader: fixedHeader,
  sidebarLogo: sidebarLogo,
  ecPlatForm:ecPlatForm,
}

const mutations = {
  CHANGE_SETTING: (state, { key, value }) => {
    // eslint-disable-next-line no-prototype-builtins
    if (state.hasOwnProperty(key)) {
      state[key] = value
    }
  },
  //將電商路徑存入store
  EC_PATH: (state, data) => {
    state.ecPlatForm.db_Url = data.db_Url;
    state.ecPlatForm.ec_Url = data.ec_Url;
  }
}

const actions = {
  changeSetting({ commit }, data) {
    commit('CHANGE_SETTING', data)
  },
  //在./public目錄取得ec_path.html前台電商與後台以及資料庫路徑設定檔
  async ec_Path({ commit }) {
    let result = await request({ url: `./ec_path.html`, method: 'GET' });
    if (result.code == 200) {
      commit('EC_PATH', result);  //將路徑存入store
      setEcUrl(result);   //將路徑存入cookies
      return true;
    }
  },
  //在路徑有存入cookies，直接取出，存入store
  getEc_Cookies({ commit }) {
    let result = { db_Url: getEcUrl("db_Url"), ec_Url: getEcUrl("ec_Url"), };
    commit('EC_PATH', result);
    return true;
  }
}

export default {
  namespaced: true,
  state,
  mutations,
  actions
}

