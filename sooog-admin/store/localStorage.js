export const state = () => ({
  currentLocale: 'en',
  mokayiefyToken: null,
  mokayiefyPermissions: "[]",
  mokayiefyData: null,
  storeToken: null,
  storePermissions: "[]",
  storeData: null,
  centerToken: null,
  centerPermissions: "[]",
  centerData: null,
  role: null,
  forgetMail: null,
  adminFirebaseToken: null,
  storeFirebaseToken: null
})

export const getters = {
  currentLocale(state) {
      return state.currentLocale;
  },
  mokayiefyToken(state) {
    return state.mokayiefyToken;
  },
  mokayiefyPermissions(state) {
    return state.mokayiefyPermissions;
  },
  mokayiefyData(state) {
    return state.mokayiefyData;
  },
  storeToken(state) {
    return state.storeToken;
  },
  storePermissions(state) {
    return state.storePermissions;
  },
  storeData(state) {
    return state.storeData;
  },
  centerToken(state) {
    return state.centerToken;
  },
  centerPermissions(state) {
    return state.centerPermissions;
  },
  centerData(state) {
    return state.centerData;
  },
  role(state) {
    return state.role;
  },
  forgetMail (state) {
    return state.forgetMail
  },
  storeFirebaseToken (state) {
    return state.storeFirebaseToken
  },
  adminFirebaseToken (state) {
    return state.adminFirebaseToken
  }

}

export const mutations = {
  SET_CURRENT_LOCALE(state, payload) {
      state.currentLocale = payload;
  },
  SET_MOKAYIEFY_TOKEN(state, payload) {
    state.mokayiefyToken = payload;
  },
  SET_MOKAYIEFY_PERMISSIONS(state, payload) {
    state.mokayiefyPermissions = payload;
  },
  SET_MOKAYIEFY_DATA(state, payload) {
    state.mokayiefyData = payload;
  },
  SET_STORE_TOKEN(state, payload) {
    state.storeToken = payload;
  },
  SET_STORE_PERMISSIONS(state, payload) {
    state.storePermissions = payload;
  },
  SET_STORE_DATA(state, payload) {
    state.storeData = payload;
  },

  SET_CENTER_TOKEN(state, payload) {
    state.centerToken = payload;
  },
  SET_CENTER_PERMISSIONS(state, payload) {
    state.centerPermissions = payload;
  },
  SET_CENTER_DATA(state, payload) {
    state.centerData = payload;
  },
  SET_ROLE(state, payload) {
    state.role = payload;
  },
  SET_FORGET_MAIL(state, payload) {
    state.forgetMail = payload;
  },
  SET_STORE_FIREBASE_TOKEN(state, payload) {
    debugger
    state.storeFirebaseToken = payload;
  },
  SET_ADMIN_FIREBASE_TOKEN(state, payload) {
    debugger
    state.adminFirebaseToken = payload;
  },
  RESET_MOKAYIEFY (st) {
    // acquire initial state
    // https://github.com/vuejs/vuex/issues/1118
    // const states = state();

    const states = (({ mokayiefyToken, mokayiefyPermissions, mokayiefyData,adminFirebaseToken }) => ({
      mokayiefyToken, mokayiefyPermissions, mokayiefyData,adminFirebaseToken
    }))(state());

    Object.keys(states).forEach((key) => {
      st[key] = states[key]
    })
    this.$cookies.remove('mokayiefyToken')
    this.$cookies.remove('permissions')
    // this.$cookies.remove('role')
  },
  RESET_STORE (st) {
    const states = (({ storeToken, storePermissions, storeData,storeFirebaseToken }) => ({
      storeToken, storePermissions, storeData,storeFirebaseToken
    }))(state());

    Object.keys(states).forEach((key) => {
      st[key] = states[key]
    })
    this.$cookies.remove('storeToken')
    this.$cookies.remove('storePermissions')
    // this.$cookies.remove('role')
  },
  RESET_CENTER (st) {
    const states = (({ centerToken, centerPermissions, centerData }) => ({
      centerToken, centerPermissions, centerData
    }))(state());

    Object.keys(states).forEach((key) => {
      st[key] = states[key]
    })
    this.$cookies.remove('centerToken')
    this.$cookies.remove('centerPermissions')
    // this.$cookies.remove('role')
  }
}
