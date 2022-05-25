export default ({app, redirect, store}) => {
  if (process.client) {
    if (!store.state.localStorage.mokayiefyToken) {
      return redirect(app.localePath('dashboard-auth-login'))
    }
  } else {
    //if (!(app.$cookies.get("mokayiefyToken") && app.$cookies.get("role") == 'super_admin')) {
    if (!app.$cookies.get("mokayiefyToken")) {
      return redirect(app.localePath('dashboard-auth-login'))
    }
  }
}
