export default ({app, redirect, store}) => {
  if (process.client) {
    if (!store.state.localStorage.accessToken) {
      return redirect(app.localePath('login'))
    }
  } else {
    if (!(app.$cookies.get("accessToken") && app.$cookies.get("role") == 'client')) {
      return redirect(app.localePath('login'))
    }
  }
}
