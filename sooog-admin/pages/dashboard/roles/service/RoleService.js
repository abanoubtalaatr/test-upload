import ApplicationService from '@/services/ApplicationService'

class CountryService extends ApplicationService{
  resource = '/admin/roles'
  //* **************************************************** *//
  async getAll (queryParam = {}) {
    return await this.get(`${this.resource}${queryParam}`)
  }

  async getPermissions (queryParam = {}) {
    return await this.get(`/admin/permissions${queryParam}`)
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
export default new CountryService
