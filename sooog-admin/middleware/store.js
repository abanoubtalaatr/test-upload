export default ({app, redirect, store}) => {
  debugger
  if (process.client) {
    if (!store.state.localStorage.storeToken) {
      return redirect(app.localePath('stores-auth-login'))
    }
  } else {
    //if (!(app.$cookies.get("mokayiefyToken") && app.$cookies.get("role") == 'super_admin')) {
    if (!app.$cookies.get("storeToken")) {
      return redirect(app.localePath('stores-auth-login'))
    }
  }
}
