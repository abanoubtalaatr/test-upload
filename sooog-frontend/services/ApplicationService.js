import extend from 'lodash/extend'

class ApplicationService {
  get (path, params = {}, extraConf = {}) {
    return this.request(path, 'GET', params, extraConf)
  }

  post (path, data, extraConfig = {}) {
    return this.request(path, 'POST', data, extraConfig)
  }

  put (path, data, extraConf = {}) {
    return this.request(path, 'PUT', data, extraConf)
  }

  delete (path, data = {}, extraConf = {}) {
    return this.request(path, 'DELETE', data, extraConf)
  }

  extraResp (response) {
    const data = (response && response.data) || {}
    return (data && data.data) || { err: true, code: data.code, message: data.message }
  }

  async request (path, method = 'GET', paramsData = {}, extraConfig = {}) {

    const config = extend({ method, url: path, responseType: 'json', data: paramsData }, extraConfig)

    const response = await $nuxt.$axios(config)
    return response.data

  }
}

export default ApplicationService
