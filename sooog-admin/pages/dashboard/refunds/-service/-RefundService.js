import ApplicationService from '@/services/ApplicationService'

class RefundService extends ApplicationService{
  resource = '/admin/refunds'
  //* **************************************************** *//
  async getAll (queryParam = {}) {
    return await this.get(`${this.resource}${queryParam}`)
  }

  async update (data, id) {
    return await this.put(`${this.resource}/${id}`, data)
  }

  async changeStatus (id, data = {}) {
    return await this.put(`${this.resource}/${id}/change-status`, data)
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
export default new RefundService
