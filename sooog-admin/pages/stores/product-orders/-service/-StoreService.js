import ApplicationService from '@/services/ApplicationService'

class StoreService extends ApplicationService{
  resource = '/store/stores'
  //* **************************************************** *//
  async getAll (queryParam = {}) {
    return await this.get(`${this.resource}${queryParam}`)
  }

  async setFeaturedStores (data) {
    return await this.post(`${this.resource}/featured`, data)
  }

  async toggleStatus (id, data = {}) {
    return await this.put(`${this.resource}/${id}/toggle-status`, data)
  }
  async updateStatus (id, data = {}) {
    return await this.put(`${this.resource}/${id}`, data)
  }

  async update (id, data = {}) {
    return await this.put(`${this.resource}/${id}`, data)
  }

  async show (id) {
    return await this.get(`${this.resource}/${id}`)
  }

  async destroy (id) {
    return await this.delete(`${this.resource}/${id}`)
  }

  async excelExport (queryParam = {}) {
    return await this.get(`${this.resource}/export-to-excel${queryParam}`, {}, {responseType: 'arraybuffer'})
  }
  //* **************************************************** *//
}
export default new StoreService
