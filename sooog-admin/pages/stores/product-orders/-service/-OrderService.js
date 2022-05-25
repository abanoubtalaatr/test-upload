import ApplicationService from '@/services/ApplicationService'

class OrderService extends ApplicationService{
  resource = '/store/orders'
  //* **************************************************** *//
  async getAll (queryParam = {}) {
    return await this.get(`${this.resource}${queryParam}`)
  }

  async listPaymentMethods () {
    return await this.get('/store/payment-methods')
  }

  async listStatuses (type='orders') {
    return await this.get(`/store/statuses?type=${type}`)
  }

  async update (data, id) {
    return await this.put(`${this.resource}/${id}`, data)
  }

  async updateService (data, id) {
    return await this.put(`${this.resource}/service/${id}`, data)
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

  async refund (data, id) {
    return await this.post(`${this.resource}/${id}/refund`, data)
  }
  //* **************************************************** *//
}
export default new OrderService
