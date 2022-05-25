export const state = () => ({
  currentLocale: 'ar',
  accessToken: null,
  authUser: null,
  role: null,
  forgetMail: null,
  settings: null,
  firebaseToken: null // you need in login and log out
})

export const getters = {
  currentLocale(state) {
      return state.currentLocale;
  },
  accessToken(state) {
    return state.accessToken;
  },
  role(state) {
    return state.role;
  },
  authUser(state) {
    return state.authUser;
  },
  forgetMail (state) {
    return state.forgetMail
  },
  settings (state) {
    return state.settings
  },
  firebaseToken (state) {
    return state.firebaseToken
  }
}

export const mutations = {
  SET_CURRENT_LOCALE(state, payload) {
      state.currentLocale = payload;
  },
  SET_ACCESS_TOKEN(state, payload) {
    state.accessToken = payload;
  },
  SET_ROLE(state, payload) {
    state.role = payload;
  },
  SET_AUTH_USER(state, payload) {
    state.authUser = payload;
  },
  SET_FORGET_MAIL(state, payload) {
    state.forgetMail = payload;
  },
  SET_SETTINGS(state, payload) {
    state.settings = payload;
  },
  SET_FIREBASE_TOKEN(state, payload) {
    debugger
    state.firebaseToken = payload;
  },
  RESET_DATA (st) {
    // acquire initial state
    // https://github.com/vuejs/vuex/issues/1118
    const states = (({ accessToken, authUser, role, forgetMail, firebaseToken }) => ({
      accessToken, authUser, role, forgetMail, firebaseToken
    }))(state());

    Object.keys(states).forEach((key) => {
      st[key] = states[key]
    })
    this.$cookies.remove('accessToken')
    this.$cookies.remove('role')
  }
}
