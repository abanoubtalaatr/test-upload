
export default function ({ context, $axios, redirect, store, req, app, beforeNuxtRender, env }) {

  $axios.setBaseURL(`http://localhost:8000/api`)
  // $axios.setBaseURL(`http://makefy.fudex-tech.net/mokayiefy-backend/public/api`)
  // $axios.setBaseURL(`https://soog.fudex-tech.net/sooog-backend/public/api`)
  // $axios.setBaseURL(`https://mukyfy.com/mokayiefy-backend/public/api`)
  function getHeaders (config) {
    //** check for admin authentication or front */
    let accessToken = null
    let prefix = config.url.split('/')
    if (prefix.includes('admin')) {

      accessToken = app.$cookies.get("mokayiefyToken")

    } else if (prefix.includes('store')) {

      accessToken = app.$cookies.get("storeToken")

    } else if (prefix.includes('center')) {

      accessToken = app.$cookies.get("centerToken")
    }
    const headers = {
      'Accept': 'application/json',
      'Content-Type': 'application/json',
      'Access-Control-Allow-Origin': '*',
      'Accept-Language': app.i18n.locale
    }
    headers.Authorization =  accessToken || ''
    return headers
  }

  // Add a request interceptor
  $axios.interceptors.request.use(function (config) {
    // Do something before request is sent
    config.headers = getHeaders(config)

    return config
  }, function (error) {
    // Do something with request error
    return Promise.reject(error)
  })

  // Add a response interceptor
  $axios.interceptors.response.use(function (response) {
    // Do something with response data
    return Promise.resolve(response)
  }, function (error) {
    const err = error.response.data
    const baseUrl = error.response.config.url.split('/')
    //* generic error *//
    // console.log(error.response)
    //debugger
    app.$toast.error(err.error)
    if (error.response.status == 403) {
      if (baseUrl.includes('admin'))
        return redirect(app.localePath('dashboard-auth-login'))
      else if (baseUrl.includes('store'))
        return redirect(app.localePath('stores-auth-login'))
      else if (baseUrl.includes('center'))
        return redirect(app.localePath('centers-auth-login'))
    }
    // Do something with response error
    return Promise.reject(err)
  })

}
