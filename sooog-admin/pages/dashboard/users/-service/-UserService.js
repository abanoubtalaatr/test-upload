import ApplicationService from '@/services/ApplicationService'

class UserService extends ApplicationService{
  resource = '/admin/users'
  //* **************************************************** *//
  async getAll (queryParam = {}) {
    return await this.get(`${this.resource}${queryParam}`)
  }

  async toggleStatus (id, data = {}) {
    return await this.put(`${this.resource}/${id}/toggle-status`, data)
  }
  async updateStatus (id, data = {}) {
    return await this.put(`${this.resource}/${id}`, data)
  }

  async show (id) {
    return await this.get(`${this.resource}/${id}`)
  }

  async listAddresses (id) {
    return await this.get(`${this.resource}/${id}/addresses`)
  }

  async excelExport (queryParam = {}) {
    return await this.get(`${this.resource}/export-to-excel${queryParam}`, {}, {responseType: 'arraybuffer'})
  }

  async createTransaction (id, data) {
    return await this.post(`${this.resource}/${id}/transactions`, data)
  }

  async listTransactions(id, queryParam = {}){
    return await this.get(`${this.resource}/${id}/transactions${queryParam}`)
  }
  //* **************************************************** *//
}
export default new UserService
