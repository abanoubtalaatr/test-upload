import ApplicationService from '@/services/ApplicationService'

class PackageService extends ApplicationService{
  resource = '/store/packages'
  //* **************************************************** *//
  async getAll (queryParam = {}) {
    return await this.get(`${this.resource}${queryParam}`)
  }

  async subscribe (data) {
    return await this.post(`${this.resource}/subscribe`, data)
  }

  // async update (data, id) {
  //   return await this.put(`${this.resource}/${id}`, data)
  // }
  //
  // async toggleStatus (id, data = {}) {
  //   return await this.put(`${this.resource}/${id}/toggle-status`, data)
  // }

  async show (id) {
    return await this.get(`${this.resource}/${id}`)
  }

  async allOnlineMethods () {
    return await this.get(`store/online-payment-methods`)
  }

  // async destroy (id) {
  //   return await this.delete(`${this.resource}/${id}`)
  // }
  //
  // async excelExport (queryParam = {}) {
  //   return await this.get(`${this.resource}/exports${queryParam}`, {}, {responseType: 'arraybuffer'})
  // }
  //* **************************************************** *//
}
export default new PackageService
