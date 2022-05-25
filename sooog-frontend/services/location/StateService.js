import ApplicationService from '@/services/ApplicationService'

class StateService extends ApplicationService{
  resource = '/location/states'

  //* **************************************************** *//
  async getAll (id) {
    return await this.get(`/location/states?country=${id}`)
  }

  async create (data) {
    return await this.post(`${this.resource}`, data)
  }

  async update (data, id) {
    return await this.put(`${this.resource}/${id}`, data)
  }

  async toggleStatus (id, data = {}) {
    return await this.put(`${this.resource}/${id}/toggle-status`, data)
  }

  async show (id) {
    return await this.get(`${this.resource}/${id}`)
  }

  async destroy (id) {
    return await this.delete(`${this.resource}/${id}`)
  }

  async excelExport (queryParam = {}) {
    return await this.get(`${this.resource}/exports${queryParam}`, {}, {responseType: 'arraybuffer'})
  }
  //* **************************************************** *//
}
export default new StateService
