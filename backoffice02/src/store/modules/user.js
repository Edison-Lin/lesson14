import { loginApi, logoutApi, getInfoApi } from '@/api/user'
import { getToken, setToken, removeToken,removeEcUrl } from '@/utils/auth'
import {MD5} from '@/utils/commlib'
import { resetRouter } from '@/router'

const getDefaultState = () => {
  return {
    token: getToken(),  //登入後從伺服器取得token
    name: '',         //管理者名稱
    avatar: '',       //頭像圖檔
    person:[],        //管理者登入後個人資訊存放區
  }
}

const state = getDefaultState()

const mutations = {
  RESET_STATE: (state) => {
    Object.assign(state, getDefaultState())
  },
  SET_TOKEN: (state, token) => {
    state.token = token
  },
  SET_NAME: (state, name) => {
    state.name = name
  },
  SET_AVATAR: (state, avatar) => {
    state.avatar = avatar
  },
  // 加入管理者資訊寫入state
  SET_PERSON: (state, person) => {
    state.person = person;
  },
}

const actions = {
  // login()為處理管理者帳密到伺服器認證請求
  async login({ commit }, userInfo) {
    const { username, password } = userInfo; // 取得登入頁的管理者帳密
    //呼叫src/api/user.js->loginApi()驗證帳號與密碼
    let result = await loginApi({ username: username.trim(), password: MD5(password)});
    if (result.code == 20000) {       // 當取得返回code==20000時為帳密驗證成功
      //取回帳密確認成功，將TOKEN資料取回填入store欄位
      commit('SET_TOKEN', result.data.token);
      setToken(result.data.token);
      return 'success';
    } else {
      console.log(result);
      return Promise.reject(new Error('faile'));
    }
  },

  // get user info
  async getInfo({ commit, state }) {
    let result = await getInfoApi(state.token); // 當返回code==20000時為token驗證成功
    if (result.code == 20000) {
      commit('SET_PERSON', result.data); //vuex存儲管理者全部資訊
      commit('SET_NAME', result.data.adlogin);
      commit('SET_AVATAR', result.data.avatar);
      return 'success';
    } else {
      return Promise.reject(new Error(result.message));
    }
  },

  // user logout
  //使用者登出頁面，預計清除session資料, token資料
  async logout({ commit, state }) {
    let result = await logoutApi(state.token);
    if (result.code = "20000") {
      removeToken();          // must remove token first
      removeEcUrl();          // must remove token first
      resetRouter();          // 重設系統路由器
      commit('RESET_STATE');   //重設store的所有變數
      return (result);
    } else {
      return Promise.reject(new Error(result.message));
    }
  },

  // remove token
  resetToken({ commit }) {
    return new Promise(resolve => {
      removeToken() // must remove  token  first
      commit('RESET_STATE')
      resolve()
    })
  }
}

export default {
  namespaced: true,
  state,
  mutations,
  actions
}

