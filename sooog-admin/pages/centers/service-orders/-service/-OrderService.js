import ApplicationService from '@/services/ApplicationService'

class OrderService extends ApplicationService{
  resource = '/center/orders'
  //* **************************************************** *//
  async getAll (queryParam = {}) {
    return await this.get(`${this.resource}${queryParam}`)
  }

  async filterOrders (data) {
    return await this.get(`${this.resource}`, {params: data})
  }

  async listPaymentMethods () {
    return await this.get('/center/payment-methods')
  }

  async listStatuses () {
    return await this.get('/center/statuses')
  }

  async update (data, id) {
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
