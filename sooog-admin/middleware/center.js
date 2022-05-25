export default ({app, redirect, store}) => {
  //debugger
  if (process.client) {
    if (!store.state.localStorage.centerToken) {
      return redirect(app.localePath('centers-auth-login'))
    }
  } else {
    //if (!(app.$cookies.get("mokayiefyToken") && app.$cookies.get("role") == 'super_admin')) {
    if (!app.$cookies.get("centerToken")) {
      return redirect(app.localePath('centers-auth-login'))
    }
  }
}
